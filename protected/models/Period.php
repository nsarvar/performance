<?php

/**
 * This is the model class for table "period".
 *
 * The followings are the available columns in table 'period':
 * @property string $id
 * @property string $name
 * @property string $status
 * @property integer $task_count
 * @property string $period_from
 * @property string $period_to
 *
 * The followings are the available model relations:
 * @property Task[] $tasks
 */
class Period extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'period';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, period_from', 'required'),
            array('task_count', 'numerical', 'integerOnly'=> true),
            array('name', 'length', 'max'=> 32),
            array('status', 'length', 'max'=> 8),
            array('period_to', 'safe'),
            array('id, name, status, task_count, period_from, period_to', 'safe', 'on'=> 'search'),
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
            'tasks' => array(self::HAS_MANY, 'Task', 'period_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => 'ID',
            'name'        => 'Name',
            'status'      => 'Status',
            'task_count'  => 'Task Count',
            'period_from' => 'Period From',
            'period_to'   => 'Period To',
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        if (!empty($this->period_from) && empty($this->period_to)) {
            $criteria->condition = "period_from >= :period_from";
            $criteria->params = array(':period_from'=> $this->period_from);
        } elseif (!empty($this->period_to) && empty($this->period_from)) {
            $criteria->condition = "period_from <= :period_to";
            $criteria->params = array(':period_to'=> $this->period_to);
        } elseif (!empty($this->period_from) && !empty($this->period_to)) {
            $criteria->condition = "period_from  >= :period_from AND period_from <= :period_to";
            $criteria->params = array(':period_from'=> $this->period_from, ':period_to'=> $this->period_to);
        }

        return new CActiveDataProvider($this, array(
            'criteria'   => $criteria,
            'sort'       => array('defaultOrder'=> 'period_from DESC',),
            'pagination' => array(
                'pageSize' => 13

            )
        ));
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    function getPeriodToFormatted()
    {
        if ($this->period_to === null)
            return;

        return Yii::app()->dateFormatter->format("d/M/y", $this->period_to);
    }
}
