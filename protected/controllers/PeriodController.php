<?php

class PeriodController extends Controller
{

    public function actionIndex()
    {
        $model = new Period('search');
        $model->unsetAttributes();

        if (isset($_GET['Period']))
            $model->attributes = $_GET['Period'];

        $this->render('list', array(
            'model' => $model,
        ));
    }

    public function actionAjax($status)
    {
        $this->renderPartial('ajax', array(
            'status' => $status,
        ));
    }

}