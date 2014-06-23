<?php
/* @var $this OrganizationController */
/* @var $model Organization */
/* @var $form BSActiveForm */
?>

<?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'action'=> Yii::app()->createUrl($this->route),
    'method'=> 'get',
)); ?>

<?php echo $form->dropDownListControlGroup($model, 'parent_id', Organization::getParents()); ?>
<?php echo $form->dropDownListControlGroup($model, 'type', Organization::getTypesArray()); ?>
<?php echo $form->dropDownListControlGroup($model, 'region_id', Region::getOptionLabels()); ?>

<div class="form-actions">
    <?php echo BsHtml::submitButton('Search', array('color' => BsHtml::BUTTON_COLOR_PRIMARY,));?>
</div>

<?php $this->endWidget(); ?>
