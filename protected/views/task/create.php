<?php
/* @var $this TaskController */
/* @var $model Task */
?>

<?php
$this->breadcrumbs = array(
    __('Tasks') => array('index'),
    __('Create New Task'),
);
?>
    <div class="page-header">
        <h3>
            <?= __('Create New Task') ?>
        </h3>
    </div>

<?php $this->renderPartial('_form',
    array(
        'model'               => $model,
        'searchOrganizations' => $searchOrganizations,
        'searchTasks'         => $searchTasks,
        'searchSelectedOrg'   => $searchSelectedOrg,
    )); ?>