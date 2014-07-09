<?php
/* @var $this TaskController */
/* @var $model Task */
/* @var $form BSActiveForm */
?>

<?php
Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'action'=> Yii::app()->createUrl($this->route),
    'method'=> 'get',
));
?>

<div class="row">
    <div class="col col-sm-3 col-md-3 col-lg-12">
        <?php echo $form->textFieldControlGroup($model, 'number', array('maxlength'=> 64)); ?>
    </div>
    <div class="col col-sm-3 col-md-3 col-lg-12">
        <?php echo $form->dropDownListControlGroup($model, 'user_id', Task::getUserOptions(), array('class'=> 'selectpicker show-tick', 'title'=> 'Any User')); ?>
    </div>
    <div class="col col-sm-3 col-md-3 col-lg-12">
        <div class="row">
            <div class="col col-xs-6">
                <?php echo $form->dropDownListControlGroup($model, 'status', Task::getStatusArray(), array('class'=> 'selectpicker show-tick', 'title'=> 'Any Status')); ?>

            </div>
            <div class="col col-xs-6">
                <?php echo $form->dropDownListControlGroup($model, 'priority', Task::getPriorityArray(), array('class'=> 'selectpicker show-tick', 'title'=> 'Any Priority')); ?>

            </div>
        </div>
    </div>
    <div class="col col-sm-3 col-md-3 col-lg-12">
        <?php echo $form->dropDownListControlGroup($model, 'period_id', Task::getPeriodArray(), array('class'=> 'selectpicker show-tick', 'title'=> 'Any Period')); ?>
    </div>
</div>

<div class="form-actions pull-right">
    <?php echo BsHtml::submitButton('Search', array('color' => BsHtml::BUTTON_COLOR_PRIMARY,));?>
</div>
<div class="clearfix"></div>
<?php $this->endWidget(); ?>
