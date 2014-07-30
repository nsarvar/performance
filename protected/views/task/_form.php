<?php
/* @var $this TaskController */
/* @var $model Task */
/* @var $form BSActiveForm */

Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
?>

<?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id'                     => 'task-form',
    'enableAjaxValidation'   => true,
    'enableClientValidation' => true,
    'clientOptions'          => array('validateOnSubmit' => true)
)); ?>
<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col col-sm-6 ">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><?= __('app', 'Task Details') ?></h4>
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
                        <?php echo $form->textField($model, 'parent_name', array('maxlength' => 11, 'class' => 'disabled ', 'disabled' => 'disabled')); ?>
                        <span class="input-group-btn">
                            <button class="btn btn-primary" id="btn_task_parent"
                                    type="button"><?= __('app', 'Select Parent') ?></button>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-sm-6">
                        <?php echo $form->dropDownListControlGroup($model, 'type', Task::getTypeArray(false), array('class' => 'selectpicker show-tick', 'onchange' => 'generateTaskName()', 'title' => __('app', 'Choose Type'))); ?>
                    </div>
                    <div class="col col-sm-6">
                        <?php echo $form->dropDownListControlGroup($model, 'priority', Task::getPriorityArray(false), array('class' => 'selectpicker show-tick', 'title' => __('app', 'Choose Type'))); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col col-sm-6 ">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><?= __('app', 'Access Options') ?></h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col col-md-6">
                        <?php echo $form->dropDownListControlGroup($model, 'attachable', Task::getYesNoArray(false), array('class' => 'selectpicker show-tick', 'title' => __('app', 'Choose Type'))); ?>
                    </div>
                    <div class="col col-md-6">
                        <?php echo $form->dropDownListControlGroup($model, 'status', Task::getStatusArray(false), array('class' => 'selectpicker show-tick', 'title' => __('app', 'Choose Type'))); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-md-12">
                        <?php echo $form->textFieldControlGroup($model, 'start_date', array('maxlength' => 64)); ?>

                        <?php

                        $this->widget('CJuiDateTimePicker', array(
                            'hidden'    => true,
                            'model'     => $model, //Model object
                            'attribute' => 'start_date', //attribute name
                            'mode'      => 'date', //use "time","date" or "datetime" (default)
                            'options'   => array(
                                'dateFormat' => 'dd-mm-yy', // show format
                            ) // jquery plugin options
                        ));

                        ?>
                    </div>
                    <div class="col col-md-12">
                        <?php echo $form->textFieldControlGroup($model, 'end_date', array('maxlength' => 64)); ?>

                        <?php

                        $this->widget('CJuiDateTimePicker', array(
                            'hidden'    => true,
                            'model'     => $model, //Model object
                            'attribute' => 'end_date', //attribute name
                            'mode'      => 'date', //use "time","date" or "datetime" (default)
                            'options'   => array('dateFormat' => 'dd-mm-yy') // jquery plugin options
                        ));
                        ?>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <div class="col col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading visible-sm visible-xs">
                <h4><?= __('app', 'Full Information') ?></h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col col-md-8 col-lg-8">
                        <?php echo $form->textAreaControlGroup($model, 'description', array('rows' => 6)); ?>
                    </div>
                    <div class="col col-md-4 col-lg-4">
                        <div class="form-group">
                            <label class="control-label"><?= __('app', 'Files') ?></label>
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
                                        //'showMessage'      => "js:function(message){ alert(message); }"
                                    )
                                )); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col col-sm-12">
        <?php
        $dataTree = array(
            array(
                'text'     => '<input type="checkbox">Grampa', //must using 'text' key to show the text
                'expanded' => true,
                'children' => array( //using 'children' key to indicate there are children
                    array(
                        'text'     => 'Father',
                        'expanded' => true,
                        'children' => array(
                            array('text' => 'me'),
                            array('text' => 'big sis'),
                            array('text' => 'little brother'),
                        )
                    ),
                    array(
                        'text'     => 'Uncle',
                        'children' => array(
                            array('text' => 'Ben'),
                            array('text' => 'Sally'),
                        )
                    ),
                    array(
                        'text' => 'Aunt',
                    )
                )
            )
        );

        $this->widget('CTreeView', array(
            'data'        => $dataTree,
            'animated'    => 'fast', //quick animation
            'collapsed'   => 'false', //remember must giving quote for boolean value in here
            'htmlOptions' => array(
                'class' => 'treeview-red', //there are some classes that ready to use
            ),
        ));
        ?>
    </div>
</div>

<hr>
<p class="text-muted pull-left">Fields with <span class="required">*</span> are required.</p>
<p class="pull-right">
    <button type="button" name="yt10"
            class="btn btn-default btn-lg btn-delete <?= $model->scenario == 'update' ? '' : 'hidden' ?>"
            action="<?= Yii::app()->createUrl("user/delete", array("id" => $model->primaryKey)) ?>">Delete
    </button>
    <button type="submit" name="save"
            class="btn btn-success btn-lg"><?= $model->scenario == 'update' ? 'Update' : 'Save' ?></button>
</p>
<?php $this->endWidget(); ?>

<?php
Yii::app()->clientScript->registerScript('task_functions', "
$('#btn_task_parent').click(function(){
	$('#modal_task_parent').modal('show').on('hidden.bs.modal', function (e) {
        selectParent()
    })
	return false;
});

$('.form-task-parent-search form').submit(function(){
	$('#task-parent-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});


");
?>
<script type="text/javascript">
    function addFileToTask(id, fileName, r) {
        if (r.success) {
            $('#uploadFile').append("<input type='hidden' name='task_files[]' value='" + fileName + "'>");
        }
    }
    function generateTaskName() {
        var date = new Date();
        var number = $('input[name="Task[number]"]').val();
        var type = $('select[name="Task[type]"]').val().toUpperCase();
        var name = type + " #" + number + " - " + date.toLocaleDateString();
        $('input[name="Task[name]"]').val(name);
    }
</script>

<div class="modal fade" id="modal_task_parent" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only"><?= __('app', 'Close') ?></span></button>
                <h4 class="modal-title" id="myModalLabel"><?= __('app', 'Choose Task Parent') ?></h4>
            </div>

            <?php $this->renderPartial('/task/ajax', array('search' => $search)) ?>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= __('app', 'Close') ?></button>
                <button type="button" class="btn btn-primary"
                        onclick="selectParent()"><?= __('app', 'Select') ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function selectParent() {
        var s = $('.task_parent_selector:checked');
        if (s.length > 0) {
            $('input[name="Task[parent_name]"]').val(s.attr('data-number') ? s.attr('data-number') : s.attr('data-name'))
            $('input[name="Task[parent_id]"]').val(s.val())
            $('#modal_task_parent').modal('hide');
        }
    }
</script>