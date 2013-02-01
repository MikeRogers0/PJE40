/**
 * Define a few veriables
 */
var cruncher = false;

/**
 * Define the object were going to process the data with.
 */
function Cruncher(){
	this.data = false;
}

/**
 * When the start command is issued.
 */
Cruncher.prototype.start = function(){
	//this.data.crunch;
}

/**
 * The loopy bit.
 */
Cruncher.prototype.loop = function(){
	
}

/**
 * When we are done processing.
 */
Cruncher.prototype.end = function(){
	// Save the data we processed back to the cloud
	self.postMessage({'cmd': 'save','data': 'YOLO'});
	
	// Close this thread.
	self.postMessage({'cmd': 'completed'});
	self.close();
}


cruncher = new Cruncher();


/**
 * This is an example of the main calls you will recieve.
 */
self.addEventListener('message', function(e) {
	if(e.cmd == 'start'){
		cruncher.data = e.data;
		cruncher.start();
	}
}, false);