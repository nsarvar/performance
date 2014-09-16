<?php
/* @var $this UserController */
/* @var $model User */

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<ol class="breadcrumb">
    <li><a href="/"><?=__('Home')?></a></li>
    <li><?=__('Users')?></li>
    <span class="pull-right admin_action">
        <a href="/user/create"><i class="fa fa-plus"></i> <?=__( 'Create New User')?></a>
    </span>
</ol>
<div class="page-header">
    <h3>
        <?=__('Users')?>
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
                'id'          => 'user-grid',
                'dataProvider'=> $model->search(),
                'type'         => BsHtml::GRID_TYPE_STRIPED,
                'template'    => "{items}\n{pager}<div class='defender'></div>",
                'columns'     => array(
                    array('name'=> 'id', 'header'=> 'ID', 'htmlOptions'=> array('width'=> '60px')),
                    array(
                        'name'       => 'login',
                        'value'      => 'CHtml::link($data->login, Yii::app()->createUrl("user/update",array("id"=>$data->primaryKey)))',
                        'htmlOptions'=> array('width'=> '150px'),
                        'type'       => 'raw'
                    ),
                    array(
                        'name'  => 'organization_name',
                        'value' => 'CHtml::link($data->organization_name, Yii::app()->createUrl("user/update",array("id"=>$data->primaryKey)))',
                        'type'  => 'raw'
                    ),
                ),
            )); ?>
            </div>
        </div>
    </div>

</div>




