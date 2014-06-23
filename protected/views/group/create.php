<?php
/* @var $this GroupController */
/* @var $model Group */
?>

<?php
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	'Create',
);

$this->menu=array(
    array('icon' => 'glyphicon glyphicon-list','label'=>'List Group', 'url'=>array('index')),
	array('icon' => 'glyphicon glyphicon-tasks','label'=>'Manage Group', 'url'=>array('admin')),
);
?>

<?php echo BsHtml::pageHeader('Create','Group') ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>