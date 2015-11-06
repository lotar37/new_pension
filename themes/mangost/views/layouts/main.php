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

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/mangost/default.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/mangost/fonts.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/table.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php
     	Yii::app()->getClientScript()->registerCoreScript( 'jquery' );
		Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
		Yii::app()->clientScript->registerCssFile( Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css' );
	?>
	</head>

<body>

<div id='free'><?php echo  Yii::app()->user->isGuest ? "Зарегистрируйтесь пожалуйста!" : CHtml::encode(Yii::app()->name); ?></div>
	<div id="header">
		<div id="logo"></div>

	<div id="mainmenu">
<?php

		$loModelReferences = new References();
		$loSubMenuReferences = $loModelReferences->ReferencesMenu();

        
        $this->widget('zii.widgets.CMenu',array(
             'id'=>'main_ul',
             'items'=> array(
				array('label'=>'Ввод', 'url'=>array('/persons/persearch'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Рубрикаторы', 'url'=>array(''), 'items'=>array(
				    array('label'=>'В/звания', 'url'=>array('/ranks/admin'),'itemOptions'=>array('id'=>'loss'), 'linkOptions'=>array('id'=>'a_loss'), 'visible'=>!Yii::app()->user->isGuest),
				    array('label'=>'Военные действия','url'=>array('/warActions/admin'),'itemOptions'=>array('id'=>'loss'), 'linkOptions'=>array('id'=>'a_loss'), 'visible'=>!Yii::app()->user->isGuest),
				    array('label'=>'Причины увольнения','url'=>array('/dismisses/admin'),'itemOptions'=>array('id'=>'loss'), 'linkOptions'=>array('id'=>'a_loss'), 'visible'=>!Yii::app()->user->isGuest),
                ), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Печать', 'url'=>array('#'), 'itemOptions'=>array('id'=>'references')
					, 'items' => $loSubMenuReferences, 'visible'=>!Yii::app()->user->isGuest
				),
				array('label'=>'Параметры', 'url'=>array('/calcParams/'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Перерасчет', 'url'=>array('/Pereschet/'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Настройки', 'url'=>array('/Config/'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
				
            ),
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
