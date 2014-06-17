<?php /* @var $this Controller */ ?>
<?php Yii::app()->clientScript->registerCss('login_css', "
body {
    background-color: #F8F8F8;
}
"); ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="container middle_area">
    <div class="content-main">
        <div class="row">
            <div class="col-lg-4 col-md-3"></div>
            <div class="col-lg-4 col-md-6">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>