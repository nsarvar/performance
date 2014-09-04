<?php

class CalendarController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionEvents()
    {
        /**
         * @var $task Task
         * @var $cmd CDbCommand
         */
        $result = array('success' => 1);
        if (isset($_GET['from']) && isset($_GET['to'])) {
            $start = date(Task::DF_INTER, intval($_GET['from']) / 1000);
            $end   = date(Task::DF_INTER, intval($_GET['to']) / 1000);
            //echo $start."\n".$end;

            $criteria = new CDbCriteria;
            $criteria->addBetweenCondition('start_date', $start, $end);
            if ($this->_user()->role == User::ROLE_USER) {
                $cmd     = Yii::app()->db->createCommand();
                $taskIds = $cmd
                    ->select('task_id')
                    ->from(Job::model()->tableName())
                    ->where('organization_id = :id AND (updated_at BETWEEN :start AND :end)',
                        array(':id' => $this->_user()->organization_id, ':start' => $start, ':end' => $end))
                    ->queryColumn();
                $criteria->addInCondition('id', $taskIds);
            }
            $tasks = Task::model()->findAll($criteria, array(
                'order' => array('priority' => 'DESC')
            ));
            $data  = array();

            foreach ($tasks as $task) {
                $data[] = array(
                    'id'    => $task->id,
                    'title' => $task->name,
                    'url'   => Yii::app()->createUrl('task/view', array('id' => $task->id)),
                    'start' => strtotime($task->created_at) . '000',
                    'end'   => (strtotime($task->created_at) + 1800) . '000',
                    'class' => 'priority-' . $task->priority,
                );
            }
            $result['result'] = $data;
        }

        $this->renderJSON($result);
    }


}