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
    public static $password = 'karabindeka';
    public static $oldDb = 'performance_old';
    public static $newDb = 'performance_new';

    public $oldDbLink;
    public $newDbLink;

    public function __construct()
    {
        error_reporting(E_ALL);
        $this->oldDbLink = mysql_connect('localhost', self::$user, self::$password);
        $this->newDbLink = mysql_connect('localhost', self::$user, self::$password, true);
        mysql_select_db(self::$oldDb, $this->oldDbLink) or die ("could not open db" . mysql_error());
        mysql_select_db(self::$newDb, $this->newDbLink) or die ("could not open db" . mysql_error());

        mysql_set_charset('utf8', $this->oldDbLink);
        mysql_set_charset('utf8', $this->newDbLink);
    }

    public function insert($table, $data)
    {
        $data   = array_filter($data);
        $cols   = array();
        $values = array();

        $result = mysql_query("select * from $table where id={$data['id']}", $this->newDbLink);
        if (!mysql_num_rows($result)) {

            foreach ($data as $col => $value) {
                $cols[]   = "`$col`";
                $values[] = "'$value'";
            }
            $cols   = implode(',', $cols);
            $values = implode(',', $values);
            $query  = "Insert into $table($cols) values($values);\n";
            $result = mysql_query($query, $this->newDbLink);
            echo $query;
        } else {
            foreach ($data as $col => $value) {
                $cols[] = "`$col`='$value'";
            }
            $cols   = implode(',', $cols);
            $query  = "Update $table set $cols where id={$data['id']};\n";
            $result = mysql_query($query, $this->newDbLink);
            echo $query;
        }
        if ($result === false) {
            $error = array(
                'error'  => mysql_errno(),
                'string' => mysql_error(),
                'data'   => $cols
            );
            print_r($error);
            file_put_contents("$table.log", print_r($error, true), FILE_APPEND);
        }

    }
}

abstract class Import
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    abstract function startImport();
}

class _Organization extends Import
{

    public function startImport()
    {
        $companies = array();
        $result    = mysql_query("SELECT * FROM companies", $this->db->oldDbLink);
        while ($row = mysql_fetch_assoc($result)) {
            $companies[$row['company_id']] = $row;
        }

        $groups = array();
        $result = mysql_query("SELECT * FROM `group`", $this->db->newDbLink);
        while ($row = mysql_fetch_assoc($result)) {
            $groups[$row['name']] = $row;
        }

        $regions = array();
        $result  = mysql_query("SELECT * FROM `region` order by name", $this->db->newDbLink);
        while ($row = mysql_fetch_assoc($result)) {
            $regions[$row['id']] = $row;
        }

        $result = mysql_query("SELECT * FROM departments", $this->db->oldDbLink);
        while ($dept = mysql_fetch_assoc($result)) {
            $cols = array(
                'id'          => $dept['dept_id'],
                'parent_id'   => ($dept['dept_parent']) ? $dept['dept_parent'] : NULL,
                'group_id'    => ($dept['dept_company']) ?
                        isset($companies[$dept['dept_company']]) ?
                            isset($groups[$companies[$dept['dept_company']]['company_name']]) ?
                                $groups[$companies[$dept['dept_company']]['company_name']]['id'] : NULL : NULL : NULL,
                'name'        => mysql_real_escape_string($dept['dept_name']),
                'description' => mysql_real_escape_string(($dept['dept_desc']) ? $dept['dept_desc'] : $dept['dept_name']),
                'phone'       => $dept['dept_phone'],
                'web_site'    => $dept['dept_url'],
                'address'     => mysql_real_escape_string(implode(',\n', array_filter(array($dept['dept_address1'], $dept['dept_address2'], $dept['dept_city'])))),
                'type'        => $this->getOrganizationType($dept),
                'region_id'   => $this->getRegion($dept, $regions),
                'created_at'  => date('Y-m-d H:i:s'),
            );
            $this->db->insert('organization', $cols);
        }
    }

    protected $types = array(
        'university' => array('кадемия', 'илиал', 'нститут', 'ниверситет', 'кола'),
        'ministry'   => array('правление', 'МВССО'),
        'comitte'    => array(),
        'center'     => array('ентр'),
    );

    protected function getRegion($dept, $regions)
    {
        $string = $dept['dept_name'] . $dept['dept_desc'];
        foreach ($regions as $id => $region) {
            if (stripos($string, strtolower(substr($region['name'], 0, 6))) !== false) return $id;
        }

        return 14;
    }

