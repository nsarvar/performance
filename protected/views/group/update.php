<?php
/* @var $this GroupController */
/* @var $model Group */
?>

<?php
$this->breadcrumbs = array(
    __('Users')  => array('user'),
    __('Groups') => array('index'),
    $model->name,
);
?>

<?php echo BsHtml::pageHeader($model->name) ?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>