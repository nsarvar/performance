<?php
/* @var $this OrganizationController */
/* @var $model Organization */
/* @var $form BSActiveForm */
?>

<?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id'                  => 'organization-form',
    'enableAjaxValidation'  => true,
    'enableClientValidation'=> true,
    'clientOptions'         => array('validateOnSubmit'=> true)
)); ?>
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col col-sm-6">
        <?php echo $form->textFieldControlGroup($model, 'name', array('maxlength'=> 255)); ?>
        <?php echo $form->textFieldControlGroup($model, 'short_name', array('maxlength'=> 30)); ?>
        <?php echo $form->dropDownListControlGroup($model, 'parent_id', Organization::getOptionLabels(false),array('class'=> 'selectpicker show-tick', 'title'=> 'Choose Parent Organization')); ?>
        <?php echo $form->dropDownListControlGroup($model, 'type', Organization::getTypesArray(false),array('class'=> 'selectpicker show-tick', 'title'=> 'Choose Type')); ?>
        <hr>
        <div class="row">
            <div class="col col-xs-6">
                <?php echo $form->textFieldControlGroup($model, 'phone', array('maxlength'=> 255)); ?>
            </div>
            <div class="col col-xs-6">
                <?php echo $form->textFieldControlGroup($model, 'email', array('maxlength'=> 64)); ?>
            </div>
        </div>
    </div>
    <div class="col col-sm-6">
        <?php echo $form->textFieldControlGroup($model, 'description', array('maxlength'=> 255)); ?>
        <?php echo $form->dropDownListControlGroup($model, 'region_id', Region::getOptionLabels(),array('class'=> 'selectpicker show-tick', 'title'=> 'Choose Region')); ?>
        <?php echo $form->textAreaControlGroup($model, 'address', array('maxlength'=> 255)); ?>
        <?php echo $form->textFieldControlGroup($model, 'web_site', array('maxlength'=> 255)); ?>
    </div>
</div>
<hr>
<p class="text-muted pull-left">Fields with <span class="required">*</span> are required.</p>
<p class="pull-right">
    <button type="button" name="yt10" class="btn btn-default btn-lg btn-delete" action="<?=Yii::app()->createUrl("organization/delete",array("id"=>$model->primaryKey))?>">Delete</button>
    <button type="submit" name="save" class="btn btn-success btn-lg">Update</button>
</p>
<?php $this->endWidget(); ?>
