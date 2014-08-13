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

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'events'),
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