<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div class="row">
	<div class="span6">
		
	</div>
</div>
<div class="row">
	<div class="span6">
		<h1>API</h1>
		<p>This application allows you to process javascript files in the cloud via an API</p>
		<p>TODO - Document</p>
		<h2>Staring your crunch</h2>
		<code>
			<?php
				echo htmlentities("
			self.addEventListener('message', function(e) {
				if(e.data.cmd == 'start'){
					cruncher.data = e.data.data;
					self.postMessage({'cmd': 'log','data': 'Starting'});
					cruncher.run();
				}
			}, false);
			");
			?> 
		</code>
		<h2>Save a crunch</h2>
		<code>
			<?php
				echo htmlentities("
			self.postMessage({'cmd': 'completed','data': this.results});
			");
			?> 
		</code>
		
		<h2>Log data while crunching</h2>
		<code>
			<?php
				echo htmlentities("
			self.postMessage({'cmd': 'log','data': this.data});
			");
			?> 
		</code>
	</div>
</div>