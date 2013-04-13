/**
 * Make the debugger function
 */
function debug(message, data){
	if(config.debug == true){
		config.debugElm.innerHTML = '<p>'+message+': '+data+'</p>'+config.debugElm.innerHTML;
		console.log(message, data);
	}
}

/**
 * Get the microtime.
 * From: http://jeffrey-kohn.com/code/javascript-equivalent-phps-microtime
 */
function microtime(get_as_float){
    var unixtime_ms = new Date().getTime();
    var sec = parseInt(unixtime_ms / 1000);
    return get_as_float ? (unixtime_ms/1000) : (unixtime_ms - (sec * 1000))/1000 + ' ' + sec;
}
 
/**
 * Define the core app function
 */
var pj40App = function(){
	this.data = false;
	this.worker = false;
};

/**
 * Start a new thread for processing.
 * If a test is in progress, continue with that or get a new test to do.
 */
pj40App.prototype.start = function(){
	if(localStorage['lastCheckin']){
		// If another thread has checked in, tell the code
		if(localStorage['lastCheckin'] >= ((new Date() * 1) - (config.checkinDelay * 2))){
			// See if we can run in 5 minutes time.
			debug('Event', 'Another instance is running');
			
			setTimeout(function(){app.start();}, config.checkinDelay * 5);
			return false;
		}
	}

	// Lets make sure no other crunchers start
	this.checkin();
	
	this.startSocket();
};

/**

 * Checks if the app has been working on something previously it didn't finish.
 */
pj40App.prototype.hasUnfinishedBusiness = function(){
	return false;
}

/**
 * Opens the socket to the server to start recieving stuff
 */
pj40App.prototype.startSocket = function(){
	// Connect to the socket.
	socket = io.connect('http://pje40.local:1337');
	socket.emit('ready'); // Tell it were ready.
	
	debug('Socket', 'Connected')
	
	if(this.hasUnfinishedBusiness()){
		this.openThread();
	}
	
	// When a task is ready, we will recieve it.
	socket.on('taskReady', function (data) {
		//save the data.
		app.data = data;
		
		app.openThread();
	});
}

/**
 * Checkin the application so we don't kill the users machine.
 */
pj40App.prototype.checkin = function (){
	localStorage['lastCheckin'] = (new Date() * 1);
	setTimeout(function(){app.checkin();}, config.checkinDelay);
};

/**
 * Open the web worker & pass it the data it needs.
 */
pj40App.prototype.openThread = function(){
	debug('Event', 'Starting test '+this.data.test.name+' (Crunch Number: '+this.data.crunch.crunch_number+')');
	this.data.crunch.crunch_started = microtime(true);
	this.worker = new Worker(this.data.test.crunch_file);
	this.worker.addEventListener('message', function(e){app.responseThread(e);}, false);
	this.worker.addEventListener('error', function(e){app.responseThread(e);}, false);
	
	this.worker.postMessage({'cmd': 'start', 'data': this.data});
};

/**
 * Handle responses from the threads.
 */
pj40App.prototype.responseThread = function(e){
	// e.cmd = the reply topic.
	
	/*if(e.data.cmd == 'save'){
		// Save the data to the thread.
	}else */
	
	if(e.data.cmd == 'log'){
		// Relay information.
		debug('Log (From Thread)', e.data);
	}else if(e.data.cmd == 'completed'){
		// close the worker and get a new test
		
		debug('Completed (From Thread)', e.data);
		this.data.crunch.time_processing = (microtime(true) - this.data.crunch.crunch_started);
		
		socket.emit('save', {test: this.data.test, crunch: this.data.crunch, result: JSON.stringify(e.data.data)});
	}
}


app = new pj40App();

/**
 * Start the processing.
 */
app.start();



 


