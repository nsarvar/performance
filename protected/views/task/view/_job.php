<?php
/**
 * @var $job  Job
 * @var $this TaskController
 */
$job = $data;
$canAction = $this->_user()->role == User::ROLE_SUPER_ADMIN || $job->task->group_id == $this->_user()->group_id;
?>
<div class="panel panel-default ">
    <div class="panel-heading">
        <h5>
            <a href="<?= Yii::app()->createUrl('task/job', array('id' => $job->id)) ?>"><?= $job->organization->name ?></a>
        </h5>

    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col col-sm-6">
                <div
                    class="text-info formatted"><?= ($job->content) ? $job->content : "<p class='text-muted'>" . __('No Comments') . "</p>" ?></div>
            </div>
            <div class="col col-sm-6">
                <div class="text-info">
                    <div class="form-group">
                        <label><?= __('Files') ?></label>

                        <div class="qq-uploader">
                            <ul class="qq-upload-list">
                                <?php $files = $job->files; ?>
                                <?php if (count($files) == 0): ?>
                                    <li class="text-muted"><?= __('No Files Attached') ?></li>
                                <?php endif; ?>
                                <?php foreach ($files as $file): ?>
                                    <li class="qq-upload-success">
                                    <span class="qq-upload-file">
                                        <i class="fa <?= $file->getClass() ?>"></i>
                                        <?= $file->file_name ?>
                                    </span>
                                        <span class="qq-upload-size hidden-xs"><?= $file->getFileSize() ?></span>
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

            <div class="col col-sm-12">
                <hr>
                <div class="row">
                    <div class="col col-sm-8 hidden-xs">
                        <p>
                        <span class="formatted ">
                            <?php if ($job->user): ?>
                                <?= __('Updated by <b>:user</b> on <b>:date</b>', array(':user' => $job->user->name, ':date' => Task::getFormattedDate($job->updated_at, 'd-F, Y H:i:s'))) ?>
                            <?php else: ?>
                                <?= __('Assigned by <b>:user</b> on <b>:date</b>', array(':user' => $job->task->user->name, ':date' => Task::getFormattedDate($job->updated_at, 'd-F, Y H:i:s'))) ?>
                            <?php endif ?>
                        </span> &nbsp;&nbsp;
                        <span class="prt status-<?= $job->status ?>">
                            <?= $job->getStatusLabel() ?>
                        </span>
                        </p>
                    </div>
                    <div class="col col-xs-12 col-sm-4 text-right">
                        <?php if ($job->status != Job::STATUS_APPROVED && $canAction): ?>
                            <a class="btn btn-success"
                               onclick="return approveTaskJob(<?= $job->id ?>)"
                               href='<?= Yii::app()->createUrl("task/approve", array("id" => $job->id)) ?>'>
                                <i class="fa fa-check"></i> <?= __('Approve') ?>
                            </a>
                        <?php endif; ?>
                        <?php if ($job->status != Job::STATUS_REJECTED && $canAction): ?>
                            <a class="btn btn-danger"
                               onclick="return rejectTaskJob(<?= $job->id ?>)"
                               href='<?= Yii::app()->createUrl("task/reject", array("id" => $job->id)) ?>'>
                                <i class="fa fa-ban"></i> <?= __('Reject') ?></a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>