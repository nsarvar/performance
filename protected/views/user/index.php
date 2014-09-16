<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs = array(
    __('Users'),
);
?>

<?php echo BsHtml::pageHeader('Users') ?>
<?php $this->widget('bootstrap.widgets.BsListView', array(
    'dataProvider' => $dataProvider,
    'itemView'     => '_view',
)); ?>