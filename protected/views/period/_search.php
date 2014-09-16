<?php
/* @var $this PeriodController */
/* @var $model Period */
/* @var $form BSActiveForm */
?>

<?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'action'=> Yii::app()->createUrl($this->route),
    'method'=> 'get',
));

Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
$this->widget('CJuiDateTimePicker', array(
    'model'    => $model, //Model object
    'attribute'=> 'period_from', //attribute name
    'mode'     => 'date', //use "time","date" or "datetime" (default)
    'options'  => array('dateFormat'=> 'yy-mm-dd') // jquery plugin options
));

$this->widget('CJuiDateTimePicker', array(
    'model'    => $model, //Model object
    'attribute'=> 'period_to', //attribute name
    'mode'     => 'date', //use "time","date" or "datetime" (default)
    'options'  => array('dateFormat'=> 'yy-mm-dd') // jquery plugin options
));

?>
<div class="form-actions pull-right">
    <?php echo BsHtml::submitButton(__('Search'), array('color' => BsHtml::BUTTON_COLOR_PRIMARY,));?>
</div>

<div class="clearfix"></div>
<?php $this->endWidget(); ?>
