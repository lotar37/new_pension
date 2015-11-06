<?php
class Constants{
    public $menu;
	function Constants(){
		$loModelReferences = new References();
		$loSubMenuReferences = $loModelReferences->ReferencesMenu();
		$this->menu = array(
				array(
				'label'=>'Ввод',
				'url'=>array('/persons/persearch'), 
				'visible'=>!Yii::app()->user->isGuest,
				),
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
				array('label'=>'Администрирование', 'url'=>array('/userAdmin'), 'visible'=>(Yii::app()->user->checkAccess('userAdmin'))),
				array('label'=>'Аудит', 'url'=>array('/userAdmin/audit'), 'visible'=>(Yii::app()->user->checkAccess('userAdmin'))),
				array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
				
            );
	}
}
?>