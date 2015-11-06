<?php
/* @var $this RanksController */
/* @var $model Ranks */


$this->menu=array(
	array('label'=>'Новое', 'url'=>array('create')),
	array('label'=>'Вернуться к списку', 'url'=>array('admin')),
);
?>
<script>
$(document).ready(function(e){
    $('input, textarea').focus(function(){hotkeysDisabled=true;}).blur(function(){hotkeysDisabled=false});
	$(document).keypress(function (e) { 
	//alert(" which:" + e.which + " - keyCode:" + e.keyCode );
    hotkeysDisabled = false;
    if(hotkeysDisabled)return true;    
        switch(e.which){
		case  90, 1071: 
	        window.document.location.href='../../ranks/admin';	
			break;
	    }
       switch(e.keyCode){
		case  27: 		
	        window.document.location.href='../../ranks/admin';	
			break;
	    }
    });
});
</script>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>