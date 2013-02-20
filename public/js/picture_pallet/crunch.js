/**
 * Define a few veriables
 */
var cruncher = false;

/**
 * Define the object were going to process the data with.
 */
function Cruncher(){
	this.data = false; // The data from the server
	this.crunch_number = 0; // The thread number
	
	this.endCallback = this.end; // The callback which runs when the crunching is done.
	
	this.results = {};
}

/**
 * When the start command is issued.
 */
Cruncher.prototype.run = function(){
	
	//this.data.crunch;
	self.postMessage({'cmd': 'log','data': this.data});
	
	// Update the crunch number.
	this.crunch_number = this.data.crunch.crunch_number; // this is normally like 1-10
	
	this.loadImage();
}

/**
 * The loopy bit.
 */
Cruncher.prototype.loadImage = function(){
	var xhr = new XMLHttpRequest();
	xhr.open('GET', '/js/picture_pallet/images/'+this.crunch_number+'.jpeg', false);
	xhr.send();
	
	this.results = '';
	if (xhr.status === 200) {
		this.results = '/js/picture_pallet/images/'+this.crunch_number+'.jpeg';
		//xhr.response;
	}
	this.endCallback();
}

/**
 * When we are done processing.
 */
Cruncher.prototype.end = function(){
	
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