<?php

class OrganizationController extends Controller
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
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=> array('create', 'update','index', 'view','parent','test'),
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
        $model = new Organization;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Organization'])) {
            $model->attributes = $_POST['Organization'];
            if ($model->save())
                $this->redirect(array('view', 'id'=> $model->id));
        }

        $this->render('create', array(
            'model'=> $model,
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
         $this->performAjaxValidation($model);

        if (isset($_POST['Organization'])) {
            $model->attributes = $_POST['Organization'];
            try {
                $model->save();
                Yii::app()->user->setFlash('success', Yii::t('app', 'Organization ":name" is updated', array(':name'=> $model->name)));
            } catch (Exception $e) {
                Yii::app()->user->setFlash('danger', $e->getMessage());
            }

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

        try {
            $model = $this->loadModel($id);
            if ($model->delete()) {
                Yii::app()->user->setFlash('success', Yii::t('app', 'Organization ":name" is deleted', array(':name'=> $model->name)));
            }
        } catch (Exception $e) {
            Yii::app()->user->setFlash('danger', $e->getMessage());

        }
        $this->redirect(array('organization/index'));

    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Organization('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Organization']))
            $model->attributes = $_GET['Organization'];

        $this->render('admin', array(
            'model'=> $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Organization the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Organization::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Organization $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'organization-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    public function actionParent($id)
    {
        $this->renderPartial('parent', array(
            'parent'=> $id,
        ));
    }

    public function actionTest()
    {
        Period::getCurrentPeriod();
    }
}