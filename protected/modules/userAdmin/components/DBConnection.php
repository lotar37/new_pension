<?php
class DBConnection extends CDbConnection 
{
	public $schema;// = 'public';
	public $audit;
	protected function initConnection($pdo) 
	{
		parent::initConnection($pdo);
		
		if ($pdo->getAttribute ( PDO::ATTR_DRIVER_NAME ) == 'pgsql') 
		{
			$this->driverMap ['pgsql'] = 'PgSchema';
			if($this->schema)
			{
				$cmd = $pdo->prepare("SET search_path TO " . $this->schema);
				$cmd->execute();
			}
						
// $sql = "set pens.sess to '$this->username'";
			if($this->audit) //TODO: behavior
			{
//die;
				
				$pid = ($pid=Yii::app()->user->getState('pid'))?$pid:0;
				$sql = "select audit.check_session($pid, '" . Yii::app()->user->name . "')";
				$pid = $this->createCommand($sql)->query()->readColumn(0);
				Yii::app()->user->setState('pid', $pid);
			}
		}
	}
}
?>