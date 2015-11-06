<?php
/* @var $this PersonReferencesController */

$this->breadcrumbs=array(
	'Person References',
);
?>
<!--h1><?php echo $this->id . '/' . $this->action->id; ?></h1-->
<!--p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p-->

<?php
	function lfPrintReference( $poPR ){
		switch ( $poPR->reference_id ){
			case 1:
			case 0:
			default:
				break;
		}
	}
	if ( $_GET[ 'id0' ] == 2 ){
		echo '111';
	}
	echo '$this->person_id=' . $this->person_id;
	//phpinfo();

?>

