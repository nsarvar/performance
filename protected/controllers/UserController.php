<?php

class UserController extends Controller
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
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions'=> array('index', 'view','ajax'),
                'users'  => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=> array('create', 'update'),
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
        $model           = new User;
        $model->scenario = 'insert';
        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes      = $_POST['User'];
            $model->password_repeat = $_POST['User']['password_repeat'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('app', 'User ":login" is crated', array(':login'=> $model->login)));
                $this->redirect(array('update', 'id'=> $model->id));
            }
        }

        $this->render('create', array(
            'model'=> $model,
        ));
    }

    public function actionUpdate($id)
    {
        $model           = $this->loadModel($id);
        $model->scenario = 'update';

        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->setAttributes($_POST['User']);

            if (isset($_POST['change_password'])) $model->password_repeat = $_POST['User']['password_repeat'];

            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('app', 'User ":login" is updated', array(':login'=> $model->login)));
                if (isset($_POST['change_password'])) Yii::app()->user->setFlash('success', Yii::t('app', 'Password has changed'));
                $this->redirect(array('update', 'id'=> $model->id));
            }

        }

        $this->render('update', array(
            'model'=> $model,
        ));
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if ($model->delete()) {
            Yii::app()->user->setFlash('success', Yii::t('app', 'User ":login" is deleted', array(':login'=> $model->login)));
        }
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionIndex()
    {
        return $this->actionAdmin();
    }


    public function actionAdmin()
    {
        $model = new User('search');
        $model->unsetAttributes();
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array(
            'model'=> $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjax($organization)
    {
        $this->renderPartial('ajax', array(
            'organization'=> $organization,
        ));
    }
}