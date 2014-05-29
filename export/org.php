<pre>
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: complex
 * Date: 5/29/14
 * Time: 7:57 PM
 * To change this template use File | Settings | File Templates.
 */
class Database
{
    public static $user = 'root';
    public static $password = '';
    public static $oldDb = 'p';
    public static $newDb = 'performance_new';

    public $oldDbLink;
    public $newDbLink;

    public function __construct()
    {
        $this->oldDbLink = mysql_connect('localhost', self::$user, self::$password);
        $this->newDbLink = mysql_connect('localhost', self::$user, self::$password, true);
        mysql_select_db(self::$oldDb, $this->oldDbLink) or die ("could not open db" . mysql_error());
        mysql_select_db(self::$newDb, $this->newDbLink) or die ("could not open db" . mysql_error());

        mysql_set_charset('utf8', $this->oldDbLink);
        mysql_set_charset('utf8', $this->newDbLink);
    }

    public function insert($table, $data)
    {
        $data = array_filter($data);
        $cols = array();
        $values = array();

        $result = mysql_query("select * from $table where id={$data['id']}");
        if (!mysql_num_rows($result)) {

            foreach ($data as $col=> $value) {
                $cols[] = "`$col`";
                $values[] = "'$value'";
            }
            $cols = implode(',', $cols);
            $values = implode(',', $values);
            $query = "Insert into $table($cols) values($values);\n";
            mysql_query($query);
        } else {
            foreach ($data as $col=> $value) {
                $cols[] = "`$col`='$value'";
            }
            $cols = implode(',', $cols);
            $query = "Update $table set $cols where id={$data['id']};\n";
            mysql_query($query);
            print_r($query);
        }

    }

}

class Organization
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function startImport()
    {
        $companies = array();
        $result = mysql_query("SELECT * FROM companies", $this->db->oldDbLink);
        while ($row = mysql_fetch_assoc($result)) {
            $companies[$row['company_id']] = $row;
        }

        $groups = array();
        $result = mysql_query("SELECT * FROM `group`", $this->db->newDbLink);
        while ($row = mysql_fetch_assoc($result)) {
            $groups[$row['name']] = $row;
        }

        $regions = array();
        $result = mysql_query("SELECT * FROM `region` order by name", $this->db->newDbLink);
        while ($row = mysql_fetch_assoc($result)) {
            $regions[$row['id']] = $row;
        }

        $result = mysql_query("SELECT * FROM departments", $this->db->oldDbLink);
        while ($dept = mysql_fetch_assoc($result)) {
            $cols = array(
                'id'                   => $dept['dept_id'],
                'parent_id'            => ($dept['dept_parent']) ? $dept['dept_parent'] : null,
                'group_id'             => ($dept['dept_company']) ?
                    isset($companies[$dept['dept_company']]) ?
                        isset($groups[$companies[$dept['dept_company']]['company_name']]) ?
                            $groups[$companies[$dept['dept_company']]['company_name']]['id'] : null : null : null,
                'name'                 => $dept['dept_name'],
                'description'          => ($dept['dept_desc']) ? $dept['dept_desc'] : $dept['dept_name'],
                'phone'                => $dept['dept_phone'],
                'web_site'             => $dept['dept_url'],
                'address'              => implode(',\n', array_filter(array($dept['dept_address1'], $dept['dept_address2'], $dept['dept_city']))),
                'type'                 => $this->getOrganizationType($dept),
                'region_id'            => $this->getRegion($dept, $regions),
                'created_at'           => date('Y-m-d H:i:s'),
            );
            $this->db->insert('organization', $cols);
            print_r($cols);
        }
    }

    protected $types = array(
        'university'=> array('кадемия', 'илиал', 'нститут', 'ниверситет', 'кола'),
        'ministry'  => array('правление', 'МВССО'),
        'comitte'   => array(),
        'center'    => array('ентр'),
    );

    protected function getRegion($dept, $regions)
    {
        $string = $dept['dept_name'] . $dept['dept_desc'];
        foreach ($regions as $id=> $region) {
            if (stripos($string, strtolower(substr($region['name'], 0, 6))) !== false) return $id;
        }
        return 14;
    }

    protected function getOrganizationType($dept)
    {
        foreach ($this->types as $type=> $words) {
            foreach ($words as $word) {
                $string = '..' . $dept['dept_name'] . $dept['dept_desc'];
                if (stripos($string, $word) !== false) return $type;
            }
        }
        return 'center';
    }
}

$org = new Organization();
$org->startImport();