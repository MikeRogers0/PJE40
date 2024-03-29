// Set up the requires
var 
	// MySQL is the DB on the server. Library is https://github.com/felixge/node-mysql 
	mysql = require('mysql'),
	
	// Set up the MySQL DB connection.
	db = mysql.createConnection({
		host     : 'localhost',
		user     : 'pje40',
		password : 'pje40',
		database: 'pje40',
	}),
	
	// The Socket.io libary from http://socket.io/
	io = require('socket.io').listen(1337, { log: false }),
	
	// List of users ready for tests
	idleUsers = {},
	activeUsers = {};

// Connect to the database.
db.connect();

/**
 * Get the microtime.
 * From: http://jeffrey-kohn.com/code/javascript-equivalent-phps-microtime
 */
function microtime(get_as_float){
    var unixtime_ms = new Date().getTime();
    var sec = parseInt(unixtime_ms / 1000);
    return get_as_float ? (unixtime_ms/1000) : (unixtime_ms - (sec * 1000))/1000 + ' ' + sec;
}

// Set up a list of call backs when the server recives a socket connection
io.sockets.on('connection', function (socket) {

	// When the user is ready to recieve a test
	socket.on('ready', function () {
		console.log(socket.id + ' Ready');
		idleUsers[socket.id] = socket;
	});
	
	// When a user has completed a task.
	socket.on('save', function (data) {
		console.log(socket.id + ' Save');
		
		var testID = data.test.id;
		
		data.crunch.time_returned = microtime(true);
		data.crunch.time_latency = (data.crunch.time_returned - data.crunch.time_sent) - data.crunch.time_processing;
		
		// Save the data the user was working on.
		db.query('UPDATE tbl_crunches SET result = ?, time_returned = ?, time_processing = ?, time_latency = ?, completed = 1 WHERE id = ?', [data.result, data.crunch.time_returned, data.crunch.time_processing, data.crunch.time_latency,  data.crunch.id], function(err, result){
			// Update the parent to check if it's completed.
			db.query(
			'UPDATE tbl_tests SET tbl_tests.last_crunched = ? WHERE '+
			'tbl_tests.id = '+db.escape(testID), [new Date()]);
			
			db.query(
			'UPDATE tbl_tests SET tbl_tests.completed = 1 WHERE '+
			'tbl_tests.id = '+db.escape(testID)+' AND (tbl_tests.crunches_required) = ('+
			'SELECT (COUNT(DISTINCT tbl_crunches.crunch_number)) FROM tbl_crunches WHERE tbl_crunches.tbl_tests_id = '+db.escape(testID)+' AND completed = 1'+
			')');
		});
		
		
		// Set the user as idle.
		delete activeUsers[socket.id];
		idleUsers[socket.id] = socket;
	});
	
	// When the user disconnects remove them from the list
	socket.on('disconnect', function () {
		console.log(socket.id + ' Disconnected');
	
		taskFailed(socket, true);
	});
	
	// When a task fails.
	socket.on('failed', function () {
		console.log(socket.id + ' Failed');
	
		taskFailed(socket, false);
	});
});

/**
 * Mark a test as failed.
 */
function taskFailed(socket, disconnected){
	// If a user was working on something, mark it as failed.
	if(activeUsers[socket.id] != undefined){
		// mark it as failed
		
		crunchID = activeUsers[socket.id].crunch_id;
		testID = activeUsers[socket.id].test_id;
		
		db.query('UPDATE tbl_crunches SET result = ?, completed = 3, fails = fails + 1 WHERE id = ?', [JSON.stringify("Failed"),  crunchID], function(err, result){
		// Update the parent to mark it as failedure.
			db.query(
			'UPDATE tbl_tests SET tbl_tests.completed = 2 WHERE '+
			'tbl_tests.id = '+testID+' AND ('+
			'SELECT (sum(tbl_crunches.fails)) FROM tbl_crunches WHERE tbl_crunches.tbl_tests_id = '+testID+' GROUP BY tbl_crunches.tbl_tests_id'+
			') >= 5');
		});
		
		delete activeUsers[socket.id];
	}
	
	if(idleUsers[socket.id] == undefined && disconnected == false){
		idleUsers[socket.id] = socket;
		return;
	}
	
	// If the user is not working on anything and leaves, it's ok.
	if(idleUsers[socket.id] != undefined){
		delete idleUsers[socket.id];
		return;
	}
}

/**
 * Pull up a newly added/failed crunch and sent it to a user.
 */
