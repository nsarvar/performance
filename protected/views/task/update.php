<?php
if ($model->period_id)
    $this->breadcrumbs = array(
        __('Periods')                                                   => array('period/index'),
        __('Task on :period', array(':period' => $model->period->name)) => array('task/period/', 'id' => $model->period_id),
        $model->name                                                    => array('task/view', 'id' => $model->id),
        __('Update')
    );
?>
    <div class="page-header">
        <h3>
            <?= $model->name ?>
        </h3>
    </div>

<?php $this->renderPartial('_form',
    array(
        'model'               => $model,
        'searchOrganizations' => $searchOrganizations,
        'searchTasks'         => $searchTasks,
        'searchSelectedOrg'   => $searchSelectedOrg,
    )); ?>