    protected function getOrganizationType($dept)
    {
        foreach ($this->types as $type => $words) {
            foreach ($words as $word) {
                $string = '..' . $dept['dept_name'] . $dept['dept_desc'];
                if (stripos($string, $word) !== false) return $type;
            }
        }

        return 'center';
    }
}

class _User extends Import
{
    public function startImport()
    {
        $departments = array();
        $result      = mysql_query("SELECT * FROM `organization` order by id", $this->db->newDbLink);
        while ($row = mysql_fetch_assoc($result)) {
            $departments[$row['id']] = $row;
        }

        $result = mysql_query("SELECT * FROM users", $this->db->oldDbLink);
        while ($row = mysql_fetch_assoc($result)) {
            $cols = array(
                'id'              => $row['user_id'],
                'login'           => $row['user_username'],
                'password'        => $row['user_password'],
                'name'            => mysql_real_escape_string($row['user_first_name'] . ' ' . $row['user_last_name']),
                'email'           => mysql_real_escape_string($row['user_email']),
                'telephone'       => $row['user_phone'],
                'mobile'          => $row['user_mobile'],
                'organization_id' => isset($departments[$row['user_department']]) ? $row['user_department'] : NULL,
                'role'            => ($row['user_type']) ? 'admin' : 'user',
                'created_at'      => date('Y-m-d H:i:s'),
            );
            $this->db->insert('user', $cols);
        }
    }
}

class _Task extends Import
{
    function startImport()
    {
        $users  = array();
        $result = mysql_query("SELECT * FROM `user` order by id", $this->db->newDbLink);
        while ($row = mysql_fetch_assoc($result)) {
            $users[$row['id']] = $row;
        }

        $periods = array();
        $result  = mysql_query("SELECT * FROM `period` order by period_from", $this->db->newDbLink);
        while ($row = mysql_fetch_assoc($result)) {
            $periods[$row['id']] = array(
                'start' => date_create_from_format('Y-m-d H:i:s', $row['period_from']),
                'end'   => date_create_from_format('Y-m-d H:i:s', $row['period_to']),
            );
        }

        $tasks  = array();
        $result = mysql_query("SELECT * FROM `task` order by id", $this->db->newDbLink);
        while ($row = mysql_fetch_assoc($result)) {
            $tasks[(int)$row['id']] = $row;
        }

        $result = mysql_query("SELECT * FROM tasks order by task_id", $this->db->oldDbLink);
        $j      = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $j++;
            //if ($j > 40) die;
            $cols = array(
                'id'          => $row['task_id'],
                'number'      => $this->getNumber($row['task_name']),
                'name'        => mysql_real_escape_string($row['task_name']),
                'type'        => $this->getTaskType($row),
                'description' => mysql_real_escape_string($row['task_description']),
                'parent_id'   => ($row['task_parent'] != $row['task_id'] && isset($tasks[$row['task_parent']])) ? $row['task_parent'] : NULL,
                'user_id'     => (isset($users[$row['task_owner']])) ? $row['task_owner'] : NULL,
                'period_id'   => $this->getPeriod($row['task_start_date'], $periods),
                'start_date'  => $row['task_start_date'],
                'created_at'  => $row['task_start_date'],
                'updated_at'  => $row['task_start_date'],
                'end_date'    => $row['task_end_date'],
                'priority'    => ($row['task_priority']) ? 'high' : 'normal',
                'status'      => 'enabled',
                'attachable'  => '1',
                'pages'       => '1',
            );
            //print_r($cols);
            $this->db->insert('task', $cols);
        }


    }

    protected function getPeriod($date, $periods)
    {
        $date = date_create_from_format('Y-m-d H:i:s', $date);
        foreach ($periods as $id => $period) {
            if ($date > $period['start'] && $date < $period['end']) return $id;
        }

        return NULL;
    }

    protected $types = array(
        'buyruq' => array('buyruq'),
        'xat'    => array('modemnoma', 'Modemogramma'),
        'fishka' => array(),
    );

    protected function getNumber($name)
    {
        $name = strtolower($name);
        preg_match_all('/\b[0-9]{2}\s*-\s*[0-9]{2,3}[\/]?[0-9]{0,3}\s*-\s*[0-9]{1,5}\b/', $name, $matches);
        if (isset($matches[0][0])) return $matches[0][0];
        preg_match_all('/\bbuyruq[-,#,№, ]{1,4}[0-9]{2,5}\s*\b/', $name, $matches);
        if (isset($matches[0][0])) {
            $number = $matches[0][0];

            return preg_replace("/[^0-9]/", "", $number);
        }

        return NULL;
    }

    protected function getTaskType($row)
    {
        foreach ($this->types as $type => $words) {
            foreach ($words as $word) {
                $string = '..' . $row['task_name'];
                if (stripos($string, $word) !== false) return $type;
            }
        }

        return 'xat';
    }

}

