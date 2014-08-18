<?php
/* @var $this GroupController */
/* @var $model Group */
?>

<?php
$this->breadcrumbs = array(
    'Users'  => array('user'),
    'Groups' => array('index'),
    $model->name,
);
?>

<?php echo BsHtml::pageHeader($model->name) ?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>