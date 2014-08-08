<?php

/**
 * This is the model class for table "file".
 *
 * The followings are the available columns in table 'file':
 * @property string $id
 * @property string $realname
 * @property string $task_id
 * @property string $job_id
 * @property string $description
 * @property string $created_at
 * @property integer $file_size
 * @property string $file_name
 * @property string $file_type
 *
 * The followings are the available model relations:
 * @property Job $job
 * @property Task $task
 */
class File extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'file';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('realname', 'required'),
            array('file_size', 'numerical', 'integerOnly' => true),
            array('realname', 'length', 'max' => 64),
            array('task_id, job_id', 'length', 'max' => 11),
            array('description, file_name', 'length', 'max' => 256),
            array('file_type', 'length', 'max' => 64),
            array('created_at', 'safe'),
            array('created_at', 'default', 'value' => new CDbExpression('NOW()'), 'setOnEmpty' => false, 'on' => 'insert'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, realname, task_id, job_id, description, created_at, file_size, file_name, file_type', 'safe', 'on' => 'search'),
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
            'job'  => array(self::BELONGS_TO, 'Job', 'job_id'),
            'task' => array(self::BELONGS_TO, 'Task', 'task_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => 'File ID',
            'realname'    => 'Real Name',
            'task_id'     => 'Task',
            'job_id'      => 'Job',
            'description' => 'Description',
            'created_at'  => 'Created At',
            'file_size'   => 'Size',
            'file_name'   => 'Name',
            'file_type'   => 'Type',
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
        $criteria->compare('realname', $this->realname, true);
        $criteria->compare('task_id', $this->task_id, true);
        $criteria->compare('job_id', $this->job_id, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('file_size', $this->file_size);
        $criteria->compare('file_name', $this->file_name, true);
        $criteria->compare('file_type', $this->file_type, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return File the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static $allowedExt = array(
        'jpg',
        'jpeg',
        'tiff',
        'png',
        'bmp',
        'pdf',
        'txt',
        'doc',
        'docx',
        'xls',
        'xlsx',
        'ppt',
        'pptx',
        'rar',
        'zip'
    );

    protected function afterDelete()
    {
        $file = UPLOAD_DIR . $this->task_id . DS . $this->realname;
        if (is_file($file)) {
            try {
                unlink($file);
            } catch (Exception $e) {

            }
        }

        return parent::afterDelete();
    }

    protected function afterSave()
    {
        if ($this->isNewRecord) {
            $taskDir  = UPLOAD_DIR . $this->task_id . DS;
            $tempFile = UPLOAD_TEMP_DIR . $this->realname;
            if (is_dir($taskDir) && is_file($tempFile)) {
                if (!rename($tempFile, $taskDir . $this->realname)) {
                    $this->delete();
                }
            }
        }

        return parent::afterSave();
    }

    protected function beforeSave()
    {
        $tempFile = UPLOAD_TEMP_DIR . $this->realname;
        if ($this->isNewRecord) {
            if (is_file($tempFile)) {
                $this->file_size = filesize($tempFile);
                $this->file_type = mime_content_type($tempFile);
            }
        }

        return parent::beforeSave();
    }

    public function getFileSize()
    {
        $lbl  = 'Kb';
        $size = $this->file_size / 1024;
        if ($size > 1024) {
            $size /= 1024;
            $lbl = 'Mb';
        }

        return round($size, 1) . " $lbl";
    }

    public function getClass()
    {
        $pathinfo = pathinfo($this->file_name);
        $ext      = $pathinfo['extension'];

        return $this->getFileClass($ext);
    }

    public static function  getFileClass($ext)
    {
        $class = 'fa-file-o';
        foreach (array(
                     'fa-file-word-o'       => array('doc', 'docx'),
                     'fa-file-excel-o'      => array('xls', 'xlsx'),
                     'fa-file-text-o'       => array('dat', 'txt'),
                     'fa-file-pdf-o'        => array('pdf'),
                     'fa-file-powerpoint-o' => array('ppt', 'pptx'),
                     'fa-file-image-o'      => array('jpg', 'jpeg', 'gif', 'png', 'tif'),
                     'fa-file-zip-o'        => array('rar', 'zip', 'gz', 'tar', 'tgz'),
                 ) as $cl => $exts) {
            if (in_array($ext, $exts)) {
                $class = $cl;
                break;
            }

        }

        return $class;
    }
}
