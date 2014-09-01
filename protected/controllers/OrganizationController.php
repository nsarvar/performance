<?php

class OrganizationController extends Controller
{

    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate()
    {
        $model = new Organization;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Organization'])) {
            $model->attributes = $_POST['Organization'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);

        if (isset($_POST['Organization'])) {
            $model->attributes = $_POST['Organization'];
            try {
                $model->save();
                Yii::app()->user->setFlash('success', Yii::t('app', 'Organization ":name" is updated', array(':name' => $model->name)));
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
                Yii::app()->user->setFlash('success', Yii::t('app', 'Organization ":name" is deleted', array(':name' => $model->name)));
            }
        } catch (Exception $e) {
            Yii::app()->user->setFlash('danger', $e->getMessage());

        }
        $this->redirect(array('organization/index'));

    }

    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionAdmin()
    {
        $model = new Organization('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Organization']))
            $model->attributes = $_GET['Organization'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * @param integer $id the ID of the model to be loaded
     * @return Organization the loaded model
     * @throws CHttpException
     */
    protected function loadModel($id)
    {
        $model = Organization::model()->findByPk($id);
        if ($model === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }


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
            'parent' => $id,
        ));
    }

}