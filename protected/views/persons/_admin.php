<?php
/* @var $this PersonsController */
/* @var $model Persons */


$this->menu=array(
	array('label'=>'Новый', 'url'=>array('create')),
);
/*
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#persons-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");*/
?>
<br>
<h1>Список</h1>


<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<?php
//var_dump($data);
$this->widget('zii.widgets.grid.CGridView',
        array(
 	        'id'=>'persons-grid',
            'dataProvider'=>$model->searchUnion(),
	        'filter'=>$model,
	        'htmlOptions'=>array("style"=>'cursor: pointer;'),
            'selectionChanged'=>"function(id){window.location='" . Yii::app()->urlManager->createUrl('persons/update', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
            'summaryText'=>false,
            'nullDisplay'=>'NULL',
            'columns'=>array(
             array(
                    'name'=>'number',
                    'header'=>'Номер',
                    'type'=>'html',
                    //'filter'=>CHtml::textField('Cases[number]', $model->number,array("size"=>2)),
                    'value' =>'$data->cases3->number',
                ),
            array(
                    'name'=>'rank_name',
                    'header'=>'rank_name',
                    'type'=>'html',
                    //'filter'=>CHtml::textField('Ranks[name]', $model->rank_name,array("size"=>6)),
                    'value' =>'$data->rank0->name',
                ),
            array(
                    'name'=>'cases3.type',
                    'header'=>'тип',
                    'type'=>'html',
                    //'filter'=>CHtml::textField('Cases[type]', $model->number),
                   // 'value' =>'@$data->cases3->number',
                ),
             array(
                    'name'=>'second_name',
                    'header'=>'Фамилия',
                    'type'=>'html',
                    'filter'=>CHtml::textField('Persons[second_name]', $model->second_name, array('class'=>'second_name')),
                    //'value' =>'CHtml::link(@$data->second_name, CController::createUrl("/admin/actions/getaction/", array("id"=>@$data->partnerKupon->id)))',
                ),
             array(
                    'name'=>'first_name',
                    'header'=>'Имя',
                    'type'=>'html',
                    'filter'=>CHtml::textField('Persons[first_name]', $model->first_name, array('class'=>'first_name')),
                    //'value' =>'CHtml::link(@$data->second_name, CController::createUrl("/admin/actions/getaction/", array("id"=>@$data->partnerKupon->id)))',
                ),
             array(
                    'name'=>'third_name',
                    'header'=>'Отчество',
                    'type'=>'html',
                    'filter'=>CHtml::textField('Persons[third_name]', $model->third_name, array('class'=>'third_name')),
                    //'value' =>'CHtml::link(@$data->second_name, CController::createUrl("/admin/actions/getaction/", array("id"=>@$data->partnerKupon->id)))',
                ),
             ),
));
?>