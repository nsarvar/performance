<?php
/* @var $this GroupController */
/* @var $model Group */
?>

<?php
$this->breadcrumbs = array(
    __('Users')  => array('user'),
    __('Groups') => array('index'),
    __('Create New Group'),
);
?>

<?php echo BsHtml::pageHeader(__('Create New Group')) ?>

<?php $this->renderPartial('_form', array('model' => $model)); ?>