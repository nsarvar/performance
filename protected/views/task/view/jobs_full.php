<?php
/**
 * @var $model Task
 * @var $job   Job
 */
$this->widget('zii.widgets.CListView', array(
    'id'                 => "task-jobs-grid",
    'dataProvider'       => $model->getTaskJobs(null,false,true),
    'itemView'           => 'view/_job',
    'template'           => "<!--<div class='sorting'>{sorter}</div>-->{items}<div class='defender'></div>",
    'enableSorting'      => true,
    'sorterCssClass'     => 'sorter-jobs',
    'sorterHeader'       => '',
    'sortableAttributes' => array(
        'updated_at'        => 'Updated',
        'organization_name' => 'Organizations',
        'status'            => 'Status'
    ),
));
?>

