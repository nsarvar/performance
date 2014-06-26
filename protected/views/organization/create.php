<?php
/* @var $this OrganizationController */
/* @var $model Organization */
?>

<?php
$this->breadcrumbs = array(
    'Organizations'=> array('index'),
    'Add New Organization',
);
?>
<hr>
<?php $this->renderPartial('_form', array('model'=> $model)); ?>