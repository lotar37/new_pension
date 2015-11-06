<?php
/* @var $this DismissesController */
/* @var $model Dismisses */



$this->menu=array(
	array('label'=>'Новое', 'url'=>array('create')),
	array('label'=>'Вернуться к списку', 'url'=>array('admin')),
);
?>
<script>
$(document).ready(function(){
    hotkeysDisabled = false;
    $('input, textarea').focus(function(){hotkeysDisabled=true;}).blur(function(){hotkeysDisabled=false});
	$(document).keypress(function (e) { 
    if(hotkeysDisabled)return true;    
        switch(e.which){
		case  90, 1071: 
	        window.document.location.href='../../dismisess/admin';	
			break;
	    }
       switch(e.keyCode){
		case  27: 
	        window.document.location.href='../../dismisess/admin';	
			break;
	    }
    });
});
</script>
<h1>Изменить №<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>