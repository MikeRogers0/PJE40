<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);
?>
<h1>About</h1>

<p>This is a final year engineering project for the PJE40 unit by 447955 at Portsmouth University.</p>
<p>The aim of this project is to distribute data processing to the browser via HTML5 technologies. If you have any questions please use the <?php echo CHtml::link('contact', array('/site/contact')); ?> page.</p>
