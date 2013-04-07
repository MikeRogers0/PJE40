// Set up the requires
var 
	// MySQL is the DB on the server. Library is https://github.com/felixge/node-mysql 
	mysql = require('mysql'),
	// The Socket.io libary from http://socket.io/
	io = require('socket.io').listen(1337),
	// List of users ready for tests
	idleUsers = [],
	activeUsers = [];

io.sockets.on('connection', function (socket) { 
	// When the user is ready to recieve a test
	socket.on('ready', function () {
		console.log({'user': socket, 'status': 'ready'});
		idleUsers[socket] = true;
	});
	
	socket.on('save', function () {
		// Save the data the user was working on.
		if(activeUsers[socket].task == true){
			console.log();
		}
		
		// Set the user as idle.
		delete activeUsers[socket];
		idleUsers[socket] = true;
	});
	
	// When the user disconnects remove them from the list
	socket.on('disconnect', function () {
		// If a user was working on something, mark it as failed.
		if(activeUsers[socket].task == true){
			// mark it as failed
			
			delete activeUsers[socket];
		}
		
		// If the user is not working on anything and leaves, it's ok.
		if(idleUsers[socket] === true){
			delete idleUsers[socket];
			return;
		}
	});
});

// Send a user a task.
