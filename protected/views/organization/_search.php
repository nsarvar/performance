<?php
/* @var $this OrganizationController */
/* @var $model Organization */
/* @var $form BSActiveForm */
?>

<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <?php echo $form->textFieldControlGroup($model,'id',array('maxlength'=>11)); ?>
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

    <div class="form-actions">
        <?php echo BsHtml::submitButton('Search',  array('color' => BsHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

<?php $this->endWidget(); ?>
