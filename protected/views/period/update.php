<?php
/* @var $this PeriodController */
/* @var $model Period */
?>

<?php
$this->breadcrumbs=array(
	'Periods'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
    array('icon' => 'glyphicon glyphicon-list','label'=>'List Period', 'url'=>array('index')),
	array('icon' => 'glyphicon glyphicon-plus-sign','label'=>'Create Period', 'url'=>array('create')),
    array('icon' => 'glyphicon glyphicon-list-alt','label'=>'View Period', 'url'=>array('view', 'id'=>$model->id)),
    array('icon' => 'glyphicon glyphicon-tasks','label'=>'Manage Period', 'url'=>array('admin')),
);
?>

<?php echo BsHtml::pageHeader('Update','Period '.$model->id) ?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>