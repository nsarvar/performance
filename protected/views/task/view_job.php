<?php
/* @var $this TaskController */
/* @var $model Task */
?>

<ol class="breadcrumb">
    <li><a href="/"><?= __('Home') ?></a></li>
    <li><a href="/period"><?= __('Periods') ?></a></li>
    <li>
        <a href="/task/period/<?= $model->period_id ?>"><?= __('Tasks on :period', array(':period' => $model->period->name)) ?></a>
    </li>
    <li><a href="/task/view/<?= $model->id ?>"><?= $model->name ?></a></li>
    <li><?= __('Answer') ?></li>
    <span class="pull-right action_admin actions">
        <a href="/task/update/<?= $model->id ?>"><i class="fa fa-edit"></i> <?= __('Update') ?></a>
        <?php if ($model->status == Task::STATUS_ENABLED): ?>
            <a href="/task/disable/<?= $model->id ?>"><i class="fa fa-power-off"></i> <?= __('Disable Task') ?></a>
        <?php else: ?>
            <a href="/task/enable/<?= $model->id ?>"><i class="fa fa-check-circle"></i> <?= __('Enable Task') ?></a>
        <?php endif; ?>
    </span>
</ol>

<?php $this->renderPartial('_view', array('model' => $model)); ?>
<?php if ($model->status == Task::STATUS_ENABLED): ?>
    <?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'method'        => 'post',
        'id'            => 'task-job-form',
        'clientOptions' => array('validateOnSubmit' => true)
    )); ?>
    <div class="panel panel-default ">
        <div class="panel-heading">
            <h5><?= $job->organization->name ?></h5>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col col-md-7">
                    <?php echo $form->textAreaControlGroup($job, 'content', array('rows' => 6)); ?>
                </div>
                <div class="col col-md-5">
                    <div class="form-group" id="jobs_file_upload">
                        <label class="control-label"><?= __('Files') ?></label>
                        <a href="#fileUpload" class="pull-right" onclick="addFile()"><i
                                class="fa fa-plus"></i> <?= __('Add File') ?> </a>
                        <?php $this->widget('ext.EAjaxUpload.EAjaxUpload',
                            array(
                                'id'     => 'uploadFile',
                                'config' => array(
                                    'action'            => Yii::app()->createUrl('task/upload'),
                                    'allowedExtensions' => File::$allowedExt,
                                    'sizeLimit'         => 10 * 1024 * 1024,
                                    'minSizeLimit'      => 10,
                                    'onComplete'        => "js:function(id, fileName, responseJSON){ addFileToTask(id,fileName,responseJSON) }",
                                    'messages'          => array(
                                        'typeError'    => "{file} has invalid extension. Only {extensions} are allowed.",
                                        'sizeError'    => "{file} is too large, maximum file size is {sizeLimit}.",
                                        'minSizeError' => "{file} is too small, minimum file size is {minSizeLimit}.",
                                        'emptyError'   => "{file} is empty, please select files again without it.",
                                        'onLeave'      => "The files are being uploaded, if you leave now the upload will be cancelled."
                                    ),
                                )
                            )); ?>

                    </div>
                    <div id="job_files_area">
                        <?php if ($files = $job->files)
                            foreach ($files as $file): ?>
                                <input type='hidden'
                                       name='Job[job_files][<?= $file->realname ?>]'
                                       value='<?= $file->file_name ?>'
                                       data-id="<?= $file->realname ?>"
                                       data-size="<?= $file->getFileSize() ?>"
                                       data-content="<?= $file->getClass() ?>">
                            <?php endforeach; ?>
                    </div>
                </div>
                <div class="col col-sm-12">
                    <hr>
                    <div class="row">
                        <div class="col col-md-8">
                            <p>
                        <span class="formatted">
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
                        <div class="col col-md-4 text-right">
                            <button type="submit" name="save"
                                    class="btn btn-success btn-lg"><?= __('Submit') ?></button>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <?php $this->endWidget(); ?>

    <?php
    Yii::app()->clientScript->registerScript('task_functions', "
        $(document).ready(function(){
            $('#form_selected_org').submit();
            showFiles();
        })

        ", CClientScript::POS_LOAD);
    ?>
    <script type="text/javascript">
        function addFile() {
            $('#uploadFile input[name="file"]').click();
            return false;
        }
        function addFileToTask(id, fileName, r) {
            if (r.success) {
                $('#job_files_area').append("<input type='hidden' name='Job[job_files][" + r.realname + "]' value='" + r.orgname + "'>");
                $('#' + r.realname + ' .qq-upload-file').html(r.filename);
            }
        }
        function deleteFile(el) {
            if (confirm('<?=__('Are you sure to delete the file?')?>')) {
                var id = 'input[name="Job[job_files][' + $(el).parent().attr('id') + ']"]';
                $(id).remove();
                $(el).parent().remove();
            }
            return false;
        }
        function showFiles() {
            $('#job_files_area input').each(function () {
                var el = $(this);
                var t = '<li class="qq-upload-success" id="' + el.attr('data-id') + '">' +
                    '<span class="qq-upload-file"><i class="fa ' + el.attr('data-content') + '">' +
                    '</i> ' + el.val() + '</span>' +
                    '<span class="qq-upload-size">' + el.attr('data-size') + '</span>' +
                    '<a onclick="return deleteFile(this)" href="#" class="qq-upload-delete">Delete</a></li>'
                $('#jobs_file_upload .qq-upload-list').append(t);
            })
        }
    </script>
<?php else: ?>
    <?php $this->renderPartial('view/_job', array('data' => $job)); ?>
<?php endif; ?>
