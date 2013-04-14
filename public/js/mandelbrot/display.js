/**
 * From: http://instantsolve.net/mandelbrot.htm
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

var sx = 150;
var sy = 150;
var threads = 1;
var max_iteration, MinX, MaxX, MinY, MaxY, dx, dy, ctx;

points = new Array();
ctx = new Canvas("c1", sx, sy, 1);
max_iteration = 100;
X = parseFloat(0);
Y = parseFloat(0) * -1;
Zoom = parseFloat(1);
Zoom = Zoom * 100;
dx = (MaxX - MinX) / sx;
dy = (MaxY - MinY) / sy;
ctx.fillStyle = "#FFF";
ctx.fillRect(0, 0, sx, sy);

var data = ctx.getImageData(0, 0, sx, sy);

plotSet(0);
//plotSet(1);

ctx.putImageData(data, 0, 0);


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

function plotSet(thread) {
	n = 0;

    scale = 1200 / max_iteration;
    for (var y = sy * -0.5; y < sy * 0.5; y++) {
        for (var x = sx * -0.5; x < sx * 0.5; x++) {
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
            
            data.data[n] = r;
            data.data[n + 1] = g;
            data.data[n + 2] = b;
            
            n = n + 4;
            
            console.log(
            	'n/4 = '+(n / 4)+' at point ('+(x + (sx * 0.5))+', '+(y + (sy * 0.5))+') = '+ (
            		(sy * (y + (sy * 0.5))) + (x + (sx * 0.5))
            	)
            );
            
        }
    }
    
}