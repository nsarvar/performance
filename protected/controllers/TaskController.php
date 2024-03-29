<?php

class TaskController extends Controller
{

    public function actionIndex()
    {
        if ($this->_user()->role == User::ROLE_USER) {
            return $this->actionUser();
        }
        return $this->actionAdmin();
    }

    public function actionJob($id)
    {
        /**
         * @var $job Job
         */
        $job = Job::model()->with('organization')->findByPk($id);
        if ($job === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');

        $model = $job->task;

        if (
            $model->canView($this->_user()) ||
            $job->organization_id == $this->_user()->organization_id
        ) {

            if (isset($_POST['Job'])) {
                if ($model->status == Task::STATUS_ENABLED && $job->status != Job::STATUS_APPROVED) {
                    $job->setScenario('update');
                    $job->content = $_POST['Job']['content'];
                    $job->user_id = $this->_user()->id;
                    $job->status  = Job::STATUS_PROGRESSING;

                    if (isset($_POST['Job']['job_files']))
                        $job->job_files = $_POST['Job']['job_files'];

                    try {
                        if ($job->save()) {
                            Yii::app()->user->setFlash('success', __('Work of <b>:name</b> updated successfully', array(':name' => $job->organization->name)));
                        }
                    } catch (Exception $e) {
                        Yii::app()->user->setFlash('danger', $e->getMessage());
                    }
                }
                $this->redirect(array('job', 'id' => $job->id));
            } elseif ($job->status == Job::STATUS_PENDING && $job->organization_id == $this->_user()->organization_id) {
                //change status after first view;
                $job->status = Job::STATUS_RECEIVED;
                try {
                    $job->save(false);
                } catch (Exception $e) {
                }
            }

            $this->render('view_job', array(
                'model' => $model,
                'job'   => $job,
            ));
        }


    }

    public function actionView($id)
    {
        $model = $this->loadModel($id);
        if ($model->canView($this->_user())) {
            return $this->render('view', array(
                'model' => $model,
            ));
        } else {
            //view by task executor
            if ($job = $model->getJobOfOrganization($this->_user()->organization_id)) {
                return $this->redirect(array('job', 'id' => $job->id));
            }

        }
        $this->redirect(array('site/index'));
    }

    public function actionFull($id)
    {
        $model = $this->loadModel($id);
        if ($model->canView($this->_user())) {
            if (Yii::app()->request->isAjaxRequest) {
                return $this->renderPartial('view/jobs_full', array(
                    'model' => $model
                ));
            } else {
                $this->render('full', array(
                    'model' => $model,
                ));
            }
        }


    }

    public function actionApprove($id, $page = 'view')
    {
        $this->jobStatus($id, Job::STATUS_APPROVED);
    }

    public function actionReject($id)
    {
        $this->jobStatus($id, Job::STATUS_REJECTED);
    }

    protected function jobStatus($id, $status)
    {
        /**
         * @var $job Job
         */
        $job = Job::model()->with('organization')->findByPk($id);
        if ($job === NULL ||
            $job->task === NULL ||
            !($job->task->user_id == $this->_user()->id ||
                $job->task->group_id && $this->_user()->group_id == $job->task->group_id) ||
            $this->_user()->role != User::ROLE_SUPER_ADMIN
        )
            throw new CHttpException(404, 'The requested page does not exist.');

        $job->status = $status;
        $job->setScenario('status');
        try {
            $job->save(false);
            if ($job->status == Job::STATUS_APPROVED) Yii::app()->user->setFlash('success', __('Work of <b>:name</b> approved ', array(':name' => $job->organization->name)));
            if ($job->status == Job::STATUS_REJECTED) Yii::app()->user->setFlash('danger', __('Work of <b>:name</b> rejected ', array(':name' => $job->organization->name)));
        } catch (Exception $e) {
            Yii::app()->user->setFlash('danger', $e->getMessage());
        }
        if (Yii::app()->request->isAjaxRequest) {
            return $this->renderPartial('view/job/view', array(
                'model' => $job,
            ));
        }
        if (isset($_SERVER['HTTP_REFERER'])) {
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
        $this->redirect(array('view', $job->task->id));
    }


    public function actionDisable($id)
    {
        $model = $this->loadModel($id);
        $model->setScenario('status');
        if ($model->canUpdate($this->_user())) {
            $model->status = Task::STATUS_DISABLED;
            try {
                $model->save(false);
                Yii::app()->user->setFlash('success', __('Task ":name" disabled successfully', array(':name' => $model->number)));
            } catch (Exception $e) {
                Yii::app()->user->setFlash('danger', $e->getMessage());
            }
            $this->redirect(array('view', 'id' => $model->id));
        } else {
            $this->show404();
        }
    }


    public function actionEnable($id)
    {
        $model = $this->loadModel($id);
        $model->setScenario('status');
        if ($model->canUpdate($this->_user())) {
            $model->status = Task::STATUS_ENABLED;
            try {
                $model->save(false);
                Yii::app()->user->setFlash('success', __('Task ":name" enabled successfully', array(':name' => $model->number)));
            } catch (Exception $e) {
                Yii::app()->user->setFlash('danger', $e->getMessage());
            }
            $this->redirect(array('view', 'id' => $model->id));
        } else {
            $this->show404();
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $model->setScenario('update');
        $this->performAjaxValidation($model);

        if ($model->canUpdate($this->_user())) {
            $this->createAndUpdate($model);
        } else {
            $this->show404();
        }
    }

    public function actionCreate($id)
    {
        $model            = new Task();
        $model->period_id = $id;
        $model->setScenario('create');
        if ($model->canCreate($this->_user())) {
            $this->createAndUpdate($model);
        } else {
            $this->show404();
        }
    }

    protected function createAndUpdate(Task $model)
    {
        $this->performAjaxValidation($model);


        if (isset($_POST['Task'])) {
            $model->attributes = $_POST['Task'];
            if (isset($_POST['Task']['task_files']))
                $model->task_files = $_POST['Task']['task_files'];
            if (isset($_POST['Task']['organization_ids']))
                $model->organization_ids = $_POST['Task']['organization_ids'];

            try {
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', __($model->getIsNewRecord() ? 'Task ":name" created successfully' : 'Task ":name" updated successfully', array(':name' => $model->number)));
                    $this->redirect(array('view', 'id' => $model->id));
                }
            } catch (Exception $e) {
                Yii::app()->user->setFlash('danger', $e->getMessage());
            }

        }

        $searchTasks = new Task('search');
        $searchTasks->unsetAttributes();
        if (isset($_GET['Task']))
            $searchTasks->attributes = $_GET['Task'];


        $searchOrganizations = new Organization('search');
        $searchOrganizations->unsetAttributes();
        $searchOrganizations->type = Organization::TYPE_UNIVERSITY;
        if (isset($_GET['Organization']))
            $searchOrganizations->attributes = $_GET['Organization'];


        $searchSelectedOrg = new Organization('search');
        $searchSelectedOrg->unsetAttributes();
        $searchSelectedOrg->so_ids = $model->getOrganizationIds();

        if (isset($_GET['so_ids']))
            $searchSelectedOrg->so_ids = $_GET['so_ids'];


        $this->render($model->getIsNewRecord() ? 'create' : 'update', array(
            'model'               => $model,
            'searchSelectedOrg'   => $searchSelectedOrg,
            'searchTasks'         => $searchTasks,
            'searchOrganizations' => $searchOrganizations,
        ));
    }

    public function actionOrganizations()
    {
        $searchOrganizations = new Organization('search');
        $searchOrganizations->unsetAttributes();
        if (isset($_GET['Organization']))
            $searchOrganizations->attributes = $_GET['Organization'];

        $this->renderPartial('ajax/organizations', array(
            'search' => $searchOrganizations,
        ));
    }

    public function actionSelectedOrg()
    {
        $searchOrganizations = new Organization('search');
        $searchOrganizations->unsetAttributes();
        if (isset($_GET['so_ids']))
            $searchOrganizations->so_ids = $_GET['so_ids'];

        $this->renderPartial('ajax/selectedOrg', array(
            'search' => $searchOrganizations,
        ));
    }

    public function actionTasks()
    {
        $search = new Task('search');
        $search->unsetAttributes();
        if (isset($_GET['Task']))
            $search->attributes = $_GET['Task'];

        $this->renderPartial('ajax/tasks', array(
            'search' => $search,
        ));
    }

    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadModel($id);
            if ($model->canUpdate($this->_user())) {
                $model->delete();
                Yii::app()->user->setFlash('success', __('Task ":name" deleted successfully', array(':name' => $model->number)));
            }
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAdmin()
    {
        $model = new Task('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Task']))
            $model->attributes = $_GET['Task'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionUser($periodId = false)
    {
        $model = new Job('search');
        $model->unsetAttributes();
        if ($periodId) $model->period_id = $periodId;
        if (isset($_GET['Job']))
            $model->attributes = $_GET['Job'];

        $this->render('user', array(
            'model' => $model,
        ));
    }

    public function actionPeriod($periodId)
    {
        $period = Period::model()->findByPk($periodId);
        if ($period === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($this->_user()->role == User::ROLE_USER) {
            return $this->actionUser($periodId);
        }
        $model = new Task('search');
        $model->unsetAttributes(); // clear any default values
        $model->period_id = $periodId;

        if (isset($_GET['Task']))
            $model->attributes = $_GET['Task'];


        $this->render('period', array(
            'model'  => $model,
            'period' => $period
        ));
    }

    /**
     * @param integer $id the ID of the model to be loaded
     * @return Task the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Task::model()->findByPk($id);
        if ($model === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');


        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'task-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionUpload()
    {
        Yii::import("ext.EAjaxUpload.qqFileUploader");

        $folder            = UPLOAD_TEMP_DIR;
        $allowedExtensions = File::$allowedExt;
        $sizeLimit         = 10 * 1024 * 1024;
        $uploader          = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result            = $uploader->handleUpload($folder);
        //sleep(1);
        if (isset($result['ext'])) {
            $class              = File::getFileClass($result['ext']);
            $result['filename'] = "<i class='fa $class'></i> " . $result['orgname'];
        }
        echo json_encode($result);
    }

    public function actionAjaxJob($id)
    {
        $model = Job::model()->with(array('organization', 'user', 'files'))->findByPk($id);
        if ($model) {
            return $this->renderPartial('view/job/view', array(
                'model' => $model,
            ));
        }
        $this->show404();
    }

    public function actionAjaxJobs($id)
    {
        $model = $this->loadModel($id);
        $this->renderPartial('view/jobs', array(
            'model' => $model,
        ));
    }

    public function actionAjaxJobsFull($id)
    {
        $model = $this->loadModel($id);
        $this->renderPartial('view/jobs_full', array(
            'model' => $model,
        ));
    }


    protected function downloadFile(File $file)
    {
        $path = UPLOAD_DIR . $file->task->period_id . DS . $file->task_id . DS . $file->realname;
        if (file_exists($path)) {
            return Yii::app()->getRequest()->sendFile($file->file_name, @file_get_contents($path));
        } elseif (file_exists(UPLOAD_DIR . $file->realname)) {
            return Yii::app()->getRequest()->sendFile($file->file_name, @file_get_contents(UPLOAD_DIR . $file->realname));
        } else {
            echo __('File ":name" not found on server', array(':name' => $file->file_name));
            Yii::app()->end(0, false);
        }
    }

    protected function cannotAccess()
    {
        throw new CHttpException(401, 'You can not access to this file');
    }

    public function actionFile($id)
    {
        /**
         * @var $file File
         * @var $job  Job
         */
        if ($id == intval($id) . '') {
            $job = Job::model()->with(array('files', 'task'))->findByPk($id);
            if ($job) {
                if ($job->task->group_id == $this->_user()->group_id ||
                    $job->organization_id == $this->_user()->organization_id ||
                    $this->_user()->role == User::ROLE_SUPER_ADMIN ||
                    $this->_user()->role == User::ROLE_ADMIN
                ) {
                    if (count($job->files) == 1) return $this->downloadFile($job->files[0]);
                    if (count($job->files) > 1) return $this->redirect(Yii::app()->createUrl('task/job', array('id' => $job->id)));
                } else {
                    return $this->cannotAccess();
                }
            }
        } else {
            $file = File::model()->with(array('task', 'job'))->findByAttributes(array('realname' => $id));
            if ($file) {
                $canAccess = $this->_user()->role == User::ROLE_SUPER_ADMIN || $this->_user()->role == User::ROLE_ADMIN;
                if ($file->job) {
                    $job = $file->job;
                    if ($canAccess || $job->task->group_id == $this->_user()->group_id || $job->organization_id == $this->_user()->organization_id)
                        return $this->downloadFile($file);
                } elseif ($task = $file->task) {
                    foreach ($task->jobs as $job) {
                        if ($job->organization_id == $this->_user()->organization_id) {
                            $canAccess = true;
                            break;
                        }
                    }

                    if ($canAccess || $task->group_id == $this->_user()->group_id)
                        return $this->downloadFile($file);
                }
                return $this->cannotAccess();
            }
        }
        $this->show404();
    }

    public function actionFix()
    {
        File::fixOldFiles();
    }
}