/**
 * Define a few veriables
 */
var displayer = false;

/**
 * Define the object were going to process the data with.
 */
function Displayer(){
	this.data = false; // The data from the server
	this.write = '';
}

/**
 * When the start command is issued.
 */
Displayer.prototype.run = function(){
	this.write = this.data[0].threadsProcessed + ' Things processed';
	
	self.postMessage({'cmd': 'write','data': this.write});
	self.close();
}

displayer = new Displayer();


/**
 * This is an example of the main calls you will recieve.
 */
self.addEventListener('message', function(e) {
	if(e.data.cmd == 'start'){
		displayer.data = e.data.data;
		self.postMessage({'cmd': 'log','data': 'Starting'});
		displayer.run();
	}
}, false);