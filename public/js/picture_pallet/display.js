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
	if(this.data == ""){
		this.write = 'Test has not started';
		return;
	}

	for(var i=0; i<this.data.length; i++){
		if(this.data[i] != ''){
			this.write += '<img src="'+this.data[i]+'" class="img-polaroid" />';
		}
	}
	
	
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