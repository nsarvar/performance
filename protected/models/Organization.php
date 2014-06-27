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
 * @property string $phone
 * @property string $email
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
            array('short_name,name,type,parent_id', 'required'),
            array('parent_id, region_id', 'length', 'max'=> 11),
            array('name, description, address, phone, web_site', 'length', 'max'=> 255),
            array('short_name', 'length', 'max'=> 30),
            array('email', 'length', 'max'=> 64),
            array('email', 'email', 'message'=> "The email isn't correct"),
            array('type', 'length', 'max'=> 10),
            array('created_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('parent_id, type, region_id', 'safe', 'on'=> 'search'),
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
            'jobs'          => array(self::HAS_MANY, 'Job', 'organization_id'),
            'parent'        => array(self::BELONGS_TO, 'Organization', 'parent_id'),
            'organizations' => array(self::HAS_MANY, 'Organization', 'parent_id'),
            'region'        => array(self::BELONGS_TO, 'Region', 'region_id'),
            'users'         => array(self::HAS_MANY, 'User', 'organization_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => 'ID',
            'parent_id'   => 'Parent',
            'name'        => 'Name',
            'short_name'  => 'Short Name',
            'description' => 'Description',
            'address'     => 'Address',
            'phone'       => 'Phone',
            'email'       => 'Email',
            'web_site'    => 'Web-site',
            'type'        => 'Type',
            'region_id'   => 'Region',
            'created_at'  => 'Created At',
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

        $criteria->compare('parent_id', $this->parent_id, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('region_id', $this->region_id, true);

        return new CActiveDataProvider($this, array(
            'criteria'   => $criteria,
            'sort'       => array('defaultOrder'=> 'ID ASC',),
            'pagination' => array(
                'pageSize' => 20
            )
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Organization the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public static function getParents()
    {
        /**
         * @var $organizations CDbCommand
         */
        $organizations = Yii::app()->db->createCommand('
        SELECT
            p.id,
            p.`name`
        FROM
            `organization` AS p
        WHERE
            (SELECT
                count(id)
            FROM
                organization AS ch
            WHERE
		ch.parent_id = p.id) > 0
        ')->queryAll();

        $result = array(''=> '');
        foreach ($organizations as $o) {
            $result[$o['id']] = $o['name'];
        }

        return $result;
    }

    public static function getOptionLabels($empty = true)
    {
        /**
         * @var $organizations CDbCommand
         */
        $organizations = Yii::app()->db->createCommand('
        SELECT
            p.id,
            p.`name`
            FROM
                `organization` AS p
            ORDER BY id
        ')->queryAll();

        $result = $empty ? array(null=> '') : array();
        foreach ($organizations as $o) {
            $result[$o['id']] = $o['name'];
        }

        return $result;
    }

    public static function getOptionLabelsForUsers()
    {
        /**
         * @var $organizations CDbCommand
         */
        $organizations = Yii::app()->db->createCommand('
         SELECT
            p.id,
            p.`name`
            FROM
                `organization` AS p
            WHERE
                (SELECT count(id)
                    FROM
                        `user` AS u
                    WHERE
                        u.organization_id = p.id) > 0
            ORDER BY `name`
        ')->queryAll();

        $result = array(''=> '');
        foreach ($organizations as $o) {
            $result[$o['id']] = $o['name'];
        }

        return $result;
    }

    public static function getListByType()
    {
        $types = self::getTypesArray(false);
        foreach ($types as $key=> $value) {
            $types[$key] = array();
        }
        $organizations = Yii::app()->db->createCommand('
        SELECT
            p.id,
            p.`type`,
            p.`name`,
            p.parent_id
            FROM
                `organization` AS p
            ORDER BY path DESC, `name`
        ')->queryAll();

        foreach ($organizations as $o) {
            if (isset($types[$o['type']])) {
                $types[$o['type']][$o['id']]           = $o;
                $types[$o['type']][$o['id']]['childs'] = array();
            }
/*
            $org       = self::model()->findByPk($o['id']);
            $org->save(false);*/
        }

        /*foreach ($types as $type=> $orgs) {
            foreach ($orgs as $id=> $org) {
                if (isset($types[$type][$org['parent_id']])) {
                    $types[$type][$org['parent_id']]['childs'][$org['id']] = $org;
                    unset($types[$type][$id]);
                }
            }
        }
        foreach ($types[self::TYPE_UNIVERSITY] as $id=> $org) {
            foreach ($org['childs'] as $chid=> $child) {
                if (isset($types[self::TYPE_UNIVERSITY][$id]['childs'][$child['parent_id']])) {
                    $types[self::TYPE_UNIVERSITY][$id]['childs'][$child['parent_id']]['childs'][$child['id']] = $child;
                    unset($types[self::TYPE_UNIVERSITY][$id]['childs'][$child['parent_id']]);
                }
            }
        }*/

        return $types;
    }

    const TYPE_MINISTRY   = 'ministry';
    const TYPE_UNIVERSITY = 'university';
    const TYPE_DEPARTMENT = 'department';
    const TYPE_CENTER     = 'center';


    public static function getTypesArray($empty = true)
    {
        $types = array(
            self::TYPE_MINISTRY     => __('app', ucfirst(self::TYPE_MINISTRY)),
            self::TYPE_DEPARTMENT   => __('app', ucfirst(self::TYPE_DEPARTMENT)),
            self::TYPE_UNIVERSITY   => __('app', ucfirst(self::TYPE_UNIVERSITY)),
            self::TYPE_CENTER       => __('app', ucfirst(self::TYPE_CENTER)),
        );

        return $empty ? array_merge(array(''=> ''), $types) : $types;
    }

    public function beforeSave()
    {
        if (empty($this->region_id)) $this->region_id = null;

        if ($this->parent_id != null) {
            $path       = self::getParentPath('', $this->parent_id);
            $this->path = $path.'/Z';
        }else{
            $this->path = '/Z';
        }

        return parent::beforeSave();
    }

    public static function getParentPath($path, $parent_id)
    {
        $org = self::model()->findByPk($parent_id);
        if ($org->parent_id && $org->id != $org->parent_id) {
            $path .= self::getParentPath($path, $org->parent_id);
        }

        return $path . '/' . $parent_id;
    }
}
