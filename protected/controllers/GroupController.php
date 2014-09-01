<?php

class GroupController extends Controller
{

    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate()
    {
        $model = new Group;
        $this->performAjaxValidation($model);

        if (isset($_POST['Group'])) {
            $model->attributes = $_POST['Group'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', __('Group ":name" is created', array(':name' => $model->name)));
                $this->redirect(array('index'));
            }

        }

        $this->render('create', array(
            'model' => $model,
        ));
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);

        if (isset($_POST['Group'])) {
            $model->attributes = $_POST['Group'];
            try {
                $model->save();
                Yii::app()->user->setFlash('success', __('Group ":name" is updated', array(':name' => $model->name)));
            } catch (Exception $e) {
                Yii::app()->user->setFlash('danger', $e->getMessage());
            }

        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id)
    {
        try {
            $model = $this->loadModel($id);
            if ($model->delete()) {
                Yii::app()->user->setFlash('success', __('Group ":name" is deleted', array(':name' => $model->name)));
            }
        } catch (Exception $e) {
            Yii::app()->user->setFlash('danger', $e->getMessage());

        }
        $this->redirect(array('group/index'));
    }

    public function actionIndex()
    {
        $model = new Group('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Group']))
            $model->attributes = $_GET['Group'];
        if (Yii::app()->request->isAjaxRequest)
            $this->renderPartial('index/grid', array(
                'model' => $model,
            )); else
            $this->render('index', array(
                'model' => $model,
            ));
    }

    protected function loadModel($id)
    {
        $model = Group::model()->findByPk($id);
        if ($model === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'group-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}