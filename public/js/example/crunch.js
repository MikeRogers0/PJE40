/**
 * Define a few veriables
 */
var cruncher = false;

/**
 * From: http://jeffrey-kohn.com/code/javascript-equivalent-phps-microtime
 */
function microtime(get_as_float){
    var unixtime_ms = new Date().getTime();
    var sec = parseInt(unixtime_ms / 1000);
    return get_as_float ? (unixtime_ms/1000) : (unixtime_ms - (sec * 1000))/1000 + ' ' + sec;
}

/**
 * Define the object were going to process the data with.
 */
function Cruncher(){
	this.data = false; // The data from the server
	this.crunch_number = 0; // The thread number
	this.threads = 10; // the total amount of threads
	
	this.endCallback = this.end; // The callback which runs when the crunching is done.
	
	this.results = {};
	this.results.startTime = false;
	this.results.endTime = false;
	this.results.threadsProcessed = 0;
}

/**
 * When the start command is issued.
 */
Cruncher.prototype.run = function(){
	this.results.startTime = microtime(true);
	
	//this.data.crunch;
	self.postMessage({'cmd': 'log','data': this.data});
	
	// Update the crunch number.
	this.crunch_number = this.data.crunch.crunch_number; // this is normally like 1-10
	
	for(var i = this.crunch_number; i<100000; i += this.threads){
		this.someProcessing();
	}
	
	setTimeout(function(){cruncher.endCallback();}, 1000);
}

/**
 * The loopy bit.
 */
Cruncher.prototype.someProcessing = function(){
	// Something time consumsing here.
	var someNumber = Math.floor(Math.random() * Math.random() * Math.random() * Math.random());
	
	this.results.threadsProcessed++; // In this case just increase the results number.
}

/**
 * When we are done processing.
 */
Cruncher.prototype.end = function(){
	this.results.endTime = microtime(true);
	
	// Close this thread.
	self.postMessage({'cmd': 'completed','data': this.results});
	self.close();
}


cruncher = new Cruncher();


/**
 * This is an example of the main calls you will recieve.
 */
self.addEventListener('message', function(e) {
	if(e.data.cmd == 'start'){
		cruncher.data = e.data.data;
		self.postMessage({'cmd': 'log','data': 'Starting'});
		cruncher.run();
	}
}, false);