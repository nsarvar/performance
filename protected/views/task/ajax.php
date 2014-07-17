<?php $this->widget('bootstrap.widgets.BsGridView', array(
    'id'            => "task-parent-grid",
    'dataProvider'  => Task::getTasks(),
    'template'      => "{items}\n{pager}<div class='defender'></div>",
    'type'          => BsHtml::GRID_TYPE_STRIPED,
    'columns'       => array(
        array('name'=> 'id', 'header'=> 'ID', 'htmlOptions'=> array('width'=> '60px')),
        array('name'=> 'number', 'header'=> 'Number'),
        array(
            'name'       => 'name',
            'header'     => 'Task Name',
            'value'      => 'CHtml::link($data->name, Yii::app()->createUrl("task/view",array("id"=>$data->primaryKey)))',
            'type'       => 'raw'
        ),
    ),
)); ?>
<div class="clearfix"></div>