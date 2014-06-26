<?php
/* @var $this OrganizationController */
/* @var $model Organization */
/* @var $form BSActiveForm */
?>

<?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'action'=> Yii::app()->createUrl($this->route),
    'method'=> 'get',
)); ?>
<div class="row">
    <div class="col col-md-4 col-lg-12">
        <?php echo $form->dropDownListControlGroup($model, 'parent_id', Organization::getParents(), array('class'=> 'selectpicker show-tick', 'title'=> 'Parent Organization')); ?>
    </div>
    <div class="col col-md-4 col-lg-12">
        <?php echo $form->dropDownListControlGroup($model, 'type', Organization::getTypesArray(), array('class'=> 'selectpicker show-tick', 'title'=> 'Organization Type')); ?>
    </div>
    <div class="col col-md-4 col-lg-12">
        <?php echo $form->dropDownListControlGroup($model, 'region_id', Region::getOptionLabels(), array('class'=> 'selectpicker show-tick', 'title'=> 'Organization Region')); ?>
    </div>
</div>

<div class="form-actions pull-right">
    <?php echo BsHtml::submitButton('Search', array('color' => BsHtml::BUTTON_COLOR_PRIMARY,));?>
</div>
<div class="clearfix"></div>
<?php $this->endWidget(); ?>
