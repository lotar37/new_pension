<?php
class DBConnection extends CDbConnection
{

    public $schema = null;


    protected function initConnection($pdo)
    {
        parent::initConnection($pdo);

        if ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME) == 'pgsql')
        {
            $this->driverMap['pgsql']='PgSchema';
            $cmd = $pdo->prepare("SET search_path TO ".$this->schema);
            $cmd->execute();
        }
    }

}
?>