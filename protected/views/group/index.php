<?php
/* @var $this UserController */
/* @var $model User */

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#group-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<ol class="breadcrumb">
    <li><a href="/"><?=__('Home')?></a></li>
    <li><a href="/user"><?=__('Users')?></a></li>
    <li><?=__('Groups')?></li>
    <span class="pull-right admin_action">
        <a href="/group/create"><i class="fa fa-plus"></i> <?=__( 'Create New Group')?></a>
    </span>
</ol>
<div class="page-header">
    <h3>
        <?=__('Groups')?>
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
                <?php $this->renderPartial('index/grid', array(
                    'model'=> $model,
                )); ?>
            </div>
        </div>
    </div>
</div>