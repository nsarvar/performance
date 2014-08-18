<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;

$model = new Job('search');
?>
<?php $types = Organization::getTypesArray(false); ?>
<?php $organizations = Organization::getListByType(); ?>


<ol class="breadcrumb">
    <li><a href="/"><?= __('Home') ?></a></li>
    <li><a href="/task/user"><?= __('Tasks') ?></a></li>
    <li><?= __('Active') ?></li>
</ol>

<div class="page-header">
    <h3>
        <i class="fa fa-tasks"></i> <?= __('Active Tasks') ?>
    </h3>
</div>

<div class="row">
    <div class="col col-md-3">

    </div>
    <div class="col col-md-12">
        <?php
        $this->renderPartial('user/tasks', array(
            'model' => $model,
        ));
        ?>
    </div>
</div>



