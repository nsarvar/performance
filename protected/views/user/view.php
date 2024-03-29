<?php
/* @var $this UserController */
/* @var $model User */
?>

<?php
$this->breadcrumbs = array(
    __('Users') => array('index'),
    $model->name,
);
?>

<?php echo BsHtml::pageHeader('View', 'User ' . $model->id) ?>

<?php $this->widget('zii.widgets.CDetailView', array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'        => $model,
    'attributes'  => array(
        'name',
        'email',
        'telephone',
        'mobile',
        'role',
    ),
)); ?>