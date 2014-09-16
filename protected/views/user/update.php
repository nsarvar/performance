<?php
/* @var $this UserController */
/* @var $model User */
?>

<?php
$this->breadcrumbs = array(
    __('Users')     => array('index'),
    $model->login,
);
?>
<div class="page-header">
    <h3>
        <?=$model->name?>
    </h3>
</div>

<?php $this->renderPartial('_form', array('model'=> $model)); ?>