class _Period extends Import
{
    function startImport()
    {
        $start = 2004;
        $end   = 2014;
        $now   = new DateTime(NULL, new DateTimeZone('Asia/Tashkent'));
        //$now->add()
        $seconds = new DateTime();
        $seconds->setDate(2004, 1, 1)->setTime(0, 0, 0);

        for ($year = $start; $year <= 2014; $year++) {
            for ($month = 1; $month <= 12; $month++) {
                $start = new DateTime();
                $start->setDate($year, $month, 1)->setTime(0, 0, 0);
                $end  = clone $start;
                $end  = $end->modify('+' . (cal_days_in_month(CAL_GREGORIAN, $month, $year)) . ' day')->modify('-1 sec');
                $cols = array(
                    'period_from' => $start->format('Y-m-d H:i:s'),
                    'period_to'   => $end->format('Y-m-d H:i:s'),
                    'status'      => 'archived',
                    'name'        => $start->format('F, Y')
                );
                if ($end <= $now) {
                    $this->db->insert('period', $cols);
                }
            }
        }
    }
}


class _Job extends Import
{
    function startImport()
    {

        $users  = array();
        $result = mysql_query("SELECT * FROM `user` order by id", $this->db->newDbLink);
        while ($row = mysql_fetch_assoc($result)) {
            $users[$row['id']] = $row;
        }

        $tasks  = array();
        $result = mysql_query("SELECT * FROM `task` order by id", $this->db->newDbLink);
        while ($row = mysql_fetch_assoc($result)) {
            $tasks[(int)$row['id']] = $row;
        }

        $result = mysql_query("SELECT * FROM task_log order by task_log_id", $this->db->oldDbLink);
        $j      = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $j++;
            //if ($j > 100) die;
            $cols = array(
                'id'              => $row['task_log_id'],
                'content'         => mysql_real_escape_string($row['task_log_description']),
                'user_id'         => isset($users[$row['task_log_creator']]) ? $row['task_log_creator'] : NULL,
                'organization_id' => isset($users[$row['task_log_creator']]) ? $users[$row['task_log_creator']]['organization_id'] : NULL,
                'task_id'         => isset($tasks[(int)$row['task_log_task']]) ? $row['task_log_task'] : NULL,
                'updated_at'      => $row['task_log_date'],
                'status'          => $this->getStatus($row),
                'notified'        => 1
            );
            //print_r($cols);
            $this->db->insert('job', $cols);
        }
    }

    protected $statuses = array(
        'received'    => 'recieved',
        'approved'    => 'ready',
        'progressing' => 'in progr',
        'pending'     => 'stored',
        'rejected'    => '',
    );

    protected function getStatus($row)
    {
        foreach ($this->statuses as $status => $word) {
            if ($word == strtolower($row['task_log_costcode'])) return $status;
        }

        return 'pending';
    }

}

class _File extends Import
{
    function startImport()
    {

        $tasks  = array();
        $result = mysql_query("SELECT * FROM `task` order by id", $this->db->newDbLink);
        while ($row = mysql_fetch_assoc($result)) {
            $tasks[$row['id']] = $row;
        }

        $result = mysql_query("SELECT * FROM files order by file_id", $this->db->oldDbLink);
        $j      = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $j++;
            //if ($j > 100) die;
            $cols = array(
                'id'          => $row['file_id'],
                'realname'    => $row['file_real_filename'],
                'file_name'   => mysql_real_escape_string($row['file_name']),
                'file_type'   => $row['file_type'],
                'file_size'   => $row['file_size'],
                'created_at'  => $row['file_date'],
                'description' => mysql_real_escape_string($row['file_description']),
                'task_id'     => isset($tasks[$row['file_task']]) ? $row['file_task'] : NULL,
            );
            //print_r($cols);
            $this->db->insert('file', $cols);
        }
    }

}


