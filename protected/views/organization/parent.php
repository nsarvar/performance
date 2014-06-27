<?php $this->widget('bootstrap.widgets.BsGridView', array(
    'id'            => "organization-grid",
    'dataProvider'  => Organization::getChilds($parent),
    'template'      => "{items}\n{pager}<div class='defender'></div>",
    'type'          => BsHtml::GRID_TYPE_STRIPED,
    'columns'       => array(
        array(
            'name'  => 'name',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("organization/view",array("id"=>$data->primaryKey)))',
            'type'  => 'raw',
        ),
    ),
)); ?>