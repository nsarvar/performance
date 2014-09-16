<?php
/* @var $this GroupController */
/* @var $model Group */
/* @var $form BSActiveForm */
?>

<?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
)); ?>

<?php echo $form->textFieldControlGroup($model, 'name', array('maxlength' => 64)); ?>

<div class="form-actions pull-right">
    <?php echo BsHtml::submitButton(__('Search'), array('color' => BsHtml::BUTTON_COLOR_PRIMARY,));?>
</div>
<div class="clearfix"></div>
<?php $this->endWidget(); ?>

