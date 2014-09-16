<?php
/* @var $this PeriodController */
/* @var $model Period */
?>

<?php
$this->breadcrumbs = array(
    __('Periods') => array('index'),
    $model->name  => array('view', 'id' => $model->id),
    __('Update'),
);
?>

<?php echo BsHtml::pageHeader('Update', 'Period ' . $model->id) ?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>