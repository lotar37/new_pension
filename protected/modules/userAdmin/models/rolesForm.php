<?

class rolesForm extends CFormModel
{
    public $name;
  
    public function rules()
    {
        return array(
            array('name', 'required'),
        );
    }
  
    public function attributeLabels()
    {
        return array(
            'name'=>'Роль',
        );
    }
}
?>