class _Move extends Import
{
    function startImport()
    {

        $result = mysql_query("SELECT * FROM files order by file_id", $this->db->oldDbLink);
        $j      = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $j++;
            if ($realname = $row['file_real_filename']) {
                echo "$realname\n";
                $period   = $row['file_project'];
                $filename = UPLOAD_DIR . $period . DS . $realname;
                $newDir   = UPLOAD_DIR . '__ALL__' . DS . $realname;
                if (file_exists($filename)) {
                    $rename = false;
                    if (file_exists($newDir)) {
                        $rename = md5(time() . $realname);
                        $newDir = UPLOAD_DIR . '__ALL__' . DS . $rename;
                    }
                    if (rename($filename, $newDir)) {
                        echo "Success: $filename\n";
                        if ($rename) {
                            $cols = array(
                                'id'       => $row['file_id'],
                                'realname' => $rename
                            );
                            $this->db->insert('file', $cols);
                            echo "Renamed: $rename\n";
                        }
                    }
                }
            }
        }
    }

}


class _Check extends Import
{
    function startImport()
    {

        $resultFO = mysql_query("SELECT * FROM files order by file_id", $this->db->oldDbLink);
        $resultFN = mysql_query("SELECT * FROM file order by id", $this->db->newDbLink);
        $j        = 0;
        $foArray  = array();
        $fnArray  = array();

        while ($row = mysql_fetch_assoc($resultFO)) {
            $j++;
            if ($realname = $row['file_real_filename']) {
                $foArray[$realname] = $row['file_id'];
            } else {
                echo "Realname not found old: {$row['file_id']}\n";
            }
        }

        while ($row = mysql_fetch_assoc($resultFN)) {
            $j++;
            if ($realname = $row['realname']) {
                $fnArray[$realname] = $row['id'];
            } else {
                echo "Realname not found new: {$row['id']}\n";
            }
        }

        foreach ($foArray as $name => $id) {
            if (isset($fnArray[$name])) {
                unset($foArray[$name]);
                unset($fnArray[$name]);
            } else {
                echo "Not associated {$name}\t{$id}";
            }
        }

        print_r($foArray);
        print_r($fnArray);
    }

}

class _Create extends Import
{
    function startImport()
    {

        $result = mysql_query("SELECT * FROM file order by id", $this->db->newDbLink);
        $j      = 0;
        echo UPLOAD_DIR;
        while ($row = mysql_fetch_assoc($result)) {
            $j++;
            if ($realname = $row['realname']) {
                file_put_contents(UPLOAD_DIR . $realname, print_r($row, true));
            }
        }
    }

}


class _Fix extends Import
{
    function startImport()
    {

        $resultF = mysql_query("SELECT * FROM file order by id", $this->db->newDbLink);
        $resultT = mysql_query("SELECT * FROM task order by id", $this->db->newDbLink);
        $j       = 0;
        $tasks   = array();
        while ($row = mysql_fetch_assoc($resultT)) {
            $tasks[$row['id']] = $row;
        }

        while ($row = mysql_fetch_assoc($resultF)) {
            $j++;
            if ($realname = $row['realname']) {
                if ($taskId = $row['task_id']) {
                    if (isset($tasks[$taskId])) {
                        $task = $tasks[$taskId];
                        if (file_exists(UPLOAD_DIR . $realname)) {
                            if ($periodId = $task['period_id']) {

                            }else{
                                echo "Period not found for {$realname}\n";
                            }
                        } else {
                            echo "Real file not found for {$realname}\n";
                        }
                    } else {
                        echo "Task not found {$realname}\n";
                    }
                } else {
                    echo "Unknown task_id for {$realname}\n";
                }
            }
        }
    }

}


define('DS', DIRECTORY_SEPARATOR);
define('FIX_DIR', __DIR__ . DS . '..' . DS . 'files' . DS);
define('UPLOAD_DIR', __DIR__ . DS . '..' . DS . 'files' . DS . '__ALL__' . DS);
/**
 * @var $model Import
 */
if ($argc > 1)
    parse_str(implode('&', array_slice($argv, 1)), $_GET);

if (isset($_GET['type'])) {
    $class = '_' . $_GET['type'];

    $model = new $class;
    $model->startImport();
}
