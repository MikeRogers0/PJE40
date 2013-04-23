<?php /* @var $this Controller */ ?>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
	<meta name="language" content="en" />
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.min.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/pje40.css">

	<?php /*<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />*/ ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

	
<?php 
$this->widget('bootstrap.widgets.TbNavbar', 
	array(
		'type'=>null, // null or 'inverse'
		'brand'=>CHtml::encode(Yii::app()->name),
		'brandUrl'=>'/',
		'collapse'=>false, // requires bootstrap-responsive.css
		'items'=>array(
			array(
				'class'=>'bootstrap.widgets.TbMenu',
				'items'=>array(
					array('label'=>'Home', 'url'=>'/'),
					array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
					array('label'=>'Tasks', 'url'=>array('/tests/')),
					array('label'=>'Documentation', 'url'=>array('/site/api')),
				)
			)
		)
	)
); 
?>

<div class="container">	
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>
</div>

<div id="footer">
	<div class="container">
		<?php
		echo CHtml::link('Contact', array('/site/contact'));
		echo ' - ';
		if(Yii::app()->user->isGuest){
			echo CHtml::link('Login', array('/site/login'));
		}else {
			echo CHtml::link('Logout ('.Yii::app()->user->name.')', array('/site/logout'));
		}
		
		
					
		?>
		<br />
		PJE40 - 447955 Final Year Project<br/>
		<?php echo Yii::powered(); ?>
	</div>
</div>

<!-- jQuery and Bootstrap -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/jquery-1.9.1.min.js"><\/script>')</script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/bootstrap.min.js"></script>
</body>
</html>
