<?php
/* @var $this PeriodController */
/* @var $model Period */


$this->breadcrumbs = array(
    __('Periods'),
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
        <?=__('Periods')?>
        <small></small>
    </h3>
</div>
<div class="row">
    <div class="col col-md-3 search-form">
        <?php
        $this->renderPartial('_search', array(
            'model'=> $model,
        ));
        ?>
        <hr>
    </div>

    <div class="col col-md-9">

        <div class="panel panel-default">
            <div class="panel-body">
                <?php $this->widget('bootstrap.widgets.BsGridView', array(
                'id'            => 'period-grid',
                'dataProvider'  => $model->search(),
                'template'    => "{items}\n{pager}<div class='defender'></div>",
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
                        'value' => 'Yii::app()->dateFormatter->format("MMMM, y",strtotime($data->period_from))'
                    ),
                    'status',
                ),
            )); ?>
            </div>
        </div>

    </div>


</div>




