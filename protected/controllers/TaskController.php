<?php

class TaskController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/dashboard';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'test'),
                'users'   => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'period', 'upload', 'tasks', 'organizations', 'selectedOrg'),
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

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Task();
        $this->performAjaxValidation($model);

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
        if (isset($_GET['so_ids']))
            $searchSelectedOrg->so_ids = $_GET['so_ids'];


        if (isset($_POST['Task'])) {
            $model->attributes = $_POST['Task'];
            if (isset($_POST['Task']['task_files']))
                $model->task_files = $_POST['Task']['task_files'];

            try {
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', __('Task ":name" created successfully', array(':name' => $model->number)));
                    $this->redirect(array('view', 'id' => $model->id));
                }
            } catch (Exception $e) {
                Yii::app()->user->setFlash('danger', $e->getMessage());
            }


        }

        $this->render('create', array(
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


    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Task'])) {
            $model->attributes = $_POST['Task'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        return $this->actionAdmin();
    }

    /**
     * Manages all models.
     */
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

    /**
     * Manages all models.
     */
    public function actionPeriod($periodId)
    {
        $period = Period::model()->findByPk($periodId);
        if ($period === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
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
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
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

    /**
     * Performs the AJAX validation.
     * @param Task $model the model to be validated
     */
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
                if (in_array($result['ext'], $exts)) {
                    $class = $cl;
                    break;
                }

            }
            $result['filename'] = "<i class='fa $class'></i> " . $result['orgname'];
        }
        echo json_encode($result);
    }

    public function actionTest()
    {
        $start = date_create_from_format('d-m-Y H:i:s', '12-08-2014 23:59:59');
        echo $start->format('Y-m-d H:i:s');
    }
}