<?php
    if ( isset( $this->model_params ) && isset( $this->model_params[ 'export' ] ) && $this->model_params[ 'export' ] ){
        echo $content;
    } else {
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="ru">
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
	<?php
		//Yii::app()->clientScript->coreScriptPosition = CClientScript::POS_HEAD;
		Yii::app()->getClientScript()->registerCoreScript( 'jquery' );
		Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
		Yii::app()->clientScript->registerCssFile( Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css' );
		Yii::app()->getClientScript()->registerScriptFile( Yii::app()->request->baseUrl . '/js/spin/spin.min.js' );
	?>
	<style>
		body{
			/*background-color: #FFFFFF; */
			line-height: 1.5;
			font-size: 13px;
		}
		.cForm{
			padding:0px;
			margin: 0px;
		}
		.cDivSearch{
		}
		.cDivSearchResult{
			padding:0px;
			width: 720px !important;
		}
		.cTableReferences{
			text-align: left;
			vertical-align: top;
			border: 1px solid transparent;
			/*border-collapse: collapse;*/
			empty-cells: show;
			border: 1px solid transparent;
			width: 100%;
			padding: 0px;
		}
		.cTableRowHeaderName{
		}
		.cTableRowHeaderName td{
		}
		.cTableRowHeader{
			border-top: 3px double #000000;
			border-bottom: 1px solid #000000;
			border-collapse: collapse;
		}
		.cTableRowHeader td{
			border-top: 3px double #000000;
			border-bottom: 1px solid #000000;
			text-align: center;
			vertical-align: middle;
		}
		.cTableRowFooter{
			/*border: 1px solid transparent;*/
			display: none;
		}
		.cTableRowFooter td{
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
		.cTextVAlignTop{
			vertical-align: top;
		}
		.cTextVAlignMiddle{
			vertical-align: middle;
		}
		.cTextVAlignBottom{
			vertical-align: bottom;
		}
		.cNiceCheckboxWrapper{
			position: relative;
			display: inline-block;
			width: 35px;
			padding-right: 2px;
			overflow: hidden;
			vertical-align: middle;
			font-weight: bold;
			color: #777;
			line-height: 1;
			text-align: start;
			cursor: pointer;
			font-size: 13px;
		}
		.cNiceCheckboxWrapper input[type="checkbox"] {
			position: absolute;
			height: 13px;
			opacity: 0;
			cursor: pointer;
		}
		.cNiceCheckboxWrapper label{
			display: inline-block;
			border: 1px solid transparent;
			height: 13px;
			width: 100%;
			background: none repeat scroll 0% 0% #B8B8B8;
			cursor: pointer;
			border-radius: 20px;
			-moz-border-radius: 20px 20px 20px 20px;
			cursor: pointer;
			margin: 0;
			padding: 0;
		}
		.cNiceCheckboxWrapper label .checked {
			display: none;
		}
		.cNiceCheckboxWrapper label .unchecked {
			display: inline-block;
			float: right;
			padding-right: 3px;
			margin: 0px;
			padding: 0px;
			border: 0px none;
			background: none repeat scroll 0% 0% transparent;
		}
		.cNiceCheckboxWrapper label .toggle{
			float: left;
			background: none repeat scroll 0% 0% #FBFBFB;
			height: 13px;
			width: 13px;
			border-radius: 20px;
			-moz-border-radius: 20px 20px 20px 20px;
		}
		.cNiceCheckboxWrapper input[type="checkbox"]:checked + label {
			background-color: #167ac6;
		}
		.cNiceCheckboxWrapper input[type="checkbox"]:checked + label .checked {
			background: url("<? echo Yii::app()->request->baseUrl; ?>/protected/views/references/collection.png") no-repeat scroll -421px -77px rgba(0, 0, 0, 0);
			display: inline-block;
			height: 13px;
			margin-left: 6px;
			margin-top: 3px;
			width: 10px;
			padding: 0;
			color: #777;
			font-weight: bold;
			line-height: 1;
			text-align: start;
		}
		.cNiceCheckboxWrapper input[type="checkbox"]:checked + label .checked {
			display: inline-block;
			margin-top: 3px;
			margin-left: 6px;
			background: url("<? echo Yii::app()->request->baseUrl; ?>/protected/views/references/collection.png") no-repeat scroll -421px -77px transparent;
			width: 10px;
			height: 7px;
		}
		.cNiceCheckboxWrapper input[type="checkbox"]:checked + label .unchecked {
			display: none;
		}
		.cNiceCheckboxWrapper input[type="checkbox"]:checked + label .toggle {
			float: right;
		}
		.cSpanSearch{
			position: absolute;
			opacity: 0.8;
			top: 0;
			float: right;
			background: url("<? echo Yii::app()->request->baseUrl; ?>/protected/views/references/collection.png") no-repeat scroll -163px -381px transparent;
			width: 20px;
			height: 20px;
			cursor: pointer;
			border: 1px solid transparent;
		}
		.cPageBreakAfter{
			page-break-after: always;
		}
		.cPageBreakBefore{
			page-break-before: always;
		}
		.cPageBreakInside{
			page-break-inside: auto;
		}
		.cHiddenElement{
			display: none;
		}
		@media print {
			page{
				size: portrait;
				orientation:portrait;
			}
			@page portrait{ size: portrait; }
			html, head, body{
				background-color: #FFFFFF; 
			}
			.IsPrintHidden{ visibility:hidden; }
		}
		#WaitScreen{
			position: fixed;
			z-index:2e8;
			top:0;
			right:0;
			bottom:0;
			left:0;
			background: #000;
			opacity: 0.7;
			filter: alpha(opacity=70);
			display: none;
		}
	</style>
	<title><?php echo CHtml::encode($this->model_params[ 'name' ]); ?></title>
</head>
<body>
	<script>
		/**
		 * @var array opts
		 */
		var g_aLoaderAnimationOptions = {
			lines: 17, // The number of lines to draw
			length: 50, // The length of each line
			width: 30, // The line thickness
			radius: 100, // The radius of the inner circle
			corners: 1, // Corner roundness (0..1)
			rotate: 0, // The rotation offset
			direction: 1, // 1: clockwise, -1: counterclockwise
			color: '#AACCFF', // #rgb or #rrggbb or array of colors
			speed: 1, // Rounds per second
			trail: 100, // Afterglow percentage
			shadow: false, // Whether to render a shadow
			hwaccel: true, // Whether to use hardware acceleration
			className: 'spinner', // The CSS class to assign to the spinner
			zIndex: 2e9, // The z-index (defaults to 2000000000)
			top: '50%', // Top position relative to parent
			left: '50%' // Left position relative to parent
		};
		var g_oLoaderAnimator = new Spinner(g_aLoaderAnimationOptions);
		/**
		 * Показать экран анимации загрузки
 		 */
		function showWaitScreen()
		{
			//$( '#WaitScreen' ).show();
			//g_oLoaderAnimator.spin($('#WaitScreen')[0]);
		}
		/**
		 * Скрыть экран анимации загрузки
 		 */
		function hideWaitScreen()
		{
			//g_oLoaderAnimator.stop();
			//$( '#WaitScreen' ).hide();
		}
	</script>
	<?php
		if ( $_GET[ 'is_trace' ] ){
			echo '<pre>';
			print_r( $this );
			echo '</pre>';
		}
	?>
	<div id="WaitScreen"></div>
	<div class="_container" id="_page">
		<?php echo $content; ?>
		<div class="clear"></div>
	</div><!-- page -->
</body>
</html>
<?php
    } 
?>