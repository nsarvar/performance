<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $login
 * @property string $password
 * @property string $name
 * @property string $organization_id
 * @property string $group_id
 * @property string $email
 * @property string $telephone
 * @property string $mobile
 * @property string $picture
 * @property integer $status
 * @property string $created_at
 * @property string $role
 *
 * The followings are the available model relations:
 * @property Job[] $jobs
 * @property Task[] $tasks
 * @property Group $group
 * @property Organization $organization
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, password, email', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('login', 'length', 'max'=>30),
			array('password, name', 'length', 'max'=>128),
			array('organization_id, group_id', 'length', 'max'=>11),
			array('email', 'length', 'max'=>64),
			array('telephone, mobile', 'length', 'max'=>14),
			array('picture', 'length', 'max'=>255),
			array('role', 'length', 'max'=>10),
			array('created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, login, password, name, organization_id, group_id, email, telephone, mobile, picture, status, created_at, role', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'jobs' => array(self::HAS_MANY, 'Job', 'user_id'),
			'tasks' => array(self::HAS_MANY, 'Task', 'user_id'),
			'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
			'organization' => array(self::BELONGS_TO, 'Organization', 'organization_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'User ID',
			'login' => 'Login',
			'password' => 'Password',
			'name' => 'Full Name',
			'organization_id' => 'Organization',
			'group_id' => 'Group',
			'email' => 'Email',
			'telephone' => 'Phone',
			'mobile' => 'Mobile Phone',
			'picture' => 'Picture',
			'status' => 'Status',
			'created_at' => 'Created At',
			'role' => 'Role',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('organization_id',$this->organization_id,true);
		$criteria->compare('group_id',$this->group_id,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('picture',$this->picture,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('role',$this->role,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function loadByLogin($login)
    {
        return self::model()->findByAttributes(array('login'=>$login));
    }

    protected static $hashKey = 'd737b577e1534a5abf650ae446129181';

    protected function encryptPassword($password, $salt = false)
    {
        if (!$salt) $salt = substr(md5(time()), 0, 10);
        return $salt . hash('sha256', $salt . $password . self::$hashKey);
    }

    public function validatePassword($password)
    {
        /*echo $this->encryptPassword($password);die;*/
        if ($secure = $this->password) {
            $salt = substr($secure, 0, 10);
            return $secure === $this->encryptPassword($password, $salt);
        }
        return false;
    }
}
