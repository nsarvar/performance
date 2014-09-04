<?php
$cs = Yii::app()->clientScript;
$themePath = Yii::app()->theme->baseUrl;
$cs
    ->registerCssFile($themePath . '/skin/css/bootstrap.css')
    ->registerCssFile($themePath . '/skin/css/bootstrap-theme.css')
    ->registerCssFile($themePath . '/skin/css/font-awesome.min.css')
    ->registerCssFile($themePath . '/skin/css/styles.css')
    ->registerCssFile($themePath . '/skin/css/bootstrap-select.min.css');

$cs
    ->registerCoreScript('jquery', CClientScript::POS_END)
    //->registerCoreScript('jquery.ui', CClientScript::POS_END)
    ->registerScriptFile($themePath . '/skin/js/bootstrap.js', CClientScript::POS_END)
    ->registerScriptFile($themePath . '/skin/js/dashboard.js', CClientScript::POS_END)
    ->registerScriptFile($themePath . '/skin/js/bootstrap-select.min.js', CClientScript::POS_END)
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
    <link rel="icon" href="/favicon.jpeg" type="image/jpeg">
    <link rel="shortcut icon" href="/favicon.jpeg">
    <!--[if lt IE 9]>
    <script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/html5shiv.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="user_role_<?= Yii::app()->user->hasState('role') ? Yii::app()->user->role : 'none' ?>">
<?php echo $content; ?>

</body>
</html>
