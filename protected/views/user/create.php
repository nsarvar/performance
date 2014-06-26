<?php
/* @var $this UserController */
/* @var $model User */
?>

<?php
$this->breadcrumbs = array(
    'Users'     => array('index'),
    'Create New User',
);
?>
<div class="page-header">
    <h3>
        <?=$model->name?>
    </h3>
</div>

<?php $this->renderPartial('_form', array('model'=> $model)); ?>