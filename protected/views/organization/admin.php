<?php
/* @var $this OrganizationController */
/* @var $model Organization */


$this->breadcrumbs = array(
    'Organizations'=> array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#organization-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="page-header">
    <h3>
        Organizations
    </h3>
</div>
<div class="row">
    <div class="col col-lg-3 ">
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
                'id'            => 'organization-grid',
                'dataProvider'  => $model->search(),
                'template'      => '{items}{pager}',
                'type'          => BsHtml::GRID_TYPE_STRIPED,
                'columns'       => array(
                    'id',
                    array(
                        'name'  => 'name',
                        'value' => 'CHtml::link($data->name, Yii::app()->createUrl("organization/update",array("id"=>$data->primaryKey)))',
                        'type'  => 'raw',
                    ),
                    /*array(
                        'class'=> 'bootstrap.widgets.BsButtonColumn',
                    ),*/
                ),
            )); ?>
            </div>
        </div>
    </div>

</div>





