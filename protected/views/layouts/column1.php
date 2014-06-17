<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<?php
$this->widget('bootstrap.widgets.BsNavbar', array(
    'collapse'   => true,
    'brandLabel' => BsHtml::icon(BsHtml::GLYPHICON_HOME),
    'brandUrl'   => Yii::app()->homeUrl,
    'items'      => array(
        array(
            'class'           => 'bootstrap.widgets.BsNav',
            'type'            => 'navbar',
            'activateParents' => true,
            'items'           => array(
                array(
                    'label' => __('app', 'Home'),
                    'url'   => array(
                        '/site/index'
                    ),
                ),
                array(
                    'label' => 'About',
                    'url'   => array(
                        '/site/page',
                        'view' => 'about'
                    )
                ),
                array(
                    'label' => 'Lat',
                    'url'   => array(
                        '/site/language',
                        'lang' => 'uz_latn'
                    )
                ),
                array(
                    'label' => 'Contact',
                    'url'   => array(
                        '/site/contact'
                    )
                ),
                array(
                    'label'   => 'Login',
                    'url'     => array(
                        '/site/login'
                    ),
                    'pull'    => BsHtml::NAVBAR_NAV_PULL_RIGHT,
                    'visible' => Yii::app()->user->isGuest
                ),
                array(
                    'label'   => 'Logout (' . Yii::app()->user->name . ')',
                    'pull'    => BsHtml::NAVBAR_NAV_PULL_RIGHT,
                    'url'     => array(
                        '/site/logout'
                    ),
                    'visible' => !Yii::app()->user->isGuest
                ),

            )
        ),
        array(
            'class'           => 'bootstrap.widgets.BsNav',
            'type'            => 'navbar',
            'activateParents' => true,
            'items'           => array(
                array(
                    'label' => 'Tes',
                    'url'   => array(
                        '/site/index'
                    ),

                    'items' => array(
                        BsHtml::menuHeader(BsHtml::icon(BsHtml::GLYPHICON_BOOKMARK), array(
                            'class' => 'text-center',
                            'style' => 'color:#99cc32;font-size:32px;'
                        )),
                        array(
                            'label' => 'Home',
                            'url'   => array(
                                '/site/index'
                            )
                        ),
                        array(
                            'label' => 'About',
                            'url'   => array(
                                '/site/page',
                                'view' => 'about'
                            )
                        ),
                        array(
                            'label' => 'Contact',
                            'url'   => array(
                                '/site/contact'
                            )
                        ),
                        BsHtml::menuDivider(),
                        array(
                            'label'   => 'Login',
                            'url'     => array(
                                '/site/login'
                            ),
                            'visible' => Yii::app()->user->isGuest,
                            'icon'    => BsHtml::GLYPHICON_LOG_IN
                        ),
                        array(
                            'label'   => 'Logout (' . Yii::app()->user->name . ')',
                            'url'     => array(
                                '/site/logout'
                            ),
                            'visible' => !Yii::app()->user->isGuest
                        ),
                        array(
                            'label' => 'Home',
                            'url'   => array(
                                '/site/index'
                            ),
                            'icon'  => BsHtml::GLYPHICON_HOME
                        ),
                        array(
                            'label' => 'About',
                            'url'   => array(
                                '/site/page',
                                'view' => 'about'
                            ),
                            'icon'  => BsHtml::GLYPHICON_PAPERCLIP
                        ),
                        array(
                            'label' => 'Contact',
                            'url'   => array(
                                '/site/contact'
                            ),
                            'icon'  => BsHtml::GLYPHICON_FLOPPY_OPEN
                        )
                    )
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
    <?php if (isset($this->breadcrumbs)): ?>
    <?php $this->widget('bootstrap.widgets.BsBreadcrumb', array(
        'links' => $this->breadcrumbs,
    )); ?>
    <?php endif?>
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>