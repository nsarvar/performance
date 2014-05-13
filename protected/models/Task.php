<?php

/**
 * This is the model class for table "task".
 *
 * The followings are the available columns in table 'task':
 * @property string $id
 * @property string $number
 * @property string $type
 * @property string $parent_id
 * @property string $group_id
 * @property string $user_id
 * @property string $period_id
 * @property string $status
 * @property string $deadline
 * @property string $description
 * @property integer $attachable
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property File[] $files
 * @property Group $group
 * @property Task $parent
 * @property Task[] $tasks
 * @property Period $period
 * @property User $user
 */
class Task extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'task';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('number, deadline, description', 'required'),
			array('attachable', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>64),
			array('type', 'length', 'max'=>6),
			array('parent_id, group_id, user_id, period_id', 'length', 'max'=>11),
			array('status', 'length', 'max'=>8),
			array('created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, number, type, parent_id, group_id, user_id, period_id, status, deadline, description, attachable, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'files' => array(self::HAS_MANY, 'File', 'task_id'),
			'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
			'parent' => array(self::BELONGS_TO, 'Task', 'parent_id'),
			'tasks' => array(self::HAS_MANY, 'Task', 'parent_id'),
			'period' => array(self::BELONGS_TO, 'Period', 'period_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Task ID',
			'number' => 'Task Number',
			'type' => 'Type',
			'parent_id' => 'Parent',
			'group_id' => 'Group',
			'user_id' => 'User',
			'period_id' => 'Period',
			'status' => 'Status',
			'deadline' => 'Deadline',
			'description' => 'Description',
			'attachable' => 'Can Attach File',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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
		$criteria->compare('number',$this->number,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('parent_id',$this->parent_id,true);
		$criteria->compare('group_id',$this->group_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('period_id',$this->period_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('deadline',$this->deadline,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('attachable',$this->attachable);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Task the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
