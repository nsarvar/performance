<?php
/* @var $this PeriodController */
/* @var $model Period */
?>

<?php
$this->breadcrumbs = array(
    __('Periods') => array('index'),
    $model->name,
);
?>

<?php echo BsHtml::pageHeader(__('View'), __('Period ') . $model->id) ?>

<?php $this->widget('zii.widgets.CDetailView', array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'        => $model,
    'attributes'  => array(
        'id',
        'name',
        'status',
        'task_count',
        'period_from',
        'period_to',
    ),
)); ?>