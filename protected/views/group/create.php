<?php
/* @var $this GroupController */
/* @var $model Group */
?>

<?php
$this->breadcrumbs = array(
    'Users'  => array('user'),
    'Groups' => array('index'),
    'Create New Group',
);
?>

<?php echo BsHtml::pageHeader('Create New Group') ?>

<?php $this->renderPartial('_form', array('model' => $model)); ?>