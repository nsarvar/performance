<?php

/**
 * This is the model class for table "task".
 *
 * The followings are the available columns in table 'task':
 * @property string $id
 * @property string $number
 * @property string $name
 * @property string $type
 * @property string $parent_id
 * @property string $group_id
 * @property string $user_id
 * @property string $period_id
 * @property string $status
 * @property string $priority
 * @property string $start_date
 * @property string $end_date
 * @property string $description
 * @property integer $attachable
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property File[] $files
 * @property Job[] $jobs
 * @property Group $group
 * @property Task $parent
 * @property Task[] $tasks
 * @property Period $period
 * @property User $user
 */
class Task extends CActiveRecord
{
    public $parent_name;
    public $organization_ids;
    public $task_files;

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
            array('description, number, start_date, end_date', 'required'),
            array('attachable', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 64),
            array('start_date, end_date', 'validDate'),
            array('number', 'validNumber'),
            array('number', 'unique'),
            array('type, priority', 'length', 'max' => 6),
            array('parent_id, group_id, user_id, period_id', 'length', 'max' => 11),
            array('status', 'length', 'max' => 8),
            array('start_date, end_date, created_at, updated_at, type', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, number, name, type, parent_id, group_id, user_id, period_id, status, priority, start_date, end_date, description, attachable, created_at, updated_at,organization_ids,task_files', 'safe', 'on' => 'search'),
        );
    }

    public function validNumber($attribute, $params)
    {

        $pattern = '/^[0-9]{0,3}[-]?[0-9]{0,2}[\/]?[0-9]{0,2}[-]?[0-9]{1,4}$/';
        if (!preg_match($pattern, $this->$attribute))
            $this->addError($attribute, 'Invalid Task Number');
    }

    const DF_LOCAL = 'd-m-Y H:i:s';
    const DF_INTER = 'Y-m-d H:i:s';
    //const DF_JS    = 'yy-mm-dd';
    const DF_JS = 'dd-mm-yy';

    public function validDate($attribute, $params)
    {
        if ($date = date_create_from_format(self::DF_LOCAL, $this->$attribute)) {
            if ($this->$attribute == $date->format(self::DF_LOCAL)) return;
        } elseif ($date = date_create_from_format(self::DF_LOCAL, $this->$attribute . ' 00:00:00')) {
            if (($this->$attribute . ' 00:00:00') == $date->format(self::DF_LOCAL)) return;
        }
        $this->addError($attribute, 'Invalid Date Format, use as 31-12-2014');

    }


    public function getFormattedDate($value)
    {
        if ($date = date_create_from_format(self::DF_LOCAL, $value)) {
            return $date->format(self::DF_LOCAL);
        }
        if ($date = date_create_from_format(self::DF_INTER, $value)) {
            return $date->format(self::DF_LOCAL);
        }
    }

    public function init()
    {
        if ($this->getScenario() == 'insert') {
            $date = new DateTime();
            $date->setTime(0, 0, 0);
            $this->start_date = $date->format(self::DF_LOCAL);
            $date->setTime(23, 59, 59);
            $this->end_date = $date->add(new DateInterval("P1D"))->format(self::DF_LOCAL);
        }

        return parent::init();
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'files'  => array(self::HAS_MANY, 'File', 'task_id'),
            'jobs'   => array(self::HAS_MANY, 'Job', 'task_id'),
            'group'  => array(self::BELONGS_TO, 'Group', 'group_id'),
            'parent' => array(self::BELONGS_TO, 'Task', 'parent_id'),
            'tasks'  => array(self::HAS_MANY, 'Task', 'parent_id'),
            'period' => array(self::BELONGS_TO, 'Period', 'period_id'),
            'user'   => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => 'Task ID',
            'number'      => 'Task Number',
            'name'        => 'Name',
            'type'        => 'Type',
            'parent_id'   => 'Parent',
            'group_id'    => 'Group',
            'user_id'     => 'Creator',
            'period_id'   => 'Period',
            'status'      => 'Status',
            'priority'    => 'Priority',
            'start_date'  => 'Start Date',
            'end_date'    => 'Deadline',
            'description' => 'Description',
            'attachable'  => 'Can Attach File',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
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
    protected $user_name;

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria         = new CDbCriteria;
        $criteria->alias  = 't';
        $criteria->select = 't.*, u.name as user_name';
        $criteria->join   = 'LEFT JOIN ' . User::model()->tableName() . ' as u on u.id = t.user_id';

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.number', $this->number, true);
        $criteria->compare('t.type', $this->type, true);
        if ($this->period_id) {
            $criteria->compare('t.period_id', '= ' . $this->period_id, true);
        }
        if ($this->user_id) $criteria->compare('t.user_id', '= ' . $this->user_id, true);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('t.priority', $this->priority, true);
        $criteria->compare('u.name', $this->user_name, true);

        return new CActiveDataProvider($this, array(
            'criteria'   => $criteria,
            'sort'       => array(
                'defaultOrder' => 'id DESC',
                'attributes'   => array(
                    'user_name' => array(
                        'asc'  => 'u.name',
                        'desc' => 'u.name DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 50
            )
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Task the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    const STATUS_ENABLED  = 'enabled';
    const STATUS_DISABLED = 'disabled';
    const STATUS_ARCHIVED = 'archived';

    public static function getStatusArray($empty = true)
    {
        $roles = array(
            self::STATUS_ENABLED  => __(ucfirst(self::STATUS_ENABLED)),
            self::STATUS_DISABLED => __(ucfirst(self::STATUS_DISABLED)),
            //self::STATUS_ARCHIVED       => __( ucfirst(self::STATUS_ARCHIVED)),
        );

        return ($empty) ? array_merge(array('' => ''), $roles) : $roles;
    }

    const PRIORITY_URGENT = 'urgent';
    const PRIORITY_HIGH   = 'high';
    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_LOW    = 'low';

    public static function getPriorityArray($empty = true)
    {
        $roles = array(
            self::PRIORITY_URGENT => __(ucfirst(self::PRIORITY_URGENT)),
            self::PRIORITY_HIGH   => __(ucfirst(self::PRIORITY_HIGH)),
            self::PRIORITY_NORMAL => __(ucfirst(self::PRIORITY_NORMAL)),
            self::PRIORITY_LOW    => __(ucfirst(self::PRIORITY_LOW)),
        );

        return ($empty) ? array_merge(array('' => ''), $roles) : $roles;
    }

    const TYPE_HAT    = 'xat';
    const TYPE_BUYRUQ = 'buyruq';
    const TYPE_FISHKA = 'fishka';

    public static function getTypeArray($empty = true)
    {
        $roles = array(
            self::TYPE_HAT    => __(ucfirst(self::TYPE_HAT)),
            self::TYPE_BUYRUQ => __(ucfirst(self::TYPE_BUYRUQ)),
            self::TYPE_FISHKA => __(ucfirst(self::TYPE_FISHKA)),
        );

        return ($empty) ? array_merge(array('' => ''), $roles) : $roles;
    }

    public static function getYesNoArray($empty = true)
    {
        $roles = array(
            1 => __('Yes'),
            0 => __('No'),
        );

        return ($empty) ? array_merge(array('' => ''), $roles) : $roles;
    }

    public static function getUserOptions()
    {
        /**
         * @var $organizations CDbCommand
         */
        $users = Yii::app()->db->createCommand('
         SELECT
            u.id,
            u.`name`
            FROM
                `user` AS u
            WHERE
                (SELECT count(id)
                    FROM
                        `task` AS t
                    WHERE
                        u.id = t.user_id) > 0
            ORDER BY `name`
        ')->queryAll();

        $result = array('' => '');
        foreach ($users as $user) {
            $result[$user['id']] = $user['name'];
        }

        return $result;
    }

    public static function getPeriodArray()
    {
        /**
         * @var $organizations CDbCommand
         */
        $periods = Yii::app()->db->createCommand('
         SELECT
            p.id,
            p.`name`
            FROM
                `period` AS p
            ORDER BY `id` DESC
        ')->queryAll();

        $result = array('' => '');
        foreach ($periods as $period) {
            $result[$period['id']] = $period['name'];
        }

        return $result;
    }


    public function getTasksForTaskCreate()
    {
        /**
         * @var $organizations CDbCommand
         */
        $criteria = new CDbCriteria;
        if ($this->number) $criteria->compare('t.number', $this->number, true);

        return new CActiveDataProvider(self::model(), array(
            'criteria'   => $criteria,
            'sort'       => array(
                'defaultOrder' => 'id DESC',
                'route'        => 'task/tasks/'
            ),
            'pagination' => array(
                'pageSize' => 10,
                'route'    => 'task/tasks/'
            ),
        ));

    }


    protected $saveFiles;

    public function onAfterFind($event)
    {
        return parent::onAfterFind($event);
    }


    protected function beforeSave()
    {

        //$this->parent_id = 1;
        if (!$this->parent_id) {
            $this->parent_id = NULL;
        }
        if ($this->isNewRecord) {
            $this->created_at = date_create()->format(self::DF_INTER);
        } else {
            $this->updated_at = date_create()->format(self::DF_INTER);
        }
        $this->description = strip_tags($this->description);
        try {

            if ($date = date_create_from_format(self::DF_LOCAL, $this->start_date . ' 00:00:00')) {
                $this->start_date = $date->format(self::DF_INTER);
            } elseif ($date = date_create_from_format(self::DF_LOCAL, $this->start_date)) {
                $this->start_date = $date->format(self::DF_INTER);
            }
            if ($date = date_create_from_format(self::DF_LOCAL, $this->end_date . ' 23:59:59')) {
                $this->end_date = $date->format(self::DF_INTER);
            } elseif ($date = date_create_from_format(self::DF_LOCAL, $this->end_date)) {
                $this->end_date = $date->format(self::DF_INTER);
            }
        } catch (Exception $e) {
            Yii::app()->user->setFlash('danger', __('Incorrect Date Format'));
        }


        $this->user_id  = Yii::app()->user->user_id;
        $this->group_id = (Yii::app()->user->group_id) ? Yii::app()->user->group_id : NULL;

        return parent::beforeSave();
    }

    public function getOrganizationIds()
    {
        if (!$this->organization_ids && $this->id) {
            $data = array();
            foreach ($this->jobs as $job) {
                $data[] = $job->organization_id;
            }
            $this->organization_ids = implode(',', $data);
        }

        return $this->organization_ids;
    }

    /**
     * @return File[]
     */
    public function getTaskFiles()
    {
        $result = array();
        foreach ($this->files as $file) {
            if ($file->job_id == NULL) $result[$file->realname] = $file;
        }
        if ($this->task_files && count($this->task_files)) {
            foreach ($this->task_files as $realname => $orgname) {
                if (!isset($result[$realname])) {
                    $file            = new File();
                    $file->realname  = $realname;
                    $file->file_name = $orgname;
                    $result[]        = $file;
                }
            }
        }


        return $result;
    }

    protected function afterSave()
    {
        $newJobs = explode(',', $this->organization_ids);
        $oldJobs = array();
        foreach ($this->jobs as $job) {
            $oldJobs[$job->organization_id] = $job;
        }

        if (count($newJobs)) {
            $inserts = array();
            $date    = date_create()->format(self::DF_INTER);
            foreach ($newJobs as $id) {
                if (!isset($oldJobs[$id]))
                    $inserts[] = array(
                        'organization_id' => intval($id),
                        'status'          => Job::STATUS_PENDING,
                        'task_id'         => $this->id,
                        'updated_at'      => $date
                    );
            }
            if (count($inserts)) {
                try {
                    Job::batchInsert($inserts);
                } catch (Exception $e) {
                }
            }
            foreach ($oldJobs as $orgId => $job) {
                if (!in_array($orgId, $newJobs)) {
                    try {
                        $job->delete();
                    } catch (Exception $e) {
                    }
                }
            }
        }

        $taskDir = UPLOAD_DIR . $this->id . DS;
        if ($this->getIsNewRecord()) {
            if (!is_dir($taskDir)) {
                try {
                    mkdir($taskDir);
                } catch (Exception $e) {
                    Yii::app()->user->setFlash('danger', $e->getMessage());
                }
            }
        }
        $newFiles = $this->task_files;
        $oldFiles = array();
        foreach ($this->files as $file) {
            if ($file->job_id == NULL) $oldFiles[$file->realname] = $file;
        }

        if ($newFiles && count($newFiles)) {
            if (is_dir($taskDir)) {
                foreach ($newFiles as $realname => $orgname) {
                    if (!isset($oldFiles[$realname])) {
                        $file            = new File();
                        $file->realname  = $realname;
                        $file->file_name = $orgname;
                        $file->task_id   = $this->id;
                        try {
                            if (!$file->save()) {
                                Yii::app()->user->setFlash('danger', __('Cannot save ":file"', $file->file_name));
                            }
                        } catch (Exception $e) {
                            Yii::app()->user->setFlash('danger', $e->getMessage());
                        }
                    }
                }
            }
        }

        foreach ($oldFiles as $realname => $file) {
            if (!$newFiles || count($newFiles) == 0 || !isset($newFiles[$realname]))
                try {
                    $file->delete();
                } catch (Exception $e) {
                }
        }

        return parent::afterSave();
    }
}
