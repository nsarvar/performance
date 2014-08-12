<?php

class CalendarController extends Controller
{

    public $layout = '//layouts/dashboard';

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionEvents()
    {
        /**
         * @var $task Task
         */
        $result = array('success' => 1);
        if (isset($_GET['from']) && isset($_GET['to'])) {
            $start = date(Task::DF_INTER, intval($_GET['from']) / 1000);
            $end   = date(Task::DF_INTER, intval($_GET['to']) / 1000);
            //echo $start."\n".$end;

            $criteria = new CDbCriteria;
            $criteria->addBetweenCondition('start_date', $start, $end);

            $tasks = Task::model()->findAll($criteria, array(
                'order' => array('priority' => 'DESC')
            ));
            $data  = array();

            foreach ($tasks as $task) {
                $data[] = array(
                    'id'    => $task->id,
                    'title' => $task->name,
                    'url'   => Yii::app()->createUrl('task/view', array('id' => $task->id)),
                    'start' => strtotime($task->start_date) . '000',
                    'end'   => strtotime($task->start_date) . '000',
                    'class' => 'priority-' . $task->priority,
                );
            }
            $result['result'] = $data;
        }

        $this->renderJSON($result);
    }

    public function actionEvents2()
    {
        echo '{
"success": 1,
"result": [
{
"id": "293",
"title": "This is warning class event with very long title to check how it fits to evet in day view",
"url": "http://www.example.com/",
"class": "event-warning",
"start": "1362938400000",
"end": "1363197686300"
},
{
"id": "256",
"title": "Event that ends on timeline",
"url": "http://www.example.com/",
"class": "event-warning",
"start": "1363155300000",
"end": "1363227600000"
},
{
"id": "276",
"title": "Short day event",
"url": "http://www.example.com/",
"class": "event-success",
"start": "1363245600000",
"end": "1363252200000"
},
{
"id": "294",
"title": "This is information class ",
"url": "http://www.example.com/",
"class": "event-info",
"start": "1363111200000",
"end": "1363284086400"
},
{
"id": "297",
"title": "This is success event",
"url": "http://www.example.com/",
"class": "event-success",
"start": "1363234500000",
"end": "1363284062400"
},
{
"id": "54",
"title": "This is simple event",
"url": "http://www.example.com/",
"class": "",
"start": "1363712400000",
"end": "1363716086400"
},
{
"id": "532",
"title": "This is inverse event",
"url": "http://www.example.com/",
"class": "event-inverse",
"start": "1364407200000",
"end": "1364493686400"
},
{
"id": "548",
"title": "This is special event",
"url": "http://www.example.com/",
"class": "event-special",
"start": "1363197600000",
"end": "1363629686400"
},
{
"id": "295",
"title": "Event 3",
"url": "http://www.example.com/",
"class": "event-important",
"start": "1364320800000",
"end": "1364407286400"
}
]
}';
        Yii::app()->end();
    }

    public function actionEvents1()
    {
        $out    = array();
        $out[]  = array(
            'id'    => '123',
            'title' => 'Test',
            'url'   => 'some/url',
            'start' => $_GET['from'],
            'end'   => $_GET['to']
        );
        $result = array('success' => 1, 'result' => $out);
        $this->renderJSON($result);
    }

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'events', 'parent', 'test'),
                'users'   => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users'   => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users'   => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    protected function renderJSON($data)
    {
        header('Content-type: application/json');
        echo CJSON::encode($data);

        foreach (Yii::app()->log->routes as $route) {
            if ($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        }
        Yii::app()->end();
    }
}