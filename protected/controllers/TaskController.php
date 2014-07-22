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
                'actions'=> array('index', 'view', 'ajax'),
                'users'  => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=> array('create', 'update', 'admin', 'period', 'upload'),
                'users'  => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=> array('admin', 'delete'),
                'users'  => array('admin'),
            ),
            array('deny', // deny all users
                'users'=> array('*'),
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
            'model'=> $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Task;
        $this->performAjaxValidation($model);

        $search = new Task('search');
        $search->unsetAttributes();
        if (isset($_GET['Task']))
            $search->attributes = $_GET['Task'];



        // Uncomment the following line if AJAX validation is needed

        if (isset($_POST['Task'])) {
            $model->attributes = $_POST['Task'];
            if ($model->save())
                $this->redirect(array('view', 'id'=> $model->id));
        }

        $this->render('create', array(
            'model' => $model,
            'search'=> $search,
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
                $this->redirect(array('view', 'id'=> $model->id));
        }

        $this->render('update', array(
            'model'=> $model,
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
            'model'=> $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionPeriod($periodId)
    {
        $period = Period::model()->findByPk($periodId);
        if ($period === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        $model = new Task('search');
        $model->unsetAttributes(); // clear any default values
        $model->period_id = $periodId;

        if (isset($_GET['Task']))
            $model->attributes = $_GET['Task'];


        $this->render('period', array(
            'model' => $model,
            'period'=> $period
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
        if ($model === null)
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


    public function actionAjax()
    {
        $search = new Task('search');
        $search->unsetAttributes();
        if (isset($_GET['Task']))
            $search->attributes = $_GET['Task'];

        $this->renderPartial('ajax', array(
            'search'=> $search,
        ));
    }

    public function actionUpload()
    {
        Yii::import("ext.EAjaxUpload.qqFileUploader");

        $folder            = 'temp/';
        $allowedExtensions = File::$allowedExt;
        $sizeLimit         = 10 * 1024 * 1024;
        $uploader          = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result            = $uploader->handleUpload($folder);
        sleep(4);
        $fileSize = filesize($folder . $result['filename']); //GETTING FILE SIZE
        $fileName = $result['filename']; //GETTING FILE NAME

        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    }
}