function sentActiveUserTest(crunchID){
	
	// Select the crunch from the database.
	var query = db.query(
		'SELECT '+
		'tbl_tests.id AS test_id, tbl_tests.name AS test_name, tbl_tests.crunch_file AS test_crunch_file, tbl_crunches.authkey AS crunch_authkey, tbl_crunches.id AS crunch_id, tbl_crunches.crunch_number AS crunch_crunch_number, tbl_crunches.time_sent AS crunch_time_sent '+
		'FROM tbl_tests '+
		'INNER JOIN '+
		'tbl_crunches ON tbl_tests.id = tbl_crunches.tbl_tests_id '+
		'WHERE tbl_crunches.id = '+crunchID+' '+
		'LIMIT 0,1', 
			function(err, crunchAndTest) {
				if (err) throw err;
				
				// Send the crunch we have to the first idle user.
				for(var user in idleUsers){
					// Remove user from idle users list to active.
					activeUsers[user] = idleUsers[user]; 
					delete idleUsers[user];
					
					// Convert the row result to a nice sexy object:
					var SexyCrunch = {
						test: {
							id: crunchAndTest[0].test_id,
							name: crunchAndTest[0].test_name,
							crunch_file: crunchAndTest[0].test_crunch_file
						},
						crunch: {
							authkey: crunchAndTest[0].crunch_authkey,
							id: crunchAndTest[0].crunch_id,
							crunch_number: crunchAndTest[0].crunch_crunch_number,
							time_sent: crunchAndTest[0].crunch_time_sent,
						}
					}
					
					// Make a log of the task being done.
					activeUsers[user].test_id = crunchAndTest[0].test_id;
					activeUsers[user].crunch_id = crunchAndTest[0].crunch_id;
					
					activeUsers[user].emit('taskReady', SexyCrunch);
					
					return;
				}
			});
}


/**
 * This neat function checks if there are users we can send crunches to.
 * If there are, selects an unfinished task
 * then either creates a new crunch in it, or uses a previously failed one
 * Then asks the user to complete it.
 */
function updateTasks(){
	var count_idleUsers = 0;
	
	for(var user in idleUsers){
		count_idleUsers++;
	}
	
	//console.log('Total Idle Users: ', count_idleUsers);
	
	if(count_idleUsers >= 1){
		// Do the SQL to find incomplete tests
		db.query(
			'SELECT tbl_tests.id, tbl_tests.crunches_required, tbl_tests.crunches_required,  (COUNT(DISTINCT tbl_crunches.crunch_number)) AS totalCrunches, (SUM(tbl_crunches.completed = 3)) AS failedCrunches, tbl_crunches.id AS failedCrunch '+
			'FROM tbl_tests '+
			'LEFT JOIN '+
			'tbl_crunches ON tbl_tests.id = tbl_crunches.tbl_tests_id '+
			'WHERE tbl_tests.completed = 0 '+
			'GROUP BY  tbl_tests.id '+
			'ORDER BY tbl_tests.last_crunched ASC LIMIT 0,'+count_idleUsers, 
		function(err, rows) {
			if (err) throw err;
			
			// Loop through the results
			for(var row in rows){
				
				// If their are failed tests, re-run them,
				if(rows[row].failedCrunches >= 1){
					
					//console.log('sending updated test to: '+rows[row].id);
					
					var rowID = rows[row].id;
					
					// Reset the crunches timing data.
					db.query('UPDATE tbl_crunches SET time_sent = ?, authkey = ?, last_activity = ?, completed = 0 WHERE tbl_tests_id = ? AND completed = 3 LIMIT 1', [
						microtime(true),
						parseInt(Math.random() * 320000000),
						new Date(),
						rowID
					], function(err){
						if (err) throw err;
						// Select the ID of the crunch we just updated...
						// I did attempt to get the id from the previous look up, but it proved fruitless.
						db.query('SELECT id FROM tbl_crunches WHERE tbl_tests_id = ? ORDER BY last_activity DESC LIMIT 0,1', [rowID], function(err, reCrunched){
							if (err) throw err;
							sentActiveUserTest(reCrunched[0].id);
						});
					});
					
				}else{
					// Make sure we don't send a crunch we don't need the results for.
					if(rows[row].totalCrunches < rows[row].crunches_required){
						// Make a crunch & Add it to the DB.
						//console.log('Adding in query ', rows[row]);
						
						db.query('INSERT INTO tbl_crunches SET ?', {
							tbl_tests_id: rows[row].id, 
							crunch_number: (rows[row].totalCrunches),
							time_sent: microtime(true),
							authkey: parseInt(Math.random() * 320000000),
							last_activity: new Date(),
							fails: 0
						}, function(err, result){
							if (err) throw err;
							
							sentActiveUserTest(result.insertId);
						});
					}
				}
			}
			
		});
	}
	
	setTimeout(updateTasks, (500));
}
setTimeout(updateTasks, 1000);