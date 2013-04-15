/**
 * Based Upon: http://instantsolve.net/mandelbrot.htm
*/

var Canvas = function (id, width, height, zindex) {
    var c = document.createElement("canvas");
    c.setAttribute("width", width);
    c.setAttribute("height", height);
    c.setAttribute("id", id);
    config.wrapper.innerHTML = "";
    config.wrapper.appendChild(c);
    return c.getContext("2d");
}
var sx = 300;
var sy = 240;

ctx = new Canvas("c1", sx, sy, 1);
ctx.fillStyle = "#FFF";
ctx.fillRect(0, 0, sx, sy);

var data = ctx.getImageData(0, 0, sx, sy);

// combine both threads
for(var t in config.results){
	for(var i in config.results[t]){
		data.data[i] = config.results[t][i];
	}
}

ctx.putImageData(data, 0, 0);