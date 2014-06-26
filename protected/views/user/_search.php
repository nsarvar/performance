<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form BSActiveForm */
?>

<?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'action'=> Yii::app()->createUrl($this->route),
    'method'=> 'get',
)); ?>

<?php echo $form->textFieldControlGroup($model, 'login', array('maxlength'=> 30)); ?>
<?php echo $form->dropDownListControlGroup($model, 'organization_id', Organization::getOptionLabelsForUsers(), array('class'=> 'selectpicker show-tick', 'title'=> 'Any Organization')); ?>
<?php echo $form->dropDownListControlGroup($model, 'role', User::getRolesArray(), array('class'=> 'selectpicker show-tick', 'title'=> 'Any Role')); ?>

<div class="form-actions">
    <?php echo BsHtml::submitButton('Search', array('color' => BsHtml::BUTTON_COLOR_PRIMARY,));?>
</div>

<?php $this->endWidget(); ?>
