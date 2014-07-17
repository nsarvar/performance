<?php
/* @var $this UserController */
/* @var $model User */
?>

<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->name,
);
?>

<?php echo BsHtml::pageHeader('View','User '.$model->id) ?>

<?php $this->widget('zii.widgets.CDetailView',array(
	'htmlOptions' => array(
		'class' => 'table table-striped table-condensed table-hover',
	),
	'data'=>$model,
	'attributes'=>array(
		'id',
		'login',
		'password',
		'name',
		'organization_id',
		'group_id',
		'email',
		'telephone',
		'mobile',
		'picture',
		'status',
		'created_at',
		'role',
	),
)); ?>