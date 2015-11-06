<?php
	/* @var $this ReferencesController */
	
	header( 'Content-Type: text/xml; charset=' . $this->model_params[ 'file' ][ 'charset' ] . ';' );
	header( 'Content-type: application/force-download' );
	header( 'Content-Disposition: attachment; filename="' . $this->model_params[ 'file' ][ 'filename' ] . '"' );
	header( 'Content-Length: ' . strlen( $this->model_params[ 'data' ] ) );
	
	//Helper::HelperPrintR( $this->model_params );
	//echo '123' . ' === ';
	//echo strlen( $this->model_params[ 'data' ] );
	echo $this->model_params[ 'data' ];
?>
