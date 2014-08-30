<?php $this->widget('bootstrap.widgets.BsGridView', array(
    'id'          => 'group-grid',
    'dataProvider'=> $model->search(),
    'type'         => BsHtml::GRID_TYPE_STRIPED,
    'template'    => "{items}\n{pager}<div class='defender'></div>",
    'columns'     => array(
        array(
            'name'       => 'name',
            'header'     => 'Name',
            'value'      => 'CHtml::link($data->name, Yii::app()->createUrl("group/update",array("id"=>$data->primaryKey)))',
            'type'       => 'raw'
        ),
    ),
)); ?>