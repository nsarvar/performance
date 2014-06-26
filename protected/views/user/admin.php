<?php
/* @var $this UserController */
/* @var $model User */


$this->breadcrumbs = array(
    'Users'=> array('index'),
    'Manage',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
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
                'id'          => 'user-grid',
                'dataProvider'=> $model->search(),
                'template'    => "{items}\n{pager}<div class='defender'></div>",
                'columns'     => array(
                    array('name'=> 'id', 'header'=> 'ID', 'htmlOptions'=> array('width'=> '60px')),
                    array('name'=> 'login', 'header'=> 'Login', 'htmlOptions'=> array('width'=> '150px')),
                    array(
                        'header'=> 'Organization',
                        'name'  => 'organization_name',
                        'type'  => 'raw'
                    ),
                ),
            )); ?>
            </div>
        </div>
    </div>

</div>




