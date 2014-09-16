<?php
/* @var $this UserController */
/* @var $model User */
?>

<?php
$this->breadcrumbs = array(
    __('Users') => array('index'),
    __('Create New User'),
);
?>
    <div class="page-header">
        <h3>
            <?= __('Create New User') ?>
        </h3>
    </div>

<?php $this->renderPartial('_form', array('model' => $model)); ?>