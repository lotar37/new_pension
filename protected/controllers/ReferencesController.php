<?php
class ReferencesController extends Controller{
	public $layout='//layouts/references';
	public $reference_id = 0;
	public $model_params;

	public function actionIndex(){
		$this->reference_id = $_GET[ 'id0' ];
		$loModelReferences = new References();
		$loModelReferences->References();
		for ( $i = 0; $i < count( $loModelReferences->list_references ); $i++ ){
			if ( $loModelReferences->list_references[ $i ][ 'id0' ] == $this->reference_id ){
				$this->model_params = $loModelReferences->list_references[ $i ];
				break;
			}
		}
		$this->model_params[ 'get' ] = $_GET;
		$this->model_params[ 'html' ] = $loModelReferences->ReferencesGetHtmlSearch();

		if ( $_GET[ 'search_start' ] ){
			if ( $this->model_params[ 'get' ][ 'calcs' ] ){
				$this->model_params[ 'search_params' ][ 'calcs' ] = Yii::app()->db->createCommand( 'SELECT DISTINCT cg.id, cg.date, cgi.value FROM calc_groups AS cg JOIN calc_group_items cgi ON ( cgi."group" = cg.id ) JOIN calc_params cp ON ( cp.id = cgi.param ) WHERE TRUE AND cp.name=\'OSNP\' AND cg.id=' . $this->model_params[ 'get' ][ 'calcs' ] . ' ORDER BY cg.date' )->queryAll();
				$this->model_params[ 'search_params' ][ 'calcs' ] = $this->model_params[ 'search_params' ][ 'calcs' ][0];
			}
			if ( $this->model_params[ 'get' ][ 'banks' ] ){
				$this->model_params[ 'search_params' ][ 'banks' ] = Yii::app()->db->createCommand( 'SELECT DISTINCT b.* FROM banks AS b WHERE TRUE AND b.id=' . $this->model_params[ 'get' ][ 'banks' ] . ' ORDER BY b."name"' )->queryAll();
				$this->model_params[ 'search_params' ][ 'banks' ] = $this->model_params[ 'search_params' ][ 'banks' ][0];
			}
			//Загружаем данные для таблицы
			$this->model_params[ 'data' ] = $loModelReferences->ReferencesGetSearchData( $this->model_params[ 'get' ] );
		}
		//Helper::HelperPrintR( $this->model_params[ 'search_params' ] );
		$this->render( 'print_id_' . $this->reference_id );
	}

	public function actionExport(){
		$this->model_params[ 'get' ] = $_GET;
		$this->model_params[ 'export' ] = 1;
		$loModelReferences = new References();
		$loModelBank = Banks::model()->findByPk( $this->model_params[ 'get' ][ 'banks' ] );
		$this->model_params[ 'file' ][ 'charset' ] = 'CP866';
		//<nnnn><187><i>.DDD
		//nnnn – CSKO или номер ОСБ (в настоящее время указывается номер ОСБ, об использовании абривиатуры «CSKO» Клиент будет проинформирован Банком),
		//187 - код администратора доходов (из справочника)
		//i -  индекс пенсионного отдела  федерального органа 
		//DDD - номер дня в году, когда был сформирован файл
		$this->model_params[ 'file' ][ 'filename' ] = $loModelBank->department . '187' . 'i' . '.' . str_pad( date( 'z' ), 3, '0', STR_PAD_LEFT );
		$lsFileData = $loModelReferences->ReferencesGetSbExport( $this->model_params[ 'get' ] );
		if ( $this->model_params[ 'file' ] && $this->model_params[ 'file' ][ 'charset' ] && $this->model_params[ 'file' ][ 'charset' ] != 'UTF-8' ){
			// Есть подозрение, что iconv не работает на длинных строках, роэтому режем по 5000
			$l_iMaxlength = 5000;
			// Можно и без условия, но тогда каждый раз будет всё это считаться
			$p_sData = $lsFileData;
			$l_iStrLength = strlen( $p_sData );
			if ( $l_iStrLength > $l_iMaxlength ){
				$l_sResult = '';
				$l_iSize = floor( $l_iStrLength / $l_iMaxlength ) + 1;
				for ( $i = 0; $i < $l_iSize; $i++ ){
					$l_iStart = $l_iMaxlength * $i;
					$l_iCount = min( $l_iMaxlength + $l_iMaxlength * $i, $l_iStrLength) - ($l_iMaxlength * $i);
					$l_sResult .= iconv( 'UTF-8', $this->model_params[ 'file' ][ 'charset' ], substr( $p_sData, $l_iStart, $l_iCount) );
				}
				$lsFileData = $l_sResult;
			} else 
				$lsFileData = iconv( 'UTF-8', $this->model_params[ 'file' ][ 'charset' ], $p_sData );
		}
		$this->model_params[ 'data' ] = $lsFileData;
		$this->render( 'export_sb' );
	}
}
