<?php
/* @var $this PeriodController */
/* @var $model Period */
?>

<?php
$this->breadcrumbs=array(
	'Periods'=>array('index'),
	$model->name,
);

$this->menu=array(
    array('icon' => 'glyphicon glyphicon-list','label'=>'List Period', 'url'=>array('index')),
	array('icon' => 'glyphicon glyphicon-plus-sign','label'=>'Create Period', 'url'=>array('create')),
	array('icon' => 'glyphicon glyphicon-edit','label'=>'Update Period', 'url'=>array('update', 'id'=>$model->id)),
	array('icon' => 'glyphicon glyphicon-minus-sign','label'=>'Delete Period', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('icon' => 'glyphicon glyphicon-tasks','label'=>'Manage Period', 'url'=>array('admin')),
);
?>

<?php echo BsHtml::pageHeader('View','Period '.$model->id) ?>

<?php $this->widget('zii.widgets.CDetailView',array(
	'htmlOptions' => array(
		'class' => 'table table-striped table-condensed table-hover',
	),
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'status',
		'task_count',
		'period_from',
		'period_to',
	),
)); ?>