<?php
/* @var $this OrganizationController */
/* @var $model Organization */
?>

<?php
$this->breadcrumbs = array(
    'Organizations'=> array('index'),
    $model->name
);
?>
<div class="page-header">
    <h3>
        <?=$model->name?>
    </h3>
</div>
<?php $this->renderPartial('_form', array('model'=> $model)); ?>