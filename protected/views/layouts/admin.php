<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<?php
$this->widget('bootstrap.widgets.BsNavbar', array(
    'collapse'   => true,
    'position'   => BsHtml::NAVBAR_POSITION_FIXED_TOP,
    'brandLabel' => BsHtml::icon(BsHtml::GLYPHICON_HOME),
    'brandUrl'   => Yii::app()->homeUrl,
    'items'      => array(
        array(
            'class'           => 'bootstrap.widgets.BsNav',
            'type'            => 'navbar',
            'activateParents' => true,
            'items'           => array(
                array(
                    'label'   => __('Calendar'),
                    'url'     => array(
                        '/calendar'
                    ),
                    'visible' => false

                ),
                array(
                    'label' => __('Organizations'),
                    'url'   => array(
                        '/organization'
                    ),
                ),
                array(
                    'label' => __('Periods'),
                    'url'   => array(
                        '/period'
                    ),
                ),
                array(
                    'label' => __('Tasks'),
                    'url'   => array(
                        '/task'
                    ),
                ),
                array(
                    'label' => __('Users'),
                    'url'   => array(
                        '/user'
                    ),
                ),
                array(
                    'label' => __('Groups'),
                    'url'   => array(
                        '/group'
                    ),
                ),
                array(
                    'label' => __('Reports'),
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
                        'label' => 'Notifications',
                        'url'   => array('notification'),
                        'icon'  => 'glyphicons fa fa-bell'
                    ),
                    array(
                        'label' => Yii::app()->user->name,
                        'url'   => array(
                            '/site/user'
                        ),
                        'items' => array(
                            array(
                                'label' => 'Preferences',
                                'url'   => array(
                                    '/site/user'
                                ),
                                'icon'  => BsHtml::GLYPHICON_USER
                            ),
                            BsHtml::menuDivider(),
                            array(
                                'label' => 'Logout',
                                'icon'  => BsHtml::GLYPHICON_LOG_OUT,
                                'url'   => array(
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
                <div class="alert alert-<?= $key ?> alert-dismissable">
                    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $message ?>
                </div>
            <?php endforeach; ?>
        <?php endif ?>

        <?php if (isset($this->breadcrumbs)): ?>
            <?php $this->widget('bootstrap.widgets.BsBreadcrumb', array(
                'links' => $this->breadcrumbs,
            )); ?>
        <?php endif ?>

        <?php echo $content; ?>
    </div>

    <footer>
        <div class="container">
            <hr>
            <div class="row">
                <div class="col-lg-12 footer-below">
                    <p class="text-center text-muted">
                        Copyright &copy; 2014 <a href="http://edu.uz">
                            <?= __("O'zbekiston Respublikasi Oliy va o'rta maxsus ta'lim vazirligi") ?></a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
<?php $this->endContent(); ?>