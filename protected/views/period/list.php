<?php
/* @var $this PeriodController */
/* @var $model Period */


$this->breadcrumbs = array(
    'Periods'=> array('index'),
    'List',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#period-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="page-header">
    <h3>
        Periods
        <small></small>
    </h3>
</div>
<div class="row">
    <div class="col col-xs-9">

        <div class="panel panel-default">
            <div class="panel-body">
                <?php $this->widget('bootstrap.widgets.BsGridView', array(
                'id'            => 'period-grid',
                'dataProvider'  => $model->search(),
                'template'      => '{items}{pager}',
                'summaryText'   => '',
                'type'          => BsHtml::GRID_TYPE_STRIPED,
                'columns'       => array(
                    array('name'=> 'id', 'htmlOptions'=> array('width'=> '60px')),
                    array(
                        'name'  => 'name',
                        'value' => 'CHtml::link($data->name, Yii::app()->createUrl("task/period",array("id"=>$data->primaryKey)))',
                        'type'  => 'raw',
                    ),
                    array(
                        'name'  => 'period_from',
                        'header'=> 'From',
                        'value' => 'Yii::app()->dateFormatter->format("MMMM, y",strtotime($data->period_from))'
                    ),
                    'status',
                    /*array(
                        'name'  => 'period_to',
                        'header'=> 'To',
                        'value' => '$data->periodToFormatted',
                    ),*/
                    /*array(
                        'class'=> 'bootstrap.widgets.BsButtonColumn',
                    ),*/
                ),
            )); ?>
            </div>
        </div>

    </div>
    <div class="col col-xs-3">
        <?php
        $this->renderPartial('_search', array(
            'model'=> $model,
        ));
        ?>
    </div>

</div>




