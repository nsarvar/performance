<?php
/* @var $this GroupController */
/* @var $model Group */
/* @var $form BSActiveForm */
?>

<?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id'                     => 'group-form',
    'enableAjaxValidation'   => true,
    'enableClientValidation' => true,
    'clientOptions'          => array('validateOnSubmit' => true)
)); ?>
<?php echo $form->errorSummary($model); ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col col-md-12 col-lg-6">
                <?php echo $form->textFieldControlGroup($model, 'name', array('maxlength' => 30)); ?>
            </div>
            <div class="col col-md-12 col-lg-6">

                <?php echo $form->textFieldControlGroup($model, 'short_name', array('maxlength' => 30)); ?>

            </div>
        </div>
    </div>
</div>
<hr>
<p class="text-muted pull-left">Fields with <span class="required">*</span> are required.</p>
<p class="pull-right">
    <button type="button" name="yt10"
            class="btn btn-default btn-lg btn-delete <?= $model->scenario == 'update' ? '' : 'hidden' ?>"
            action="<?= Yii::app()->createUrl("user/delete", array("id" => $model->primaryKey)) ?>">Delete
    </button>
    <button type="submit" name="save"
            class="btn btn-success btn-lg"><?= $model->scenario == 'update' ? 'Update' : 'Create User' ?></button>
</p>
<?php $this->endWidget(); ?>
