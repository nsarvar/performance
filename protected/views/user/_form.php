<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form BSActiveForm */
?>

<?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id'                     => 'user-form',
    'enableAjaxValidation'   => true,
    'enableClientValidation' => true,
    'clientOptions'          => array('validateOnSubmit' => true)
)); ?>

<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col col-md-12 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php echo $form->textFieldControlGroup($model, 'login', array('maxlength' => 30, 'disabled' => $model->scenario == 'update' ? 'disabled' : '')); ?>
                <?php if ($model->scenario == 'update'): ?>
                    <div class="input-group" style="width: 100%;">

                        <?php echo $form->passwordField($model, 'password', array('autocomplete' => 'off','value' => '', 'class' => 'disabled ', 'style' => 'width: 50%;', 'disabled' => 'disabled')); ?>
                        <?php echo $form->passwordField($model, 'password_repeat', array('autocomplete' => 'off','value' => '', 'class' => 'disabled ', 'style' => 'width: 50%;margin-left:-2px', 'disabled' => 'disabled')); ?>
                        <span class="input-group-btn btn-group" data-toggle="buttons">
                        <label class="btn btn-primary" style="height: 34px;margin-left: -2px;">
                            <input type="checkbox" name="change_password" id="change_password" value="1"
                                   autocomplete="off">
                            <?= __('Change Password') ?>
                        </label>
                    </span>
                    </div>
                    <hr>
                <?php else: ?>
                    <div class="row">
                        <div class="col col-sm-6">
                            <?php echo $form->passwordFieldControlGroup($model, 'password', array('value' => '', 'autocomplete' => 'off', 'style' => '',)); ?>
                        </div>
                        <div class="col col-sm-6">
                            <?php echo $form->passwordFieldControlGroup($model, 'password_repeat', array('value' => '', 'autocomplete' => 'off', 'style' => '',)); ?>
                        </div>
                    </div>

                <?php endif ?>

                <?php echo $form->dropDownListControlGroup($model, 'status', User::getStatusArray(false), array('class' => 'selectpicker show-tick', 'title' => __('Choose Role'))); ?>

            </div>
        </div>
    </div>
    <div class="col col-md-6 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php echo $form->dropDownListControlGroup($model, 'role', User::getRolesArray(false), array('class' => 'selectpicker show-tick', 'title' => __('Choose Role'))); ?>
                <?php echo $form->dropDownListControlGroup($model, 'organization_id', Organization::getOptionLabels(false), array('class' => 'selectpicker show-tick', 'title' => __('Choose Organization'))); ?>
                <?php echo $form->dropDownListControlGroup($model, 'group_id', Group::getOptionLabels(), array('class' => 'selectpicker show-tick', 'title' => __('Choose Group'))); ?>
            </div>
        </div>
    </div>
    <div class="col col-md-6 col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col col-lg-6">
                    <?php echo $form->textFieldControlGroup($model, 'name', array('maxlength' => 128)); ?>
                    <?php echo $form->textFieldControlGroup($model, 'email', array('maxlength' => 64)); ?>
                </div>
                <div class="col col-lg-6">
                    <?php echo $form->textFieldControlGroup($model, 'telephone', array('maxlength' => 14)); ?>
                    <div class="hidden-md">
                        <?php echo $form->textFieldControlGroup($model, 'mobile', array('maxlength' => 14)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<p class="text-muted pull-left"><?= __('Fields with <span class="required">*</span> are required.') ?></p>
<p class="pull-right">
    <button type="button" name="yt10"
            class="btn btn-default btn-lg btn-delete <?= $model->scenario == 'update' ? '' : 'hidden' ?>"
            action="<?= Yii::app()->createUrl("user/delete", array("id" => $model->primaryKey)) ?>"><?=__('Delete')?>
    </button>
    <button type="submit" name="save"
            class="btn btn-success btn-lg"><?= $model->scenario == 'update' ? __('Update') : __('Create User')?></button>
</p>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#change_password').on('change', function () {
            $('input[name="User[password]"],input[name="User[password_repeat]"]').attr('disabled', !this.checked);
        })
    })
</script>
