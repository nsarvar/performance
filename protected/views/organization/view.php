<?php
/* @var $this OrganizationController */
/* @var $model Organization */
?>

<ol class="breadcrumb ">
    <li><a href="/">Home</a></li>
    <li><a href="/organization">Organizations</a></li>
    <li><?=$model->name?></li>
    <span class="pull-right action_admin">
        <a href="/organization/create"><i class="fa fa-plus"></i> <?=__('app', 'Add Organization')?></a>
    </span>
</ol>

<div class="page-header">
    <h3>
        <i class="fa fa-university"></i> <?=$model->name?>
        <small class="info_block " data-src="info_block_org"> Information</small>
    </h3>
</div>
<div id="info_block_org" class="info_block_src">
    <?php
    $attributes = array(
        array(
            'name' => 'parent_id',
            'value'=> CHtml::link($model->parent->name, Yii::app()->createUrl("organization/view", array("id"=> $model->parent_id))),
            'type' => 'raw',
        ),
        array(
            'name' => 'name',
            'value'=> $model->name.'<span class="action_admin">'.CHtml::link('Edit', Yii::app()->createUrl("organization/update", array("id"=> $model->id))).'</span>',
            'type' => 'raw',
        ),
    );

    foreach (array(
                 'description',
                 'address',
                 'phone',
                 'email',
                 'web_site',
             ) as $attribute) if ($model->$attribute) $attributes[] = $attribute;

    if ($model->region_id) $attributes[] = array(
        'name' => 'region_id',
        'value'=> CHtml::link($model->region->name, Yii::app()->createUrl("region/view", array("id"=> $model->region_id))),
        'type' => 'raw',
    );

    $this->widget('zii.widgets.CDetailView', array(
        'htmlOptions' => array(
            'class' => 'table table-striped table-condensed table-hover',
        ),
        'data'        => $model,
        'attributes'  => $attributes,
    )); ?>
    <hr>
</div>

<ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#tab_active_periods" role="tab" data-toggle="tab">Active Periods</a></li>
    <li><a href="#tab_archive_periods" role="tab" data-toggle="tab">Archive Periods</a></li>
    <li><a href="#tab_organizations" role="tab" data-toggle="tab">Organizations</a></li>
    <li><a href="#tab_users" role="tab" data-toggle="tab">Users</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="tab_active_periods">
        AP
    </div>
    <div class="tab-pane" id="tab_archive_periods">
        AR
    </div>
    <div class="tab-pane" id="tab_organizations">
        OR
    </div>
    <div class="tab-pane" id="tab_users">
        US
    </div>
</div>