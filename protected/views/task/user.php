<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#job-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<ol class="breadcrumb">
    <li><a href="/"><?= __('Home') ?></a></li>
    <li><?= __('Tasks') ?></li>
</ol>

<div class="page-header">
    <h3>
        <i class="fa fa-tasks"></i> <?= __('Tasks') ?>
    </h3>
</div>

<div class="row">
    <div class="col col-md-3">
        <div class="search-form">
            <?php $this->renderPartial('user/_search', array(
                'model' => $model,
            )); ?>
            <hr>
        </div>
    </div>
    <div class="col col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php $this->widget('bootstrap.widgets.BsGridView', array(
                    'id'                    => 'job-grid',
                    'dataProvider'          => $model->userAllTasks($this->_user()),
                    'template'              => "{items}\n{pager}<div class='defender'></div>",
                    'type'                  => BsHtml::GRID_TYPE_STRIPED,
                    'rowCssClassExpression' => '"prt-".$data->priority." sts-".$data->status',
                    'columns'               => array(
                        array(
                            'name'  => 'number',
                            'value' => 'CHtml::link("<span class=\'prt priority-".$data->priority."\'>".$data->number."</span>", Yii::app()->createUrl("task/job",array("id"=>$data->primaryKey)))',
                            'type'  => 'raw',
                        ),
                        array(
                            'name'  => 'name',
                            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("task/job",array("id"=>$data->primaryKey)))',
                            'type'  => 'raw',
                        ),
                        array(
                            'name'  => 'status',
                            'type'  => 'raw',
                            'value' => '"<span class=\'mrk mark-".$data->status."\'>".$data->getStatusLabel()."</status"'
                        ),
                        array(
                            'name'   => 'user_name',
                            'header' => 'User',
                            'value'  => 'CHtml::link($data->user_name, Yii::app()->createUrl("user/view",array("id"=>$data->task_user_id)))',
                            'type'   => 'raw',
                        ),
                        array(
                            'name'   => 'updated_at',
                            'header' => 'Updated',
                            'value'  => 'Yii::app()->dateFormatter->format("d-MMMM, y H:m",strtotime($data->updated_at))'
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div>



