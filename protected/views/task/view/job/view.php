<?php
/**
 * @var $model Job
 */
?>
<div class="modal-dialog">
    <div class="modal-content">
        <?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
            'method'        => 'post',
            'id'            => 'task-job-form',
            'clientOptions' => array('validateOnSubmit' => true)
        )); ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                    class="sr-only"><?= __('Close') ?></span></button>
            <h4 class="modal-title" id="myModalLabel"><?= __('Task View') ?></h4>
        </div>
        <div class="modal-body">
            <div class="row">

                <div class="col col-lg-12">
                    <div class="form-group row">
                        <label class="control-label col-sm-2"><?= __('Organization') ?></label>

                        <div class="col-sm-10">
                            <a href="<?= Yii::app()->createUrl("organization/view", array("id" => $model->organization_id)) ?>"><i
                                    class="fa fa-university"></i> <?= $model->organization->name ?></a>
                        </div>
                    </div>
                    <?php if ($model->user): ?>
                        <div class="form-group row">
                            <label class="control-label col-sm-2"><?= __('User') ?></label>

                            <div class="col-sm-10">
                                <a href="<?= Yii::app()->createUrl("user/view", array("id" => $model->user_id)) ?>"><i
                                        class="fa fa-user"></i> <?= $model->user->name ?></a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="form-group row">
                        <label class="control-label col-sm-2"><?= __('Updated') ?></label>

                        <div class="col-sm-10">
                            <span class=""><?= Task::getFormattedDate($model->updated_at, 'd-F, Y H:i:s') ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2"><?= __('Status') ?></label>

                        <div class="col-sm-10">
                            <span class="prt status-<?= $model->status ?>"><?= $model->getStatusLabel() ?></span>
                        </div>
                    </div>
                    <?php echo $form->textAreaControlGroup($model, 'content', array('onkeypress' => 'return false')); ?>

                    <div class="form-group">
                        <label><?= __('Files') ?></label>

                        <div class="qq-uploader">
                            <ul class="qq-upload-list">
                                <?php $files = $model->files; ?>
                                <?php if (count($files) == 0): ?>
                                    <li class="text-muted"><?= __('No Files Attached') ?></li>
                                <?php endif; ?>
                                <?php foreach ($files as $file): ?>
                                    <li class="qq-upload-success">
                                    <span class="qq-upload-file">
                                        <i class="fa <?= $file->getClass() ?>"></i>
                                        <?= $file->file_name ?>
                                    </span>
                                        <span class="qq-upload-size"><?= $file->getFileSize() ?></span>
                                        <a class="qq-upload-delete" href="/task/file/<?= $file->realname ?>">
                                            <i class="fa fa-download"></i> <span
                                                class="hidden-xs"><?= __('Download') ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?= __('Close') ?></button>
            <?php if ($model->status != Job::STATUS_APPROVED): ?>
                <button type="button" class="btn btn-success"
                        onclick="approveTaskJob(<?= $model->id ?>)"><i class="fa fa-check"></i> <?= __('Approve') ?></button>
            <?php endif; ?>
            <?php if ($model->status != Job::STATUS_REJECTED): ?>
                <button type="button" class="btn btn-danger"
                        onclick="rejectTaskJob(<?= $model->id ?>)"><i class="fa fa-ban"></i> <?= __('Reject') ?></button>
            <?php endif; ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.selectpicker').selectpicker();
    })
</script>
