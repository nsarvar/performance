<?php
/* @var $this TaskController */
/* @var $model Task */
?>

<?php
$this->breadcrumbs = array(
    __('app','Tasks')     => array('index'),
    __('app','Create New Task'),
);
?>
<div class="page-header">
    <h3>
        <?=__('app','Create New Task')?>
    </h3>
</div>

<?php $this->renderPartial('_form', array('model'=> $model,'search'=> $search)); ?>