<?php

/**
 * This is the model class for table "organization".
 *
 * The followings are the available columns in table 'organization':
 * @property string $id
 * @property string $parent_id
 * @property string $name
 * @property string $short_name
 * @property string $description
 * @property string $address
 * @property string $web_site
 * @property string $type
 * @property string $region_id
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property Job[] $jobs
 * @property Organization $parent
 * @property Organization[] $organizations
 * @property Region $region
 * @property User[] $users
 */
class Organization extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'organization';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('short_name', 'required'),
			array('parent_id, region_id', 'length', 'max'=>11),
			array('name, description, address, web_site', 'length', 'max'=>255),
			array('short_name', 'length', 'max'=>30),
			array('type', 'length', 'max'=>10),
			array('created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, name, short_name, description, address, web_site, type, region_id, created_at', 'safe', 'on'=>'search'),
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
			'jobs' => array(self::HAS_MANY, 'Job', 'organization_id'),
			'parent' => array(self::BELONGS_TO, 'Organization', 'parent_id'),
			'organizations' => array(self::HAS_MANY, 'Organization', 'parent_id'),
			'region' => array(self::BELONGS_TO, 'Region', 'region_id'),
			'users' => array(self::HAS_MANY, 'User', 'organization_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Organization ID',
			'parent_id' => 'Parent',
			'name' => 'Name',
			'short_name' => 'Short Name',
			'description' => 'Description',
			'address' => 'Address',
			'web_site' => 'Web-site',
			'type' => 'Type',
			'region_id' => 'Region',
			'created_at' => 'Created At',
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
		$criteria->compare('parent_id',$this->parent_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('short_name',$this->short_name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('web_site',$this->web_site,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('region_id',$this->region_id,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Organization the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
