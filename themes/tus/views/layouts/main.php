<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/tus.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/table.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php
     	Yii::app()->getClientScript()->registerCoreScript( 'jquery' );
		Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
		Yii::app()->clientScript->registerCssFile( Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css' );
         Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/datepicker-ru.js',CClientScript::POS_END);
         Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/search.js',CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/underscore.js',CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/backbone.js',CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/searcher/TableModel.js',CClientScript::POS_END);
	?>
	</head>

<body>

<div id='free'><?php echo  Yii::app()->user->isGuest ? "Зарегистрируйтесь пожалуйста!" : CHtml::encode(Yii::app()->name); ?></div>
	<div id="header">
		<div id="logo"></div>

	<div id="mainmenu">
<?php

        $con = new Constants();
        $this->widget('zii.widgets.CMenu',array(
             'id'=>'main_ul',
             'items'=>  $con->menu,
        )); ?>


	</div><!-- mainmenu -->
	</div><!-- header -->
<div class="container" id="page">


	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
