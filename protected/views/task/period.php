<?php
/* @var $this TaskController */
/* @var $model Task */
/* @var $period Period */


Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#task-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<ol class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li><a href="/period"><?= __('Periods') ?></a></li>
    <li><?= __('Tasks on :period', array(':period' => $period->name)) ?></li>
    <?php if ($period->isCurrentPeriod()): ?>
        <span class="pull-right action_admin">
            <a href="/task/create/<?= $period->id ?>"><i class="fa fa-plus"></i> <?= __('Add New Task') ?></a>
        </span>
    <?php endif ?>
</ol>
<div class="page-header">
    <h3>
        <?= __("Tasks on %period", array('%period' => $period->name)) ?>
    </h3>
</div>
<div class="row">
    <div class="col col-lg-3">
        <div class="search-form">
            <?php
            /* @var $this TaskController */
            /* @var $model Task */
            /* @var $form BSActiveForm */
            ?>

            <?php
            Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
            $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
            ));
            ?>

            <div class="row">
                <div class="col col-sm-3 col-md-3 col-lg-12">
                    <?php echo $form->textFieldControlGroup($model, 'number', array('maxlength' => 64)); ?>
                </div>
                <div class="col col-sm-3 col-md-3 col-lg-12">
                    <?php echo $form->dropDownListControlGroup($model, 'user_id', Task::getUserOptions(), array('class' => 'selectpicker show-tick', 'title' => 'Any User')); ?>
                </div>
                <div class="col col-sm-3 col-md-3 col-lg-12">
                    <div class="row">
                        <div class="col col-xs-6">
                            <?php echo $form->dropDownListControlGroup($model, 'status', Task::getStatusArray(), array('class' => 'selectpicker show-tick', 'title' => 'Any Status')); ?>
                        </div>
                        <div class="col col-xs-6">
                            <?php echo $form->dropDownListControlGroup($model, 'priority', Task::getPriorityArray(), array('class' => 'selectpicker show-tick', 'title' => 'Any Priority')); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions pull-right">
                <?php echo BsHtml::submitButton('Search', array('color' => BsHtml::BUTTON_COLOR_PRIMARY,)); ?>
            </div>
            <div class="clearfix"></div>
            <?php $this->endWidget(); ?>
            <hr>
        </div>
    </div>

    <div class="col col-lg-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php $this->widget('bootstrap.widgets.BsGridView', array(
                    'id'           => 'task-grid',
                    'dataProvider' => $model->search(),
                    'template'     => "{items}\n{pager}<div class='defender'></div>",
                    'type'         => BsHtml::GRID_TYPE_STRIPED,
                    'columns'      => array(
                        array(
                            'name'   => 'number',
                            'header' => 'Number',
                            'value'  => 'CHtml::link($data->number, Yii::app()->createUrl("task/view",array("id"=>$data->primaryKey)))',
                            'type'   => 'raw'
                        ),
                        array(
                            'name'   => 'name',
                            'header' => 'Name',
                            'value'  => 'CHtml::link($data->name, Yii::app()->createUrl("task/view",array("id"=>$data->primaryKey)))',
                            'type'   => 'raw'
                        ),
                        array(
                            'name'   => 'start_date',
                            'header' => 'Start',
                            'value'  => 'Yii::app()->dateFormatter->format("d-MMMM, y",strtotime($data->start_date))'
                        ),
                        array(
                            'name'   => 'end_date',
                            'header' => 'End',
                            'value'  => 'Yii::app()->dateFormatter->format("d-MMMM, y",strtotime($data->end_date))'
                        ),

                        array(
                            'header' => 'User',
                            'name'   => 'user_name',
                            'value'  => 'CHtml::link($data->user_name, Yii::app()->createUrl("user/view",array("id"=>$data->user_id)))',
                            'type'   => 'raw'
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div>

</div>





