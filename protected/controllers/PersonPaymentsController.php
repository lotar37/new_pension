<?php
class PersonPaymentsController extends Controller{
	public $layout='//layouts/personPayments';
	public $person_id = 0;
	public $model_params;

	public function actionIndex(){
		$this->person_id = $_GET[ 'idp' ];
		$loModelPersonPayments = new PersonPayments();
		$loModelPersonPayments->PersonPayments( $this->person_id );

		$this->model_params[ 'get' ] = $_GET;
		$this->model_params[ 'data' ] = $loModelPersonPayments->PersonPaymentsGetPersonData( $this->model_params[ 'get' ] );

		$this->render( 'print_tab', array( 'ref' => '0' ) );
	}
}
