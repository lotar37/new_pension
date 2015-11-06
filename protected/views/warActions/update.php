<?php
/* @var $this WarActionsController */
/* @var $model WarActions */

$this->menu=array(
	array('label'=>'Новый', 'url'=>array('create')),
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
	        window.document.location.href='../../warActions/admin';	
			break;
		//default:alert(" which:" + e.which + " - keyCode:" + e.keyCode );
	    }
       switch(e.keyCode){
		case  27: //alert(123);
	        window.document.location.href='../../warActions/admin';	
			break;
		//default:alert(" which:" + e.which + " - keyCode:" + e.keyCode );
	    }
    });
});
</script>
<h1>Изменить №<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>