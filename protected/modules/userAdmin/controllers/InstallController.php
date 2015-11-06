<?

class InstallController extends Controller
{
// 	public $layout='//layouts/column2';

	
	public function actionIndex()
	{
		$auth=Yii::app()->authManager;
 		$auth->clearAll();

// $auth->
 		
		$Operation=$auth->createRole('administrator', 'Администратор БД');
		
		$Operation=$auth->createOperation('audit', 'Аудит');
		$Operation=$auth->createOperation('userAdmin', 'Администратор пользователей');
		$Operation=$auth->createOperation('readOnly', 'Правa на просмотр');
		$Operation=$auth->createOperation('activeCases', 'Действующие дела');
		$Operation=$auth->createOperation('terminatedCases', 'Прекращенные дела');
		$Operation=$auth->createOperation('spetzPosobie', 'Специальное пособие');
		$Operation=$auth->createOperation('naznachPens', 'Назначение пенсий');
		$Operation=$auth->createOperation('compensOzdorov', 'Компенсации на оздоровление (6+3)');
		$Operation=$auth->createOperation('putevkiCo', 'Выдача путевок и компенсаций за них инвалидам');
		$Operation=$auth->createOperation('compensProdtovar', 'Компенсации на приобретение продтоваров');
		$Operation=$auth->createOperation('vidachaMatpomosh', 'Выдача материальной помощи');
		$Operation=$auth->createOperation('vidachaBlankov', 'Выдача удостоверений и прочих бланков');
		$Operation=$auth->createOperation('modifPereraschet', 'Модификация справочника перерасчетов');
		$Operation=$auth->createOperation('ritual', 'Ритуальные услуги');
		$Operation=$auth->createOperation('doplataSotsnorm', 'Назначение доплат до соцнормы');
		
// 		$auth->createOperation('createPost','создание записи');
		
// 		$role=$auth->createRole('user2');
// 		$role->addChild('user');

		$dba = Yii::app()->{$this->module->dbConnection};
		//NOTE: this md5
		$sql = "insert into users (username,password,system,title)values('admin', '21232f297a57a5a743894a0e4a801fc3', 1, 'Администратор')";
		try 
		{
			$dba->createCommand($sql)->execute();
		}
		catch (Exception $e)
		{}

		//TODO: check audit schema
		
		$sql = "select table_name from audit.sys_tables where table_schema='public'"; 
		$tables = $dba->createCommand($sql)->query();
		foreach($tables as $table)
		{
			try 
			{
				$tablename = $table['table_name'];
				$schema = $table['table_schema']?$table['table_schema']:'public';
				$sql = "
CREATE TRIGGER {$tablename}_audit
 AFTER INSERT OR UPDATE OR DELETE ON $schema.$tablename
 FOR EACH ROW EXECUTE PROCEDURE audit.audit()";
				$dba->createCommand($sql)->execute();
			}
			catch (Exception $e)
			{}
		}//foreach
 
		$auth->assign('administrator','admin');
		$auth->assign('userAdmin','admin');

// 		$auth->save(); 
		
		$this->redirect($this->createUrl("/{$this->module->name}/users"));		

// 		$this->render('/users/index', array('model' => AuthItem::model()));
	}
	
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
		);
	}
	
	public function accessRules()
	{
		return array(
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
						'actions'=>array('index'),
						'users'=>array('admin'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
}

?>