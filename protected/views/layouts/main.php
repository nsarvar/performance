<?php
$cs = Yii::app()->clientScript;
$themePath = Yii::app()->theme->baseUrl;
$cs
    ->registerCssFile($themePath . '/skin/css/bootstrap.css')
    ->registerCssFile($themePath . '/skin/css/bootstrap-theme.css');

$cs
    ->registerCoreScript('jquery', CClientScript::POS_END)
    ->registerCoreScript('jquery.ui', CClientScript::POS_END)
    ->registerScriptFile($themePath . '/skin/js/bootstrap.min.js', CClientScript::POS_END)
    ->registerScript('tooltip', "$('[data-toggle=\"tooltip\"]').tooltip(); $('[data-toggle=\"popover\"]').tooltip()", CClientScript::POS_READY);

?>

<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="language" content="en"/>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <!--[if lt IE 9]>
    <script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/html5shiv.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<?php
$this->widget('bootstrap.widgets.BsNavbar', array(
    'collapse' => true,
    'brandLabel' => BsHtml::icon(BsHtml::GLYPHICON_HOME),
    'brandUrl' => Yii::app()->homeUrl,
    'items' => array(
        array(
            'class' => 'bootstrap.widgets.BsNav',
            'type' => 'navbar',
            'activateParents' => true,
            'items' => array(

                array(
                    'label' => 'Home',
                    'url' => array(
                        '/site/index'
                    ),
                ),
                array(
                    'label' => 'About',
                    'url' => array(
                        '/site/page',
                        'view' => 'about'
                    )
                ),
                array(
                    'label' => 'Contact',
                    'url' => array(
                        '/site/contact'
                    )
                ),
                array(
                    'label' => 'Login',
                    'url' => array(
                        '/site/login'
                    ),
                    'pull' => BsHtml::NAVBAR_NAV_PULL_RIGHT,
                    'visible' => Yii::app()->user->isGuest
                ),
                array(
                    'label' => 'Logout (' . Yii::app()->user->name . ')',
                    'pull' => BsHtml::NAVBAR_NAV_PULL_RIGHT,
                    'url' => array(
                        '/site/logout'
                    ),
                    'visible' => !Yii::app()->user->isGuest
                ),

            )
        ),
        array(
            'class' => 'bootstrap.widgets.BsNav',
            'type' => 'navbar',
            'activateParents' => true,
            'items' => array(
                array(
                    'label' => 'Tes',
                    'url' => array(
                        '/site/index'
                    ),

                    'items' => array(
                        BsHtml::menuHeader(BsHtml::icon(BsHtml::GLYPHICON_BOOKMARK), array(
                            'class' => 'text-center',
                            'style' => 'color:#99cc32;font-size:32px;'
                        )),
                        array(
                            'label' => 'Home',
                            'url' => array(
                                '/site/index'
                            )
                        ),
                        array(
                            'label' => 'About',
                            'url' => array(
                                '/site/page',
                                'view' => 'about'
                            )
                        ),
                        array(
                            'label' => 'Contact',
                            'url' => array(
                                '/site/contact'
                            )
                        ),
                        BsHtml::menuDivider(),
                        array(
                            'label' => 'Login',
                            'url' => array(
                                '/site/login'
                            ),
                            'visible' => Yii::app()->user->isGuest,
                            'icon' => BsHtml::GLYPHICON_LOG_IN
                        ),
                        array(
                            'label' => 'Logout (' . Yii::app()->user->name . ')',
                            'url' => array(
                                '/site/logout'
                            ),
                            'visible' => !Yii::app()->user->isGuest
                        ),
                        array(
                            'label' => 'Home',
                            'url' => array(
                                '/site/index'
                            ),
                            'icon' => BsHtml::GLYPHICON_HOME
                        ),
                        array(
                            'label' => 'About',
                            'url' => array(
                                '/site/page',
                                'view' => 'about'
                            ),
                            'icon' => BsHtml::GLYPHICON_PAPERCLIP
                        ),
                        array(
                            'label' => 'Contact',
                            'url' => array(
                                '/site/contact'
                            ),
                            'icon' => BsHtml::GLYPHICON_FLOPPY_OPEN
                        )
                    )
                )
            ),
            'htmlOptions' => array(
                'pull' => BsHtml::NAVBAR_NAV_PULL_RIGHT
            )
        )

    )
));
?>

<div class="container" id="page">


    <div id="mainmenu">
        <?php $this->widget('zii.widgets.CMenu', array(
        'items' => array(
            array('label' => 'Home', 'url' => array('/site/index')),
            array('label' => 'About', 'url' => array('/site/page', 'view' => 'about')),
            array('label' => 'Contact', 'url' => array('/site/contact')),
            array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
            array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
        ),
    )); ?>
    </div>
    <!-- mainmenu -->
    <?php if (isset($this->breadcrumbs)): ?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
        'links' => $this->breadcrumbs,
    )); ?><!-- breadcrumbs -->
    <?php endif?>

    <?php echo $content; ?>

</div>
<!-- page -->

</body>
</html>
