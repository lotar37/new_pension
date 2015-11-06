<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'config-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); 

if(isset(Yii::app()->request->cookies['theme'])) $theme =  Yii::app()->request->cookies['theme']->value;
else $theme = "classic";

?>

<style>
a{
	font-size:24px;
	text-decoration:none;
	color:white;
}
a.active{
	font-size:32px;
}
</style>
<script>
$("a").click(function(){
	//document.forms[0].submit();
});
</script>
<form>
<h1>Настройки</h1>
<font size='18px' color='#a82323'>Темы</font>
<?php 
//echo isset(Yii::app()->request->cookies['theme'])? Yii::app()->request->cookies['theme']->value : "не установлен";

echo CHtml::ajaxLink('обычная',
                                       CController::createUrl('config/setCookie'), 
                                       array('type' => 'GET',
                            
                                             'data'=>array('name'=>'classic'),
                                            // 'update' => '#mposter'
                                             //'id'=>$val->id,u
                                            ),
                                       array(
                                             //'href'=>'?name=classic',
											 'success'=>'function(){document.forms[0].submit();}',
											 'class'=>$theme == "classic" ? "active" : "",
                                                 )); ?>
&nbsp;<?php /*echo CHtml::ajaxLink('мангуст',
                                       CController::createUrl('config/setCookie'), 
                                       array('type' => 'GET',
                            
                                             'data'=>array('name'=>'mangost'),
                                            ),
                                       array(
											 'class'=>$theme == "mangost" ? "active" : "",
                                                 ));*/ ?>
&nbsp;
<?php echo CHtml::ajaxLink('необычная',
                                       CController::createUrl('config/setCookie'), 
                                       array('type' => 'GET',
                            
                                             'data'=>array('name'=>'tus'),
                                            // 'update' => '#mposter'
                                             //'id'=>$val->id,
                                            ),
                                       array(
                                             //'href'=>'?name=tus',
											 'class'=>$theme == "tus" ? "active" : "",
											 'success'=>'function(){document.forms[0].submit();}',
                                                 )); ?>
<?php echo CHtml::submitButton('Сохранить'); ?>
<?php $this->endWidget(); ?>

