<?php
/* @var $this TaskController */
/* @var $model Task */
/* @var $form BSActiveForm */

Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
?>


<div class="row">

    <?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'method'                 => 'post',
        'id'                     => 'task-form',
        'enableAjaxValidation'   => true,
        'enableClientValidation' => true,
        'clientOptions'          => array('validateOnSubmit' => true)
    )); ?>
    <div class="col col-lg-12">
        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="col col-sm-6 ">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><?= __('Task Details') ?></h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col col-md-5">
                        <?php echo $form->textFieldControlGroup($model, 'number', array('maxlength' => 64, 'onchange' => 'generateTaskName()')); ?>
                    </div>
                    <div class="col col-md-7">
                        <?php echo $form->textFieldControlGroup($model, 'name', array('maxlength' => 64)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Parent</label>

                    <?php echo $form->hiddenField($model, 'parent_id', array('maxlength' => 11, 'class' => 'disabled ',)); ?>
                    <div class="input-group" style="width: 100%;">
                        <?php echo $form->textField($model, 'parent_name', array('value' => $model->parent ? $model->parent->name : '', 'maxlength' => 11, 'class' => 'disabled ', 'disabled' => 'disabled')); ?>
                        <span class="input-group-btn">
                            <button class="btn btn-primary" id="btn_task_parent"
                                    type="button"><?= __('Select Parent') ?></button>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-sm-6">
                        <?php echo $form->dropDownListControlGroup($model, 'type', Task::getTypeArray(false), array('class' => 'selectpicker show-tick', 'onchange' => 'generateTaskName()', 'title' => __('Choose Type'))); ?>
                    </div>
                    <div class="col col-sm-6">
                        <?php echo $form->dropDownListControlGroup($model, 'priority', Task::getPriorityArray(false), array('class' => 'selectpicker show-tick', 'title' => __('Choose Type'))); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col col-sm-6 ">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><?= __('Access Options') ?></h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col col-md-6">
                        <?php echo $form->dropDownListControlGroup($model, 'attachable', Task::getYesNoArray(false), array('class' => 'selectpicker show-tick', 'title' => __('Choose Type'))); ?>
                    </div>
                    <div class="col col-md-6">
                        <?php echo $form->dropDownListControlGroup($model, 'status', Task::getStatusArray(false), array('class' => 'selectpicker show-tick', 'title' => __('Choose Type'))); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-md-12">

                        <?php

                        $this->widget('CJuiDateTimePicker', array(
                            'hidden'    => true,
                            'value'     => $model->getFormattedDate($model->start_date),
                            'model'     => $model, //Model object
                            'attribute' => 'start_date', //attribute name
                            'mode'      => 'date', //use "time","date" or "datetime" (default)
                            'options'   => array(
                                'dateFormat' => Task::DF_JS, // show format
                            ) // jquery plugin options
                        ));

                        ?>
                        <?php echo $form->textFieldControlGroup($model, 'start_date', array('maxlength' => 64, 'value' => $model->getFormattedDate($model->start_date),)); ?>

                    </div>
                    <div class="col col-md-12">

                        <?php

                        $this->widget('CJuiDateTimePicker', array(
                            'hidden'    => true,
                            'value'     => $model->getFormattedDate($model->end_date),
                            'model'     => $model, //Model object
                            'attribute' => 'end_date', //attribute name
                            'mode'      => 'date', //use "time","date" or "datetime" (default)
                            'options'   => array('dateFormat' => Task::DF_JS) // jquery plugin options
                        ));
                        ?>
                        <?php echo $form->textFieldControlGroup($model, 'end_date', array('maxlength' => 64, 'value' => $model->getFormattedDate($model->end_date),)); ?>

                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="col col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading visible-sm visible-xs">
                <h4><?= __('Full Information') ?></h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col col-md-8 col-lg-8">
                        <?php echo $form->textAreaControlGroup($model, 'description', array('rows' => 6)); ?>
                    </div>
                    <div class="col col-md-4 col-lg-4">
                        <div class="form-group">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="files_area">
        <?php if ($files = $model->getTaskFiles())
            foreach ($files as $file): ?>
                <input type='hidden'
                       name='Task[task_files][<?= $file->realname ?>]'
                       value='<?= $file->file_name ?>'
                       data-id="<?= $file->realname ?>"
                       data-size="<?= $file->getFileSize() ?>"
                       data-content="<?= $file->getClass() ?>">
            <?php endforeach; ?>
    </div>
    <?php echo $form->hiddenField($model, 'organization_ids', array('value' => $model->getOrganizationIds())); ?>
    <?php $this->endWidget(); ?>
    <div class="col col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>
                    <?= __('Organizations') ?>
                    <button style="margin-left: 20px" class="btn btn-sm btn-primary" id="btn_task_organizations"><i
                            class="fa fa-plus"></i> <?= __('Add') ?></button>
                </h4>
            </div>
            <div style="max-height: 420px;overflow-y: scroll">
                <?php $this->renderPartial('/task/ajax/selectedOrg', array('search' => $searchSelectedOrg)) ?>
            </div>
        </div>
    </div>
</div>

<hr>
<p class="text-muted pull-left">Fields with <span class="required">*</span> are required.</p>
<p class="pull-right">
    <button type="button" name="yt10"
            class="btn btn-default btn-lg btn-delete <?= $model->scenario == 'update' ? '' : 'hidden' ?>"
            action="<?= Yii::app()->createUrl("user/delete", array("id" => $model->primaryKey)) ?>">Delete
    </button>
    <button type="submit" onclick="$('#task-form').submit()" name="save"
            class="btn btn-success btn-lg"><?= $model->scenario == 'update' ? 'Update' : 'Save' ?></button>
</p>


<div class="modal fade" id="modal_task_organizations" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only"><?= __('Close') ?></span></button>
                <h4 class="modal-title" id="myModalLabel"><?= __('Choose Executors') ?></h4>
            </div>
            <?php $this->renderPartial('/task/ajax/organizations', array('search' => $searchOrganizations)) ?>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= __('Close') ?></button>
                <button type="button" class="btn btn-primary"
                        onclick="selectOrganizations()"><?= __('Add Selected') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_task_parent" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only"><?= __('Close') ?></span></button>
                <h4 class="modal-title" id="myModalLabel"><?= __('Choose Task Parent') ?></h4>
            </div>

            <?php $this->renderPartial('/task/ajax/tasks', array('search' => $searchTasks)) ?>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= __('Close') ?></button>
                <button type="button" class="btn btn-primary"
                        onclick="selectParent()"><?= __('Select') ?></button>
            </div>
        </div>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScript('task_functions', "
$('#btn_task_parent').click(function(){
	$('#modal_task_parent').modal('show').on('hidden.bs.modal', function (e) {
        selectParent()
    })
	return false;
});
$('#btn_task_organizations').click(function(){
    $('.form-task-organizations-search form').submit();
	$('#modal_task_organizations').modal('show').on('hidden.bs.modal', function (e) {
        selectOrganizations()
    })
	return false;
});

$('.form-task-parent-search form').submit(function(){
	$('#task-parent-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});

$('.form-task-organizations-search form').submit(function(){
	$('#task-organizations-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});

$('#form_selected_org').submit(function(){
	$('#task-organizations-selected-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
$(document).ready(function(){
    $('#form_selected_org').submit();
    showFiles();
})

",CClientScript::POS_LOAD);
?>

<script type="text/javascript">
    function addFile() {
        $('#uploadFile input[name="file"]').click();
        return false;
    }
    function addFileToTask(id, fileName, r) {
        if (r.success) {
            $('#files_area').append("<input type='hidden' name='Task[task_files][" + r.realname + "]' value='" + r.orgname + "'>");
            $('#' + r.realname + ' .qq-upload-file').html(r.filename);
        }
    }
    function deleteFile(el) {
        if (confirm('<?=__('Are you sure to delete the file?')?>')) {
            var id = 'input[name="Task[task_files][' + $(el).parent().attr('id') + ']"]';
            console.log(id);
            $(id).remove();
            $(el).parent().remove();
        }
        return false;
    }
    function generateTaskName() {
        var date = new Date();
        var number = $('input[name="Task[number]"]').val();
        var type = $('select[name="Task[type]"]').val().toUpperCase();
        var name = type + " #" + number + " " + date.toLocaleDateString();
        $('input[name="Task[name]"]').val(name);
    }

    function removeOrganization(id) {
        var o = $('#so_ids').val().split(',');
        var index = o.indexOf(id + "");
        if (index > -1) {
            o.splice(index, 1);
            $('#so_ids').val(o);
            $('input[name="Task[organization_ids]"]').val(o);
            $('input[name="Organization[so_ids]"]').val(o);
            $('#form_selected_org').submit();
        }
    }

    function selectOrganizations() {
        var s = $('#task-organizations-grid').yiiGridView('getSelection', 'selectedOrganizationIds');
        var o = $('#so_ids').val().split(',');

        if (!$('#so_ids').val()) {
            o.length = 0;
        }
        var i = o.length, a = i;
        for (var k in s) {
            if (o.indexOf(s[k]) == -1) {
                o[i++] = s[k];
            }
        }
        if (a != i) {
            $('#so_ids').val(o);
            $('input[name="Organization[so_ids]"]').val(o);
            $('input[name="Task[organization_ids]"]').val(o);
            $('#form_selected_org').submit();
            $('.form-task-organizations-search form').submit();
        }
        //$('#modal_task_organizations').modal('hide');
    }
    function selectParent() {
        var s = $('.t_p_s:checked');
        if (s != undefined && s.length > 0) {
            var val = s.val().split('|');
            if (val[0] != undefined) {
                if (val[1] != undefined)$('input[name="Task[parent_name]"]').val(val[1])
                $('input[name="Task[parent_id]"]').val(val[0])
                $('#modal_task_parent').modal('hide');
            }
        }
    }

    function showFiles() {
        $('#files_area input').each(function () {
            var el = $(this);
            var t = '<li class="qq-upload-success" id="' + el.attr('data-id') + '">' +
                '<span class="qq-upload-file"><i class="fa ' + el.attr('data-content') + '">' +
                '</i> ' + el.val() + '</span>' +
                '<span class="qq-upload-size">'+el.attr('data-size')+'</span>'+
                '<a onclick="return deleteFile(this)" href="#" class="qq-upload-delete">Delete</a></li>'
            $('.qq-upload-list').append(t);
        })
    }
</script>