<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div class="row">
	<div class="span6">
		
	</div>
</div>
<div class="row">
	<div class="span12">
		<h1>API</h1>
		<p>This application allows you to process javascript files in the cloud via an API</p>
		<p>TODO - Document</p>
		<div class="row">
			<div class="span6">
				<h2>Implemented Features</h2>
				<h3>Staring your crunch</h3>
				<pre><?php
						echo htmlentities("self.addEventListener('message', function(e) {
	if(e.data.cmd == 'start'){
		cruncher.data = e.data.data;
		self.postMessage({'cmd': 'log','data': 'Starting'});
		cruncher.run();
	}
}, false);");
					?></pre>
				<h3>Save a finished crunch</h3>
				<code>
					<?php
						echo htmlentities("
					self.postMessage({'cmd': 'completed','data': this.results});
					");
					?> 
				</code>
				
				<h3>Log data while crunching</h3>
				<code>
					<?php
						echo htmlentities("
					self.postMessage({'cmd': 'log','data': this.data});
					");
					?> 
				</code>
			</div>
			
			<div class="span6">
				<h2>Unimplemented Features</h2>
				<h3>Save a crunches state</h3>
				<code>
					<?php
						echo htmlentities("
					self.postMessage({'cmd': 'save','data': this.results});
					");
					?> 
				</code>
				
				<h3>Load image data</h3>
				<code>
					<?php
						echo htmlentities("
					self.postMessage({'cmd': 'loadImage','data': 'http://www.asite.com/image.jpg'});
					");
					?> 
				</code>
			</div>
		</div>
		
		
		
	</div>
</div>