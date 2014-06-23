<?php
/* @var $this OrganizationController */
/* @var $model Organization */
?>

<?php
$this->breadcrumbs=array(
	'Organizations'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
    array('icon' => 'glyphicon glyphicon-list','label'=>'List Organization', 'url'=>array('index')),
	array('icon' => 'glyphicon glyphicon-plus-sign','label'=>'Create Organization', 'url'=>array('create')),
    array('icon' => 'glyphicon glyphicon-list-alt','label'=>'View Organization', 'url'=>array('view', 'id'=>$model->id)),
    array('icon' => 'glyphicon glyphicon-tasks','label'=>'Manage Organization', 'url'=>array('admin')),
);
?>

<?php echo BsHtml::pageHeader('Update','Organization '.$model->id) ?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>