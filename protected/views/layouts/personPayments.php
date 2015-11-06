<?php /* @var $this Controller */ 
mb_internal_encoding( 'UTF-8' );
?>
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
	<style>
		html, head{
		}
		body{
			line-height: 1.3;
			font-size: 15px;
		}
		#DivReportMain{
			padding: 0px;
			margin: 0px;
			/*width: 690px !important;*/
		}
		.cTablePayments{
			text-align: left;
			vertical-align: top;
			border: 3px double #000000;
			border-collapse: collapse;
			empty-cells: show;
			padding: 0px;
			margin: 0px;
			width: 100%;
		}
		.cTablePayments tr{
			background-color: transparent;
		}
		.cTablePayments tr:hover{
			background-color: #208020;
		}
		.cTablePayments th{
			border-bottom: 1px solid #000000;
		}
		.cTablePayments td{
			padding-top: 2px;
			padding-left: 2px;
			padding-bottom: 2px;
			padding-right: 3px;
			vertical-align: top;
		}
		.cTextAlignCenter{
			text-align: center;
		}
		.cTextAlignLeft{
			text-align: left;
		}
		.cTextAlignRight{
			text-align: right;
		}
		.cTextAlignJustify{
			text-align: justify;
		}
		.cTextIndent{
			text-indent: 2.5em;
		}
		.cTextIndentList{
			text-indent: 3.5em;
		}
		.cTextVAlignTop{
			vertical-align: top;
		}
		.cTextVAlignMiddle{
			vertical-align: middle !important;
		}
		.cTextVAlignBottom{
			vertical-align: bottom !important;
		}
		.cGeoRegionDash{
			padding: 0px;
			margin: 0px;
			display: inline-block;
			width: 75%;
			border-bottom: 1px solid #000000;
		}
		.cZeroRegion{
			padding: 0px;
			margin: 0px;
		}
		.cListStyle{
			margin: 0 0 1em 0;
			padding-left: 3em;
			list-style-type: disc;
		}
		.cListItem{
			display: list-item;
		}
		.cNoWrap{
			white-space: nowrap;
		}
		.cZeroSpace{
			padding: 0px;
			margin: 0px;
		}
		.PageBreakAfter{ page-break-after: always; }
		.cBorderTopSolid{
			border-top: 1px solid #000000;
		}
		.cBorderTopDouble{
			border-top: 3px double #000000 !important;
		}
		.cBorderBottomSolid{
			border-bottom: 1px solid #000000;
		}
		.cBorderBottomDouble{
			border-bottom: 3px double #000000;
		}
		.cBorderLeftSolid{
			border-left: 1px solid #000000;
		}
		.cBorderLeftDouble{
			border-left: 3px double #000000;
		}
		.cBorderRightSolid{
			border-right: 1px solid #000000;
		}
		.cBorderRightDouble{
			border-right: 3px double #000000;
		}
		
		@media print {
			page{
				size: portrait;
				orientation:portrait;
			}
			@page portrait{ size: portrait; }
			.IsPrintHidden{ visibility:hidden; }
		}
	</style>
	<?php
		Yii::app()->getClientScript()->registerCoreScript( 'jquery' );
		Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
		Yii::app()->clientScript->registerCssFile( Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css' );
	?>
	<title><?php echo CHtml::encode($this->model_params[ 'name' ]); ?></title>
	<script>
		// Задаём ширину страницы portrait
		var lnA4Width = 720;
		var lnA4Height = 1300;
		jQuery(function($){
			//$( "._container" ).width( lnA4Width );
		});
	</script>
</head>
<body>
	<?php
		if ( $_GET[ 'is_trace' ] ){
			echo '<pre>';
			print_r( $this );
			echo '</pre>';
		}
	?>
	<div class="_container" id="_page">
		<?php echo $content; ?>
		<div class="clear"></div>
	</div><!-- page -->
</body>
</html>
