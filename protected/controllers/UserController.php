<?php

class UserController extends Controller
{

    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate()
    {
        $model           = new User;
        $model->scenario = 'insert';
        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes      = $_POST['User'];
            $model->password_repeat = $_POST['User']['password_repeat'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('app', 'User ":login" is crated', array(':login' => $model->login)));
                $this->redirect(array('update', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
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
                Yii::app()->user->setFlash('success', Yii::t('app', 'User ":login" is updated', array(':login' => $model->login)));
                if (isset($_POST['change_password'])) Yii::app()->user->setFlash('success', Yii::t('app', 'Password has changed'));
                $this->redirect(array('update', 'id' => $model->id));
            }

        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if ($model->delete()) {
            Yii::app()->user->setFlash('success', Yii::t('app', 'User ":login" is deleted', array(':login' => $model->login)));
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
            'model' => $model,
        ));
    }


    protected function loadModel($id)
    {
        $model = User::model()->findByPk($id);
        if ($model === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }


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
            'organization' => $organization,
        ));
    }
}