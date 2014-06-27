<?php $this->widget('bootstrap.widgets.BsGridView', array(
    'id'            => "users-grid",
    'dataProvider'  => User::getUsers($organization),
    'template'      => "{items}\n{pager}<div class='defender'></div>",
    'type'          => BsHtml::GRID_TYPE_STRIPED,
    'columns'       => array(
        array(
            'name'  => 'name',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("user/view",array("id"=>$data->primaryKey)))',
            'type'  => 'raw',
        ),
    ),
)); ?>