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
    public $organization_name;
    public $password_repeat;

    const ROLE_USER        = 'user';
    const ROLE_MODERATOR   = 'moderator';
    const ROLE_ADMIN       = 'admin';
    const ROLE_SUPER_ADMIN = 'superadmin';

    const STATUS_ENABLED  = 1;
    const STATUS_DISABLED = 0;

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
        return array(
            array('login, email, role, organization_id, status', 'required', 'on'=> array('update', 'insert')),
            array('password, password_repeat', 'required', 'on'=> array('insert')),
            array('password_repeat', 'compare', 'compareAttribute'=> 'password',
                                                'allowEmpty'      => true,
                                                'message'         => "Passwords doesn't match",
                                                'on'              => array('insert', 'update')),
            array('email', 'email'),

            array('status', 'numerical', 'integerOnly'=> true),
            array('password, login, name', 'length', 'max'=> 128),
            array('password, login', 'length', 'min'=> 5),
            array('organization_id, group_id', 'length', 'max'=> 11),
            array('email', 'length', 'max'=> 64),
            array('telephone, mobile', 'length', 'max'=> 14),
            array('picture', 'length', 'max'=> 255),
            array('role', 'length', 'max'=> 10),
            array('created_at', 'safe'),
            array('login, name, organization_id, role', 'safe', 'on'=> 'search'),

            array('created_at', 'default', 'value'=> new CDbExpression('NOW()'), 'setOnEmpty'=> false, 'on'=> 'insert'),
            array('login', 'unique', 'className'     => 'User',
                                     'attributeName' => 'login',
                                     'message'       => 'This login is already in use',
                                     'on'            => array('insert'))
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'jobs'         => array(self::HAS_MANY, 'Job', 'user_id'),
            'tasks'        => array(self::HAS_MANY, 'Task', 'user_id'),
            'group'        => array(self::BELONGS_TO, 'Group', 'group_id'),
            'organization' => array(self::BELONGS_TO, 'Organization', 'organization_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'              => 'User ID',
            'login'           => 'Login',
            'password'        => 'Password',
            'name'            => 'Full Name',
            'organization_id' => 'Organization',
            'group_id'        => 'Group',
            'email'           => 'Email',
            'telephone'       => 'Phone',
            'mobile'          => 'Mobile Phone',
            'picture'         => 'Picture',
            'status'          => 'Status',
            'created_at'      => 'Created At',
            'role'            => 'Role',
            'password_repeat' => 'Confirmation',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria         = new CDbCriteria;
        $criteria->alias  = 'u';
        $criteria->select = 'u.id,u.login,u.organization_id,u.role,u.name,o.name as organization_name';
        $criteria->join   = 'LEFT JOIN ' . Organization::model()->tableName() . ' as o on o.id = u.organization_id';
        $criteria->compare('login', $this->login, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('organization_id', $this->organization_id, true);
        $criteria->compare('role', $this->role, true);
        $criteria->compare('o.name', $this->organization_name, true);

        return new CActiveDataProvider($this, array(
            'criteria'   => $criteria,
            'sort'       => array(
                'defaultOrder'=> 'id ASC',
                'attributes'  => array(
                    'organization_name'=> array(
                        'asc' => 'o.name',
                        'desc'=> 'o.name DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 20
            )
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function loadByLogin($login)
    {
        return self::model()->findByAttributes(array('login'=> $login));
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

    public function beforeSave()
    {
        if ($this->scenario == 'create' || $this->scenario == 'update' && !is_null($this->password_repeat)) {
            $this->password = $this->encryptPassword($this->password);
        }
        if (empty($this->group_id)) $this->group_id = null;

        return parent::beforeSave();
    }

    public static function getRolesArray($empty = true)
    {
        $roles = array(
            self::ROLE_USER        => __('app', ucfirst(self::ROLE_USER)),
            self::ROLE_MODERATOR   => __('app', ucfirst(self::ROLE_MODERATOR)),
            self::ROLE_ADMIN       => __('app', ucfirst(self::ROLE_ADMIN)),
            self::ROLE_SUPER_ADMIN => __('app', ucfirst(self::ROLE_SUPER_ADMIN)),
        );

        return ($empty) ? array_merge(array(''=> ''), $roles) : $roles;
    }

    public static function getStatusArray($empty = true)
    {
        $roles = array(
            self::STATUS_ENABLED         => __('app', 'Enabled'),
            self::STATUS_DISABLED        => __('app', 'Disabled'),
        );

        return ($empty) ? array_merge(array(''=> ''), $roles) : $roles;
    }

}
