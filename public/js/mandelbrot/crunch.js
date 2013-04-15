/**
 * Based Upon: http://instantsolve.net/mandelbrot.htm
*/

/**
 * Define a few veriables
 */
var cruncher = false;
var sx = 300;
var sy = 240;


var threads = 10;
var max_iteration, MinX, MaxX, MinY, MaxY, ctx;
max_iteration = 100;
X = parseFloat(-0.5);
Y = parseFloat(0) * -1;
Zoom = parseFloat(0.75) * 100;

/**
 * The mandelbrot functions
 */
 
function calc_pixel(ca, cbi) {
    var iteration = 0;
    var old_a;
    var a = 0,
        b = 0;
    var length;
    do {
        old_a = a;
        a = a * a - b * b + ca;
        b = 2 * old_a * b + cbi;
        iteration++;
        length = a * a + b * b;
    } while ((length < 4) && (iteration < max_iteration));
    return iteration;
}

function plotSet(thread, threads) {
	n = (4 * thread);
	
	var plotdata = {};

    scale = 1200 / max_iteration;
    for (var y = sy * -0.5; y < sy * 0.5; y++) {
        for (var x = (sx * -0.5) + thread; x < sx * 0.5; x+=threads) {
            value = calc_pixel(X + (x / Zoom), Y + (y / Zoom));
            value = (value * scale) + 100;
            if (value < 256) {
                r = 255;
                g = value;
                b = 0;
            } else if (value < 512) {
                r = 511 - value;
                g = 255;
                b = 0;
            } else if (value < 768) {
                r = 0;
                g = 255;
                b = value - 512;
            } else if (value < 1024) {
                r = 0;
                g = 1023 - value;
                b = 255;
            } else if (value < 1280) {
                r = value - 1024;
                g = 0;
                b = 255;
            } else if (value < 1536) {
                r = 255;
                g = 0;
                b = 1535 - value;
            }
            
            // Set the pixel number.
            //n = ((sy * (y + (sy * 0.5))) + (x + (sx * 0.5))) * 4;
            
            plotdata[n] = r;
            plotdata[n + 1] = g;
            plotdata[n + 2] = b;
            plotdata[n + 3] = 255;
            
            n += (4 * threads);
        }
    }
    
    return plotdata;
    
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
}

/**
 * When the start command is issued.
 */
Cruncher.prototype.run = function(){
	
	//this.data.crunch;
	self.postMessage({'cmd': 'log','data': this.data});
	
	// Update the crunch number.
	this.crunch_number = this.data.crunch.crunch_number; // this is normally like 1-10
	
	// Do the mandelbrot set.
	this.results = plotSet(this.crunch_number, this.threads);
	
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