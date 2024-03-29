<?php
/* @var $this TaskController */
/* @var $model Task */
?>

<ol class="breadcrumb">
    <li><a href="/"><?= __('Home') ?></a></li>
    <?php if ($model->period): ?>
        <li><a href="/period"><?= __('Periods') ?></a></li>

        <li>
            <a href="/task/period/<?= $model->period_id ?>"><?= __('Tasks on :period', array(':period' => $model->period->name)) ?></a>
        </li>
    <?php else: ?>
        <li><a href="/task"><?= __('Tasks') ?></a></li>
    <?php endif; ?>
    <li><?= $model->name ?></li>
    <?php if ($model->canUpdate($this->_user())): ?>
        <span class="pull-right actions">
            <a href="/task/update/<?= $model->id ?>"><i class="fa fa-edit"></i> <?= __('Update') ?></a>
            <?php if ($model->status == Task::STATUS_ENABLED): ?>
                <a href="/task/disable/<?= $model->id ?>"><i class="fa fa-power-off"></i> <?= __('Disable Task') ?></a>
            <?php else: ?>
                <a href="/task/enable/<?= $model->id ?>"><i class="fa fa-check-circle"></i> <?= __('Enable Task') ?></a>
            <?php endif; ?>
        </span>
    <?php endif ?>
</ol>

<?php $this->renderPartial('_view', array('model' => $model)); ?>

<?php $this->renderPartial('/task/view/jobs', array('model' => $model)) ?>


<script type="text/javascript">
    function showTaskJob(id) {
        $('#task-jobs-grid .defender').show();
        $('#modal_task_job_view').load('<?=Yii::app()->createUrl("task/ajaxJob")?>/' + id, function () {
            $('#modal_task_job_view').modal('show');
            $('#task-jobs-grid .defender').hide();
        })

        return false;
    }
    function approveTaskJob(id) {
        $('#task-jobs-grid .defender').show();
        $('#modal_task_job_view').load('<?=Yii::app()->createUrl("task/approve")?>/' + id, function () {

            $('#task-jobs-grid').yiiGridView('update', {});
        })
        return false;
    }
    function rejectTaskJob(id) {
        $('#task-jobs-grid .defender').show();
        $('#modal_task_job_view').load('<?=Yii::app()->createUrl("task/reject")?>/' + id, function () {
            $('#task-jobs-grid').yiiGridView('update', {});
        })
        return false;
    }

    function downloadTaskJobFiles(id, c) {
        if (parseInt(c) == 1) {
            $('#global_file_loader').attr('src', '<?=Yii::app()->createUrl("task/file")?>' + '/' + id);
        } else {
            showTaskJob(id)
        }
        return false;
    }
</script>

<div class="modal fade" id="modal_task_job_view" tabindex="-1" role="dialog" aria-hidden="true">
</div>
<iframe src="#" id="global_file_loader" style="display: none"></iframe>