<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p>This is a PJE40 project by 447955. The aim of the project is to distribute data processing to the browser using HTML5 technology.</p>

<p>If you wish to allow the users of your website to help process data, place the following code onto your website</p>

<code>
	<?php
		echo htmlentities('
		<iframe src="http://pje40.local/tests/iframe"></iframe>
		');
	?> 
</code>