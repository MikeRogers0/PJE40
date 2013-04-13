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
		<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
		<p>This is a PJE40 project by 447955. The aim of the project is to distribute data processing to the browser using HTML5 technology.</p>
		
		<p>If you wish to allow the users of your website to help process data, place the following code onto your website:</p>
		
		<code>
			<?php
				echo htmlentities('
				<iframe src="http://'.$_SERVER['SERVER_NAME'].'/tests/iframe" width="0" height="0"></iframe>
				');
			?> 
		</code>
	</div>
	<div class="offset1 span5">
		<h2>See it in action below</h2>
		<iframe src="/tests/iframe?debug=true" width="100%" height="250"></iframe>
	</div>
</div>