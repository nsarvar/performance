<?php
/* @var $this TaskController */
/* @var $model Task */
?>

    <ol class="breadcrumb">
        <li><a href="/"><?= __('Home') ?></a></li>
        <li><a href="/task"><?= __('Tasks') ?></a></li>
        <li><?= $model->name ?></li>
        <span class="pull-right action_admin">
            <a href="/task/update/<?= $model->id ?>"><i class="fa fa-edit"></i> <?= __('Update Task') ?></a>
        </span>
    </ol>

<?php echo BsHtml::pageHeader('View', 'Task ' . $model->id) ?>

<?php $this->widget('zii.widgets.CDetailView', array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'        => $model,
    'attributes'  => array(
        'id',
        'number',
        'name',
        'type',
        'parent_id',
        'group_id',
        'user_id',
        'period_id',
        'status',
        'priority',
        'start_date',
        'end_date',
        'description',
        'attachable',
        'created_at',
        'updated_at',
    ),
)); ?>