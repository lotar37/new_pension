<?

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */

class UserIdentity extends CUserIdentity
{
	private $_id; 
	public function authenticate()
	{

		$record=Users::model()->findByAttributes(array('username'=>$this->username));
 		
		if($record===null)
		{
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}
//		else if(!CPasswordHelper::verifyPassword($this->password,$record->password))
 		else if(md5($this->password) != $record->password)
		{
			$this->errorCode=self::ERROR_PASSWORD_INVALID; 
		}
		else
		{
			$record->connect_time=date('r');
			$record->save();

// 			$this->_id=$record->id;
			$this->_id=$record->username;
			$this->setState('title', $record->title);
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->_id;
	}
}

?>