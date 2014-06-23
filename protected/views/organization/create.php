<?php
/* @var $this OrganizationController */
/* @var $model Organization */
?>

<?php
$this->breadcrumbs=array(
	'Organizations'=>array('index'),
	'Create',
);

$this->menu=array(
    array('icon' => 'glyphicon glyphicon-list','label'=>'List Organization', 'url'=>array('index')),
	array('icon' => 'glyphicon glyphicon-tasks','label'=>'Manage Organization', 'url'=>array('admin')),
);
?>

<?php echo BsHtml::pageHeader('Create','Organization') ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>