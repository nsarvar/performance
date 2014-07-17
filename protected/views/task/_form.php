<?php
/* @var $this TaskController */
/* @var $model Task */
/* @var $form BSActiveForm */

Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
?>

<?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id'                    => 'user-form',
    'enableAjaxValidation'  => true,
    'enableClientValidation'=> true,
    'clientOptions'         => array('validateOnSubmit'=> true)
)); ?>
<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col col-sm-6 ">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><?=__('app', 'Task Details')?></h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col col-md-5">
                        <?php echo $form->textFieldControlGroup($model, 'number', array('maxlength'=> 64)); ?>
                    </div>
                    <div class="col col-md-7">
                        <?php echo $form->textFieldControlGroup($model, 'name', array('maxlength'=> 64)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Parent</label>

                    <div class="input-group" style="width: 100%;">
                        <?php echo $form->textField($model, 'parent_id', array('maxlength'=> 11, 'class'=> 'disabled ', 'disabled'=> 'disabled')); ?>
                        <span class="input-group-btn">
                            <button class="btn btn-primary" id="btn_task_parent" type="button"><?=__('app', 'Select Parent')?></button>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-sm-6">
                        <?php echo $form->dropDownListControlGroup($model, 'type', Task::getTypeArray(false), array('class'=> 'selectpicker show-tick', 'title'=> __('app', 'Choose Type'))); ?>
                    </div>
                    <div class="col col-sm-6">
                        <?php echo $form->dropDownListControlGroup($model, 'priority', Task::getPriorityArray(false), array('class'=> 'selectpicker show-tick', 'title'=> __('app', 'Choose Type'))); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col col-sm-6 ">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><?=__('app', 'Access Options')?></h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col col-md-6">
                        <?php echo $form->dropDownListControlGroup($model, 'attachable', Task::getYesNoArray(false), array('class'=> 'selectpicker show-tick', 'title'=> __('app', 'Choose Type'))); ?>
                    </div>
                    <div class="col col-md-6">
                        <?php echo $form->dropDownListControlGroup($model, 'status', Task::getStatusArray(false), array('class'=> 'selectpicker show-tick', 'title'=> __('app', 'Choose Type'))); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-md-12">
                        <?php

                        $this->widget('CJuiDateTimePicker', array(
                            'model'    => $model, //Model object
                            'attribute'=> 'start_date', //attribute name
                            'mode'     => 'date', //use "time","date" or "datetime" (default)
                            'options'  => array('dateFormat'=> 'dd M, yy') // jquery plugin options
                        ));

                        ?>
                    </div>
                    <div class="col col-md-12">
                        <?php

                        $this->widget('CJuiDateTimePicker', array(
                            'model'    => $model, //Model object
                            'attribute'=> 'end_date', //attribute name
                            'mode'     => 'date', //use "time","date" or "datetime" (default)
                            'options'  => array('dateFormat'=> 'dd M, yy') // jquery plugin options
                        ));
                        ?>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="col col-sm-12">
        <div class="row">
            <div class="col col-md-6 col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading visible-sm visible-xs">
                        <h4><?=__('app', 'Full Information')?></h4>
                    </div>
                    <div class="panel-body">
                        <?php echo $form->textAreaControlGroup($model, 'description', array('rows'=> 6)); ?>
                    </div>
                </div>
            </div>
            <div class="col col-md-6 col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading visible-sm visible-xs">
                        <h4><?=__('app', 'Executors')?></h4>
                    </div>
                    <div class="panel-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>
<p class="text-muted pull-left">Fields with <span class="required">*</span> are required.</p>
<p class="pull-right">
    <button type="button" name="yt10"
            class="btn btn-default btn-lg btn-delete <?=$model->scenario == 'update' ? '' : 'hidden'?>"
            action="<?=Yii::app()->createUrl("user/delete", array("id"=> $model->primaryKey))?>">Delete
    </button>
    <button type="submit" name="save"
            class="btn btn-success btn-lg"><?=$model->scenario == 'update' ? 'Update' : 'Save'?></button>
</p>
<?php $this->endWidget(); ?>

<?php
Yii::app()->clientScript->registerScript('task_functions', "
$('#btn_task_parent').click(function(){
	$('#modal_task_parent').modal('show');
	return false;
});

");
?>

<div class="modal fade" id="modal_task_parent" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?=__('app','Close')?></span></button>
                <h4 class="modal-title" id="myModalLabel"><?=__('app','Choose Task Parent')?></h4>
            </div>
            <div class="modal-body_">
                <?php $this->renderPartial('/task/ajax',array('model'=>$model))?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=__('app','Close')?></button>
                <button type="button" class="btn btn-primary"><?=__('app','Select')?></button>
            </div>
        </div>
    </div>
</div>