<?php
$job = $data;
?>
<div class="panel panel-default ">
    <div class="panel-heading">
        <h5>
                <span class="prt status-<?= $job->status ?>">
                    <?= Task::getFormattedDate($job->updated_at, 'd-F, Y H:i:s') ?>
                </span> &nbsp;&nbsp;
                <span class="prt status-<?= $job->status ?>">
                    <?= $job->getStatusLabel() ?>
                </span>
            &nbsp;&nbsp;
            <?= $job->organization->name ?>
        </h5>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col col-sm-6">
                <div
                    class="text-info"><?= ($job->content) ? $job->content : "<p class='text-muted'>" . __('No Comments') . "</p>" ?></div>
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
            <div class="col col-sm-12">
                <hr>
                <div class="pull-right">
                    <?php if ($job->status != Job::STATUS_APPROVED): ?>
                        <button type="button" class="btn btn-success"
                                onclick="approveTaskJob(<?= $job->id ?>)"><i
                                class="fa fa-check"></i> <?= __('Approve') ?></button>
                    <?php endif; ?>
                    <?php if ($job->status != Job::STATUS_REJECTED): ?>
                        <button type="button" class="btn btn-danger"
                                onclick="rejectTaskJob(<?= $job->id ?>)"><i
                                class="fa fa-ban"></i> <?= __('Reject') ?></button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>