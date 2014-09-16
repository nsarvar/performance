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
            array('parent_id, region_id', 'length', 'max' => 11),
            array('name, description, address, phone, web_site', 'length', 'max' => 255),
            array('short_name', 'length', 'max' => 30),
            array('email', 'length', 'max' => 64),
            array('email', 'email', 'message' => __("Invalid email format")),
            array('type', 'length', 'max' => 10),
            array('created_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('parent_id, type, region_id, so_ids', 'safe', 'on' => 'search'),
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
            'parent_id'   => __('Parent'),
            'name'        => __('Name'),
            'short_name'  => __('Short Name'),
            'description' => __('Description'),
            'address'     => __('Address'),
            'phone'       => __('Phone'),
            'email'       => __('Email'),
            'web_site'    => __('Web-site'),
            'type'        => __('Type'),
            'region_id'   => __('Region'),
            'created_at'  => __('Created At'),
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
            'sort'       => array('defaultOrder' => 'ID ASC',),
            'pagination' => array(
                'pageSize' => 20
            )
        ));
    }

    public function getOrganizationsForTaskCreate()
    {
        $criteria = new CDbCriteria;
        if ($this->so_ids)
            $criteria->addNotInCondition('id', explode(',', $this->so_ids), true);

        $criteria->compare('name', $this->name, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('region_id', $this->region_id, true);

        return new CActiveDataProvider($this, array(
            'criteria'   => $criteria,
            'sort'       => array(
                'defaultOrder' => 'name',
                'route'        => 'task/organizations/'
            ),
            'pagination' => array(
                'pageSize' => 1000,
                'route'    => 'task/organizations/'
            ),
        ));
    }

    public $so_ids;

    public function getSelectedOrganizationsForTaskCreate()
    {
        $criteria = new CDbCriteria;

        $criteria->addInCondition('id', explode(',', $this->so_ids), true);

        return new CActiveDataProvider($this, array(
            'criteria'   => $criteria,
            'sort'       => array(
                'defaultOrder' => 'name',
                'route'        => 'task/selectedOrg/'
            ),
            'pagination' => array(
                'pageSize' => 1000,
                'route'    => 'task/selectedOrg/'
            ),
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

        $result = array('' => '');
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

        $result = $empty ? array(NULL => '') : array();
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

        $result = array('' => '');
        foreach ($organizations as $o) {
            $result[$o['id']] = $o['name'];
        }

        return $result;
    }

    public static function getListByType()
    {
        $types = self::getTypesArray(false);
        foreach ($types as $key => $value) {
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


        return $types;
    }

    const TYPE_MINISTRY   = 'ministry';
    const TYPE_UNIVERSITY = 'university';
    const TYPE_DEPARTMENT = 'department';
    const TYPE_CENTER     = 'center';


    public static function getTypesArray($empty = true)
    {
        $types = array(
            self::TYPE_MINISTRY   => __(ucfirst(self::TYPE_MINISTRY)),
            self::TYPE_DEPARTMENT => __(ucfirst(self::TYPE_DEPARTMENT)),
            self::TYPE_UNIVERSITY => __(ucfirst(self::TYPE_UNIVERSITY)),
            self::TYPE_CENTER     => __(ucfirst(self::TYPE_CENTER)),
        );

        return $empty ? array_merge(array('' => ''), $types) : $types;
    }

    public function beforeSave()
    {
        if (empty($this->region_id)) $this->region_id = NULL;

        if ($this->parent_id != NULL) {
            $path       = self::getParentPath('', $this->parent_id);
            $this->path = $path . '/Z';
        } else {
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

    public static function getChilds($parent_id = false)
    {
        /**
         * @var $organizations CDbCommand
         */
        $criteria = new CDbCriteria;
        if ($parent_id) $criteria->compare('parent_id', $parent_id);

        return new CActiveDataProvider(self::model(), array(
            'criteria'   => $criteria,
            'sort'       => array(
                'defaultOrder' => 'name',
                'route'        => 'organization/parent/id/' . $parent_id
            ),
            'pagination' => array(
                'pageSize' => 20,
                'route'    => 'organization/parent/id/' . $parent_id
            ),
        ));
    }

    public static function getTreeViewData()
    {
        $organizations = Yii::app()->db->createCommand('
        SELECT * FROM `organization` AS p ORDER BY path DESC
        ')->queryAll();

        $result = array();
        foreach ($organizations as $o) {
            $o['id']                      = intval($o['id']);
            $o['text']                    = $o['name'];
            $o['expanded']                = true;
            $result[$o['id']]             = $o;
            $result[$o['id']]['children'] = array();
        }

        $data = array();
        foreach ($result as $key => $o) {
            $path = array_reverse(explode('/', $o['path']));
            if (count($path) > 2) {
                $child  = $o;
                $parent = false;
                foreach ($path as $id) {
                    if (intval($id) && isset($result[$id]) && !isset($parent['children'][$child['id']])) {
                        $result[$id]['children'][$child['id']] = $child['id'];
                        $child                                 = $result[$id];
                    }
                }
            }
        }

        foreach ($result as $key => &$o) {
            foreach ($o['children'] as $id1) {
                if (isset($result[$id1])) {
                    $o['children'][$id1] = $result[$id1];
                    foreach ($o['children'][$id1]['children'] as $id2) {
                        if (isset($result[$id2])) {
                            $o['children'][$id1]['children'][$id2] = $result[$id2];
                            foreach ($o['children'][$id1]['children'][$id2]['children'] as $id3) {
                                if (isset($result[$id3])) {
                                    $o['children'][$id1]['children'][$id2]['children'][$id3] = $result[$id3];
                                    foreach ($o['children'][$id1]['children'][$id2]['children'][$id3]['children'] as $id4) {
                                        if (isset($result[$id4])) {
                                            $o['children'][$id1]['children'][$id2]['children'][$id3]['children'][$id4] = $result[$id4];
                                            foreach ($o['children'][$id1]['children'][$id2]['children'][$id3]['children'][$id4]['children'] as $id5) {
                                                if (isset($result[$id5])) {
                                                    $o['children'][$id1]['children'][$id2]['children'][$id3]['children'][$id4]['children'][$id5] = $result[$id5];
                                                    foreach ($o['children'][$id1]['children'][$id2]['children'][$id3]['children'][$id4]['children'][$id5]['children'] as $id6) {
                                                        if (isset($result[$id6])) {
                                                            $o['children'][$id1]['children'][$id2]['children'][$id3]['children'][$id4]['children'][$id5]['children'] [$id6] = $result[$id6];
                                                            unset($result[$id6]);
                                                        }
                                                    }
                                                    unset($result[$id5]);
                                                }
                                            }
                                            unset($result[$id4]);
                                        }
                                    }
                                    unset($result[$id3]);
                                }
                            }
                            unset($result[$id2]);
                        }
                    }
                    unset($result[$id1]);
                }
            }
        }

        return $result;
    }

}
