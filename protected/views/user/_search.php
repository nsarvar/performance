<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form BSActiveForm */
?>

<?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'action'=> Yii::app()->createUrl($this->route),
    'method'=> 'get',
)); ?>

<div class="row">
    <div class="col col-md-3 col-lg-12">
        <?php echo $form->textFieldControlGroup($model, 'login', array('maxlength'=> 30)); ?>
    </div>
    <div class="col col-md-3 col-lg-12">
        <?php echo $form->textFieldControlGroup($model, 'email', array('maxlength'=> 30)); ?>
    </div>
    <div class="col col-md-3 col-lg-12">
        <?php echo $form->dropDownListControlGroup($model, 'organization_id', Organization::getOptionLabelsForUsers(), array('class'=> 'selectpicker show-tick', 'title'=> 'Any Organization')); ?>
    </div>
    <div class="col col-md-3 col-lg-12">
        <?php echo $form->dropDownListControlGroup($model, 'role', User::getRolesArray(), array('class'=> 'selectpicker show-tick', 'title'=> 'Any Role')); ?>
    </div>
</div>

<div class="form-actions pull-right">
    <?php echo BsHtml::submitButton('Search', array('color' => BsHtml::BUTTON_COLOR_PRIMARY,));?>
</div>
<div class="clearfix"></div>
<?php $this->endWidget(); ?>
