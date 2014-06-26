<?php
/* @var $this UserController */
/* @var $model User */
?>

<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
    array('icon' => 'glyphicon glyphicon-list','label'=>'List User', 'url'=>array('index')),
	array('icon' => 'glyphicon glyphicon-plus-sign','label'=>'Create User', 'url'=>array('create')),
    array('icon' => 'glyphicon glyphicon-list-alt','label'=>'View User', 'url'=>array('view', 'id'=>$model->id)),
    array('icon' => 'glyphicon glyphicon-tasks','label'=>'Manage User', 'url'=>array('admin')),
);
?>

<?php echo BsHtml::pageHeader('Update','User '.$model->id) ?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>