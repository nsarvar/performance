<?php
/* @var $this PeriodController */
/* @var $model Period */
?>

<?php
$this->breadcrumbs=array(
	'Periods'=>array('index'),
	'Create',
);

$this->menu=array(
    array('icon' => 'glyphicon glyphicon-list','label'=>'List Period', 'url'=>array('index')),
	array('icon' => 'glyphicon glyphicon-tasks','label'=>'Manage Period', 'url'=>array('admin')),
);
?>

<?php echo BsHtml::pageHeader('Create','Period') ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>