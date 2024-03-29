<?php

/**
 * This is the model class for table "group".
 *
 * The followings are the available columns in table 'group':
 * @property string $id
 * @property string $name
 * @property string $short_name
 *
 * The followings are the available model relations:
 * @property Organization[] $organizations
 * @property Task[] $tasks
 * @property User[] $users
 */
class Group extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'group';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('short_name,name', 'required'),
            array('name', 'length', 'max' => 64),
            array('short_name', 'length', 'max' => 32),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, short_name', 'safe', 'on' => 'search'),
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
            'organizations' => array(self::HAS_MANY, 'Organization', 'group_id'),
            'tasks'         => array(self::HAS_MANY, 'Task', 'group_id'),
            'users'         => array(self::HAS_MANY, 'User', 'group_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'         => 'ID',
            'name'       => __('Name'),
            'short_name' => __('Short Name'),
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('short_name', $this->short_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Group the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getOptionLabels()
    {
        $groups = Yii::app()->db->createCommand('
         SELECT
            p.id,
            p.`name`
            FROM
                `group` AS p
            ORDER BY `name`
        ')->queryAll();

        $result = array('' => '');
        foreach ($groups as $group) {
            $result[$group['id']] = $group['name'];
        }

        return $result;
    }
}
