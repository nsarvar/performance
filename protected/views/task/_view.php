<?php
/* @var $this TaskController */
/* @var $$model Task */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4><?= __('Task Details') ?></h4>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col col-md-7">
                <div class="form-group">
                    <label><?= __('Description') ?></label>
                    <textarea class="form-control" onkeypress="return false"
                              rows="5"><?= $model->description ?></textarea>
                </div>
                <div class="form-group">
                    <label><?= __('Files') ?></label>

                    <div class="qq-uploader">
                        <ul class="qq-upload-list">
                            <?php $files = $model->getTaskFiles(); ?>
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

            <div class="col col-md-5">
                <div class="form-group">
                    <label><?= __('Details') ?></label>
                    <table class="table  table-condensed table-hover tbl-details">
                        <tbody>
                        <tr>
                            <th><?= __('Name') ?></th>
                            <td><strong><?= $model->name ?></strong></td>
                        </tr>
                        <tr>
                            <th><?= __('Number') ?></th>
                            <td class="number"><?= $model->number ?></td>
                        </tr>

                        <tr>
                            <th><?= __('Priority') ?></th>
                            <td><span
                                    class="prt priority-<?= $model->priority ?>"><?= $model->getPriorityLabel() ?></span>
                            </td>
                        </tr>


                        <tr class="border">
                            <th><?= __('Status') ?></th>
                            <td><?= $model->getStatusLabel() ?></td>
                        </tr>
                        <?php if ($model->period): ?>
                            <tr>
                                <th><?= __('Period') ?></th>
                                <td><a href="/task/period/<?= $model->period_id ?>"><?= $model->period->name ?></a></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <th><?= __('Curator') ?></th>
                            <td><a href="/user/<?= $model->user_id ?>"><?= $model->user->name ?></a></td>
                        </tr>

                        <?php if ($model->parent): ?>
                            <tr>
                                <th><?= __('Parent') ?></th>
                                <td><a href="/task/view/<?= $model->parent_id ?>"><?= $model->parent->name ?></a></td>
                            </tr>
                        <?php endif; ?>

                        <tr class="border">
                            <th><?= __('Start Date') ?></th>
                            <td><?= Yii::app()->dateFormatter->format("d-MMMM, y", strtotime($model->start_date)) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('End Date') ?></th>
                            <td><?= Yii::app()->dateFormatter->format("d-MMMM, y", strtotime($model->end_date)) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Created') ?></th>
                            <td><?= Yii::app()->dateFormatter->format("d-MMMM, y HH:mm:ss", strtotime($model->created_at)) ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
