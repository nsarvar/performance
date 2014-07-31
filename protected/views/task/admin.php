<?php
/* @var $this TaskController */
/* @var $model Task */


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
    <li>Tasks</li>
    <span class="pull-right admin_action">
        <a href="/task/create"><i class="fa fa-plus"></i> <?=__( 'Create New Task')?></a>
    </span>
</ol>
<div class="page-header">
    <h3>
        Tasks
    </h3>
</div>
<div class="row">
    <div class="col col-lg-3">
        <div class="search-form">
            <?php $this->renderPartial('_search', array(
            'model'=> $model,
        )); ?>
            <hr>
        </div>
    </div>

    <div class="col col-lg-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php $this->widget('bootstrap.widgets.BsGridView', array(
                'id'          => 'task-grid',
                'dataProvider'=> $model->search(),
                'template'    => "{items}\n{pager}<div class='defender'></div>",
                'type'         => BsHtml::GRID_TYPE_STRIPED,
                'columns'     => array(
                    array('name'=> 'id', 'header'=> 'ID', 'htmlOptions'=> array('width'=> '60px')),
                    array('name'=> 'number', 'header'=> 'Number'),
                    array(
                        'name'       => 'name',
                        'header'     => 'Task Name',
                        'value'      => 'CHtml::link($data->name, Yii::app()->createUrl("task/view",array("id"=>$data->primaryKey)))',
                        'type'       => 'raw'
                    ),
                    array(
                        'name'  => 'start_date',
                        'header'=> 'Start',
                        'value' => 'Yii::app()->dateFormatter->format("d-MMMM, y",strtotime($data->start_date))'
                    ),
                    array(
                        'name'  => 'end_date',
                        'header'=> 'End',
                        'value' => 'Yii::app()->dateFormatter->format("d-MMMM, y",strtotime($data->end_date))'
                    ),

                    array(
                        'header'=> 'User',
                        'name'  => 'user_name',
                        'value' => 'CHtml::link($data->user_name, Yii::app()->createUrl("user/view",array("id"=>$data->user_id)))',
                        'type'  => 'raw'
                    ),
                ),
            )); ?>
            </div>
        </div>
    </div>

</div>





