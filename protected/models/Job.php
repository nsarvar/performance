<?php

/**
 * This is the model class for table "job".
 *
 * The followings are the available columns in table 'job':
 * @property string $id
 * @property string $organization_id
 * @property string $content
 * @property string $status
 * @property string $updated_at
 * @property string $user_id
 * @property string $task_id
 * @property boolean $has_files
 *
 * The followings are the available model relations:
 * @property File[] $files
 * @property Task $task
 * @property Organization $organization
 * @property User $user
 */
class Job extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'job';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('content', 'required'),
            array('organization_id, status, user_id, task_id', 'length', 'max' => 11),
            array('updated_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, organization_id, content, status, updated_at, user_id, task_id', 'safe', 'on' => 'search'),
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
            'files'        => array(self::HAS_MANY, 'File', 'job_id'),
            'task'         => array(self::BELONGS_TO, 'Task', 'task_id'),
            'organization' => array(self::BELONGS_TO, 'Organization', 'organization_id'),
            'user'         => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'              => 'Job ID',
            'organization_id' => 'Organization',
            'content'         => 'Content',
            'status'          => 'Status',
            'updated_at'      => 'Updated At',
            'user_id'         => 'User',
            'task_id'         => 'Task',
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
        $criteria->compare('organization_id', $this->organization_id, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('task_id', $this->task_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Job the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    const STATUS_PENDING     = 'pending';
    const STATUS_RECEIVED    = 'received';
    const STATUS_PROGRESSING = 'progressing';
    const STATUS_APPROVED    = 'approved';
    const STATUS_REJECTED    = 'rejected';

    public static function getStatusArray($empty = true)
    {
        $status = array(
            self::STATUS_PENDING     => __(ucfirst(self::STATUS_PENDING)),
            self::STATUS_RECEIVED    => __(ucfirst(self::STATUS_RECEIVED)),
            self::STATUS_PROGRESSING => __(ucfirst(self::STATUS_PROGRESSING)),
            self::STATUS_APPROVED    => __(ucfirst(self::STATUS_APPROVED)),
            self::STATUS_REJECTED    => __(ucfirst(self::STATUS_REJECTED)),
        );

        return ($empty) ? array_merge(array('' => ''), $status) : $status;
    }


    public static function batchInsert($data = array())
    {
        if (count($data)) {
            $cols   = array();
            $values = array();
            foreach ($data[0] as $col => $value) {
                $cols[] = "`$col`";
            }
            foreach ($data as $row) {
                foreach ($row as $col => $value) {
                    $row[$col] = "'$value'";
                }
                $values[] = '(' . implode(',', $row) . ')';
            }
            $cols    = implode(',', $cols);
            $values  = implode(',', $values);
            $sql     = "INSERT INTO `job` ($cols) VALUES $values;";
            $command = Yii::app()->db->createCommand($sql);
            $command->execute();
        }
    }

    public $organization_name;


    public function getStatusLabel()
    {
        return __(ucfirst($this->status));
    }
}
