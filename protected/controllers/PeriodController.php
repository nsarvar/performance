<?php

class PeriodController extends Controller
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
                'actions'=> array('index', 'view'),
                'users'  => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=> array('create', 'update'),
                'users'  => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=> array('list', 'delete'),
                'users'  => array('admin'),
            ),
            array('deny', // deny all users
                'users'=> array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $model = new Period('search');
        $model->unsetAttributes();

        if (isset($_GET['Period']))
            $model->attributes = $_GET['Period'];

        $this->render('list', array(
            'model'=> $model,
        ));
    }

}