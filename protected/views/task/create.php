<?php
/* @var $this TaskController */
/* @var $model Task */
?>

<?php
if ($model->period_id)
    $this->breadcrumbs = array(
        __('Periods')                                                   => array('period/index'),
        __('Task on :period', array(':period' => $model->period->name)) => array('task/period/', 'id' => $model->period_id),
        __('Add New Task')
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