<?php
class PersonReferencesController extends Controller{
	public $layout='//layouts/column2';
//	public $layout='//layouts/personReferences';
	public $person_id = 0;
	public $reference_id = 0;
	public $model_params;

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','office','print'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionIndex(){
		$lnPersonReferencesIndex = $_GET[ 'id0' ];
		$this->person_id = $_GET[ 'idp' ];
		$this->reference_id = $_GET[ 'id0' ];
		$loModelPersonReferences = new PersonReferences();
		$loModelPersonReferences->PersonReferences( $this->person_id );
		for ( $i = 0; $i < count( $loModelPersonReferences->list_person_references ); $i++ ){
			if ( $loModelPersonReferences->list_person_references[ $i ][ 'id0' ] == $this->reference_id ){
				$this->model_params = $loModelPersonReferences->list_person_references[ $i ];
				break;
			}
		}
		//var_dump($_GET);die();
		//var_dump( Cases::model()->getDbConnection()->getSchema());die();
		//$loModelPerson = //Persons::model()->findByPk(9495);
		//Cases::model()->findByAttributes(array("person"=>9495));
		$this->model_params[ 'get' ] = $_GET;
		$this->model_params[ 'data' ] = $loModelPersonReferences->PersonReferencesGetPersonData( $this->model_params[ 'get' ] );

		$this->render( 'print_id_' . $this->reference_id, array( 'ref' => $this->reference_id ) );
		//$this->renderPartial('index', array( 'ref' => $this->reference_id ) );
	}

	public function actionOffice(){
		$this->render('office');
	}

	public function actionPrint(){
		$this->render('print');
	}
}
