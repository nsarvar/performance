<?php
/* @var $this PeriodController */
/* @var $model Period */
/* @var $form BSActiveForm */
?>

<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id'=>'period-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldControlGroup($model,'name',array('maxlength'=>32)); ?>
    <?php echo $form->textFieldControlGroup($model,'status',array('maxlength'=>8)); ?>
    <?php echo $form->textFieldControlGroup($model,'task_count'); ?>
    <?php echo $form->textFieldControlGroup($model,'period_from'); ?>
    <?php echo $form->textFieldControlGroup($model,'period_to'); ?>

    <?php echo BsHtml::submitButton('Submit', array('color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>

<?php $this->endWidget(); ?>
