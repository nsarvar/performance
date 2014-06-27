<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<?php
$this->widget('bootstrap.widgets.BsNavbar', array(
    'collapse'    => true,
    'position'    => BsHtml::NAVBAR_POSITION_FIXED_TOP,
    'brandLabel'  => BsHtml::icon(BsHtml::GLYPHICON_HOME),
    'brandUrl'    => Yii::app()->homeUrl,
    'items'       => array(
        array(
            'class'           => 'bootstrap.widgets.BsNav',
            'type'            => 'navbar',
            'activateParents' => true,
            'items'           => array(
                array(
                    'label' => __('app', 'Organizations'),
                    'url'   => array(
                        '/organization'
                    ),
                ),
                array(
                    'label' => __('app', 'Periods'),
                    'url'   => array(
                        '/period'
                    ),
                ),
                array(
                    'label' => __('app', 'Tasks'),
                    'url'   => array(
                        '/tasks'
                    ),
                ),
                array(
                    'label' => __('app', 'Calendar'),
                    'url'   => array(
                        '/tasks/calendar'
                    ),
                ),

                array(
                    'label' => __('app', 'Users'),
                    'url'   => array(
                        '/user'
                    ),
                ),
                array(
                    'label' => __('app', 'Reports'),
                    'url'   => array(
                        '/reports'
                    ),
                ),
            )
        ),
        (!Yii::app()->user->isGuest) ?
            array(
                'class'           => 'bootstrap.widgets.BsNav',
                'type'            => 'navbar',
                'activateParents' => true,
                'items'           => array(
                    array(
                        'label'=> 'Notifications',
                        'url'  => array('notification'),
                        'icon'=>'glyphicons fa fa-bell'
                    ),
                    array(
                        'label' => Yii::app()->user->name,
                        'url'   => array(
                            '/site/user'
                        ),
                        'items' => array(
                            array(
                                'label'   => 'Preferences',
                                'url'     => array(
                                    '/site/user'
                                ),
                                'icon'    => BsHtml::GLYPHICON_USER
                            ),
                            BsHtml::menuDivider(),
                            array(
                                'label'   => 'Logout',
                                'icon'    => BsHtml::GLYPHICON_LOG_OUT,
                                'url'     => array(
                                    '/site/logout'
                                ),
                            ),
                        )
                    )
                ),
                'htmlOptions'     => array(
                    'pull' => BsHtml::NAVBAR_NAV_PULL_RIGHT
                )
            )
            : array(
            'class'           => 'bootstrap.widgets.BsNav',
            'type'            => 'navbar',
            'activateParents' => true,
            'items'           => array(
                array(
                    'label' => 'Login',
                    'url'   => array(
                        '/site/login'
                    ),
                )
            ),
            'htmlOptions'     => array(
                'pull' => BsHtml::NAVBAR_NAV_PULL_RIGHT
            )
        )
    )
));
?>

<div class="container" id="page">
    <?php if ($flashMessages = Yii::app()->user->getFlashes()): ?>
    <?php foreach ($flashMessages as $key => $message): ?>
        <div class="alert alert-<?=$key?> alert-dismissable">
            <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?=$message?>
        </div>
        <?php endforeach; ?>
    <?php endif ?>

    <?php if (isset($this->breadcrumbs)): ?>
    <?php $this->widget('bootstrap.widgets.BsBreadcrumb', array(
        'links' => $this->breadcrumbs,
    )); ?>
    <?php endif?>

    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>