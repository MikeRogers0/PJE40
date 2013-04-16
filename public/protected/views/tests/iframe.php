<!--
	Load in the JS files which make this project run.
-->
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
	domain: '<?php echo $_SERVER['SERVER_NAME']; ?>',
	debugElm: document.getElementById('debug')
};
var app = {};
var socket = {};
</script>
<script src="http://<?php echo $_SERVER['SERVER_NAME']; ?>:1337/socket.io/socket.io.js"></script>
<script src="/js/embed.js"></script>


