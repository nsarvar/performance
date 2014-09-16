<?php $this->widget('bootstrap.widgets.BsGridView', array(
    'id'            => "period-$status-grid",
    'dataProvider'  => Period::getPeriods($status),
    'template'      => "{items}\n{pager}<div class='defender'></div>",
    'type'          => BsHtml::GRID_TYPE_STRIPED,
    'columns'       => array(
        array(
            'name'  => 'name',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("task/period",array("id"=>$data->primaryKey)))',
            'type'  => 'raw',
        ),
        array(
            'name'       => 'period_from',
            'htmlOptions'=> array('width'=> '220px'),
            'value'      => 'Yii::app()->dateFormatter->format("MMMM, y",strtotime($data->period_from))'
        ),
        array(
            'htmlOptions'=> array('width'=> '120px'),
            'name'       => 'task_count'
        )
    ),
)); ?>