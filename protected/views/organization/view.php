<?php
/* @var $this OrganizationController */
/* @var $model Organization */
?>

<?php
$this->breadcrumbs=array(
	'Organizations'=>array('index'),
	$model->name,
);

$this->menu=array(
    array('icon' => 'glyphicon glyphicon-list','label'=>'List Organization', 'url'=>array('index')),
	array('icon' => 'glyphicon glyphicon-plus-sign','label'=>'Create Organization', 'url'=>array('create')),
	array('icon' => 'glyphicon glyphicon-edit','label'=>'Update Organization', 'url'=>array('update', 'id'=>$model->id)),
	array('icon' => 'glyphicon glyphicon-minus-sign','label'=>'Delete Organization', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('icon' => 'glyphicon glyphicon-tasks','label'=>'Manage Organization', 'url'=>array('admin')),
);
?>

<?php echo BsHtml::pageHeader('View','Organization '.$model->id) ?>

<?php $this->widget('zii.widgets.CDetailView',array(
	'htmlOptions' => array(
		'class' => 'table table-striped table-condensed table-hover',
	),
	'data'=>$model,
	'attributes'=>array(
		'id',
		'parent_id',
		'name',
		'short_name',
		'description',
		'address',
		'phone',
		'email',
		'web_site',
		'type',
		'region_id',
		'created_at',
	),
)); ?>