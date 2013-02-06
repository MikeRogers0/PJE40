var pj40View = function(){
	this.worker = false;
};

pj40View.prototype.run = function(){
	this.worker = new Worker(config.display_file);
	this.worker.addEventListener('message', function(e){view.responseThread(e);}, false);
	this.worker.addEventListener('error', function(e){view.responseThread(e);}, false);
	
	this.worker.postMessage({'cmd': 'start', 'data': config.results});
}

pj40View.prototype.responseThread = function(e){
	if(e.data.cmd == 'log'){
		// Relay information.
		console.log('Log: ', e.data);
	}else if(e.data.cmd == 'write'){
		config.wrapper.className = ''; // Remove the loading class.
		config.wrapper.innerHTML = e.data.data;
	}
}

var view = new pj40View();

view.run();