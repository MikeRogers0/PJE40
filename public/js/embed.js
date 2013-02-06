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
	xhr.open('GET', '/tests/getTest', false);
	xhr.send();
	
	if (xhr.status === 200) {
		this.data = JSON.parse(xhr.response);
	}
	
	// Decode the data & set it somewhere.
	this.openThread();
};

/**
 * Open the web worker & pass it the data it needs.
 */
pj40App.prototype.openThread = function(){
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
		console.log('Log: ', e.data);
	}else if(e.data.cmd == 'completed'){
		// close the worker and get a new test
		
		console.log('Completed: ', e.data);
		
		// Save the results
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '/tests/updateTest/'+this.data.crunch.id, false);
		
		// Define the form data we are posting
		var formdata = new FormData();
		formdata.append('Crunches[authkey]', this.data.crunch.authkey);
		formdata.append('Crunches[crunch_number]', this.data.crunch.crunch_number);
		formdata.append('Crunches[result]', JSON.stringify(e.data.data));
		
		xhr.send(formdata);
	}
}


app = new pj40App();

/**
 * Start the processing.
 */
app.start();



 

