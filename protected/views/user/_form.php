<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form BSActiveForm */
?>

<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id'=>'user-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldControlGroup($model,'login',array('maxlength'=>30)); ?>
    <?php echo $form->passwordFieldControlGroup($model,'password',array('maxlength'=>128)); ?>
    <?php echo $form->textFieldControlGroup($model,'name',array('maxlength'=>128)); ?>
    <?php echo $form->textFieldControlGroup($model,'organization_id',array('maxlength'=>11)); ?>
    <?php echo $form->textFieldControlGroup($model,'group_id',array('maxlength'=>11)); ?>
    <?php echo $form->textFieldControlGroup($model,'email',array('maxlength'=>64)); ?>
    <?php echo $form->textFieldControlGroup($model,'telephone',array('maxlength'=>14)); ?>
    <?php echo $form->textFieldControlGroup($model,'mobile',array('maxlength'=>14)); ?>
    <?php echo $form->textFieldControlGroup($model,'picture',array('maxlength'=>255)); ?>
    <?php echo $form->textFieldControlGroup($model,'status'); ?>
    <?php echo $form->textFieldControlGroup($model,'created_at'); ?>
    <?php echo $form->textFieldControlGroup($model,'role',array('maxlength'=>10)); ?>

    <?php echo BsHtml::submitButton('Submit', array('color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>

<?php $this->endWidget(); ?>
