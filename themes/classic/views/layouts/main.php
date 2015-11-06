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

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/table.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php
         Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/datepicker-ru.js',CClientScript::POS_END);
         Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/search.js',CClientScript::POS_END);
    	Yii::app()->getClientScript()->registerCoreScript( 'jquery' );
		Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
		Yii::app()->clientScript->registerCssFile( Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css' );
	?>
	</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo  Yii::app()->user->isGuest ? "Зарегистрируйтесь пожалуйста!" : CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
<?php
        $con = new Constants();

        $this->widget('zii.widgets.CMenu',array(
             'id'=>'main_ul',
             'items'=> $con->menu,
        )); ?>


	</div><!-- mainmenu -->

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
