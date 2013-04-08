// Set up the requires
var 
	// MySQL is the DB on the server. Library is https://github.com/felixge/node-mysql 
	mysql = require('mysql'),
	db = mysql.createConnection({
		host     : 'localhost',
		user     : 'pje40',
		password : 'pje40',
		database: 'pje40',
	}),
	
	// The Socket.io libary from http://socket.io/
	io = require('socket.io').listen(1337),
	
	// List of users ready for tests
	idleUsers = {},
	activeUsers = {};
	
db.connect();

io.sockets.on('connection', function (socket) { 
	// When the user is ready to recieve a test
	socket.on('ready', function () {
		console.log(socket.id + ' Ready');
		idleUsers[socket.id] = socket;
	});
	
	/*socket.on('save', function () {
		console.log(socket.id + ' Save');
		
		// Save the data the user was working on.
		if(activeUsers[socket.id].task == true){
			console.log('The user has a task.');
		}
		
		// Set the user as idle.
		delete activeUsers[socket.id];
		idleUsers[socket.id] = socket;
	});*/
	
	// When the user disconnects remove them from the list
	socket.on('disconnect', function () {
		console.log(socket.id + ' Disconnected');
	
		// If a user was working on something, mark it as failed.
		if(activeUsers[socket.id] != undefined){
			// mark it as failed
			
			delete activeUsers[socket.id];
		}
		
		// If the user is not working on anything and leaves, it's ok.
		if(idleUsers[socket.id] != undefined){
			delete idleUsers[socket.id];
			return;
		}
	});
});

// Check if there is a task to send the user every minute
function updateTasks(){
	var count_idleUsers = 0;
	
	for(var user in idleUsers){
		count_idleUsers++;
	}
	
	console.log('Total Ready Users: ', count_idleUsers);
	
	//if(count_idleUsers >= 1){
		// Do the SQL
		db.query(
			'SELECT tbl_tests.id, (COUNT(tbl_crunches.tbl_tests_id)) AS totalCrunches '+
			'FROM tbl_tests '+
			'LEFT JOIN '+
			'tbl_crunches ON tbl_tests.id = tbl_crunches.tbl_tests_id '+
			'WHERE tbl_tests.completed = 0 '+
			'GROUP BY  tbl_tests.id '+
			'ORDER BY tbl_tests.last_crunched ASC ', 
		function(err, rows) {
			if (err) throw err;
			
			for(var row in rows){
				//console.log(rows[row]);
			
				// Make a crunch & Add it to the DB.
				console.log('Adding in query ', rows[row]);
				query = db.query('INSERT INTO tbl_crunches SET ?', {tbl_tests_id: rows[row].id, crunch_number: (rows[row].totalCrunches + 1)}, function(err, result){
					if (err) throw err;
					//console.log(err, db, result);
				});
				console.log(query.sql);
			}
			
		});
		
		// Anything not being processed, make a few crunches
		
		// Send them to users.
	//}
	
	//setTimeout(updateTasks, 25000);
}
setTimeout(updateTasks, 1000);