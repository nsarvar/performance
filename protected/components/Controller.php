<?php

class Controller extends CController
{

    public $layout = '//layouts/dialog';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();


    public function init()
    {
        if ($lang = Yii::app()->request->getParam('lang')) {
            if (in_array($lang, array('en', 'uz_latn', 'uz_cryl', 'ru'))) {
                Yii::app()->session['language'] = $lang;
                $this->redirect('/');
            }
        }

        Yii::app()->language = (Yii::app()->session['language']) ? Yii::app()->session['language'] : 'en';
    }


    protected $_user;
    protected $_role;

    /**
     * @return User
     */
    public function _user()
    {
        if (!Yii::app()->user->isGuest && !$this->_user) {
            $this->_user = User::model()->findByPk(Yii::app()->user->user_id);
            $this->_role = $this->_user()->role;
        }

        return $this->_user;
    }


    public function filters()
    {
        return array(
            'accessControl',
            'RoleChecking',
        );
    }

    public function isMenuVisible($controller)
    {
        $acl = $this->acl;

        return isset($acl[$this->_role]['*']) || isset($acl[$this->_role][$controller]) && in_array('index', $acl[$this->_role][$controller]);
    }

    protected $acl = array(
        User::ROLE_SUPER_ADMIN => array('*' => '*'),
        User::ROLE_ADMIN       => array(
            'site'         => array('index', 'login', 'logout'),
            'calendar'     => array('index', 'events'),
            'period'       => array('index', 'ajax', 'view'),
            'group'        => array('index', 'view'),
            'organization' => array('index', 'admin', 'parent', 'view'),
            'user'         => array('index', 'admin', 'ajax', 'view'),
            'task'         => array('*')
        ),
        User::ROLE_MODERATOR   => array(),
        User::ROLE_USER        => array(
            'site'         => array('index', 'login', 'logout', 'usertasks'),
            'calendar'     => array('index', 'events'),
            'period'       => array('index', 'ajax', 'view'),
            'organization' => array('view'),
            'user'         => array('view'),
            'task'         => array('index', 'job', 'view', 'upload', 'file', 'period', 'user')
        ),
    );

    public function filterRoleChecking($c)
    {
        $acl = $this->acl;
        if ($user = $this->_user()) {
            $this->layout = '//layouts/' . $this->_role;
            $action = Yii::app()->controller->action->id;
            $controller = Yii::app()->controller->id;

            if (isset($acl[$this->_role])) {
                if (
                    isset($acl[$this->_role]) &&
                    (isset($acl[$this->_role]['*']) ||
                        (isset($acl[$this->_role][$controller]) &&
                            (in_array('*', $acl[$this->_role][$controller]) ||
                                in_array($action, $acl[$this->_role][$controller]))))
                ) {
                    return $c->run();
                }
            }

        } elseif (Yii::app()->controller->action->id == 'login') {
            return $c->run();
        }

        //return $c->run();
        $this->show404();
    }


    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('login'),
                'users'   => array('*'),
            ),
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }


    protected function renderJSON($data)
    {
        header('Content-type: application/json');
        echo CJSON::encode($data);

        foreach (Yii::app()->log->routes as $route) {
            if ($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        }
        Yii::app()->end();
    }

    protected function show404()
    {
        throw new CHttpException(404, 'The requested page does not exist.');
    }

}