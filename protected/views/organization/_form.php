<?php
/* @var $this OrganizationController */
/* @var $model Organization */
/* @var $form BSActiveForm */
?>

<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id'=>'organization-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldControlGroup($model,'parent_id',array('maxlength'=>11)); ?>
    <?php echo $form->textFieldControlGroup($model,'name',array('maxlength'=>255)); ?>
    <?php echo $form->textFieldControlGroup($model,'short_name',array('maxlength'=>30)); ?>
    <?php echo $form->textFieldControlGroup($model,'description',array('maxlength'=>255)); ?>
    <?php echo $form->textFieldControlGroup($model,'address',array('maxlength'=>255)); ?>
    <?php echo $form->textFieldControlGroup($model,'phone',array('maxlength'=>255)); ?>
    <?php echo $form->textFieldControlGroup($model,'email',array('maxlength'=>64)); ?>
    <?php echo $form->textFieldControlGroup($model,'web_site',array('maxlength'=>255)); ?>
    <?php echo $form->textFieldControlGroup($model,'type',array('maxlength'=>10)); ?>
    <?php echo $form->textFieldControlGroup($model,'region_id',array('maxlength'=>11)); ?>
    <?php echo $form->textFieldControlGroup($model,'created_at'); ?>

    <?php echo BsHtml::submitButton('Submit', array('color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>

<?php $this->endWidget(); ?>
