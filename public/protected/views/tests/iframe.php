<!--
	Load in the JS files which make this project run.
-->
<script src="http://pje40.local:1337/socket.io/socket.io.js"></script>
</script>

<pre id="debug">
	
</pre>
<script>
/**
 * Define the config 
 */
var config = {
	checkinDelay: 60,
	testDelay: 500,
	debug: <?php echo $debug; ?>,
	domain: 'pje40.local',
	debugElm: document.getElementById('debug')
};
var app = {};
var socket = {};
</script>
<script src="/js/embed.js"></script>


