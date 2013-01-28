/**
 * Define the config 
 */
var config = {
	checkinDelay: 60
};
var app = {};

/**
 * Define the core app function
 */
var pj40App = function(){
	this.testId = false;
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
			window.setTimeout(this.start, config.checkinDelay * 5);
			return false;
		}
	}

	// Lets make sure no other crunchers start
	this.checkin();
	
	if(this.hasUnfinishedBusiness()){
		this.openThread();
	}
	
	// Get the data, when the data is got the thread will open and process the new stuff.
	this.getData();
};

/**
 * Checks if the app has been working on something previously it didn't finish.
 */
pj40App.prototype.hasUnfinishedBusiness = function(){
	return false;
}

/**
 * Checkin the application so we don't kill the users machine.
 */
pj40App.prototype.checkin = function (){
	localStorage['lastCheckin'] = (new Date() * 1);
	window.setTimeout(this.checkin, config.checkinDelay);
};

/** 
 * Pulls data from the main site asking it what we should be processing.
 */
pj40App.prototype.getData = function(){
	var xhr = new XMLHttpRequest();
	xhr.open('GET', '/tests/getATest', false);
	xhr.send();
	
	if (xhr.status === 200) {
	  console.log(xhr.response);
	}
	
	// Decode the data & set it somewhere.
	this.openThread();
};

/**
 * Open the web worker & pass it the data it needs.
 */
pj40App.prototype.openThread = function(){
	//this.worker = new Worker('doWork.js');
	//worker.addEventListener('message', this.responseThread, false);
	
	//worker.postMessage({'cmd': 'stop', 'msg': 'Bye'});
};

/**
 * Handle responses from the threads.
 */
pj40App.prototype.responseThread = function(e){
	// e.reply = the reply topic.
}


app = new pj40App();

/**
 * Start the processing.
 */
app.start();



 


