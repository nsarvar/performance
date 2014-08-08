<?php $this->widget('bootstrap.widgets.BsGridView', array(
    'id'           => "task-jobs-grid",
    'dataProvider' => $model->getTaskJobs(),
    'template'     => "{items}\n{pager}<div class='defender'></div>",
    'type'         => BsHtml::GRID_TYPE_STRIPED_HOVER,

    'columns'      => array(
        array(
            'name'  => 'organization_name',
            'value' => 'CHtml::link($data->organization_name, "#",array("onclick"=>"return showTaskJob(\'$data->id\')"))',
            'type'  => 'raw',
            /*'htmlOptions' => array(
                'onclick' => 'alert(1)'
            )*/
        ),
        array(
            'name'              => 'content',
            'value'             => 'substr($data->content,0,60)',
            'htmlOptions'       => array('class' => 'visible-lg visible-md'),
            'headerHtmlOptions' => array('class' => 'visible-lg visible-md'),
        ),
        array(
            'name'              => 'updated_at',
            'value'             => 'Task::getFormattedDate($data->updated_at)',
            'htmlOptions'       => array('class' => 'visible-lg'),
            'headerHtmlOptions' => array('class' => 'visible-lg'),
        ),

        array(
            'htmlOptions' => array('width' => '120px'),
            'name'        => 'status',
            'type'        => 'raw',
            'value'       => '$data->getStatusLabel()',
        ),
        array(
            'htmlOptions' => array('width' => 'auto'),
            'name'        => 'actions',
            'header'      => '',
            'type'        => 'raw',
            'value'       => 'getRowActions($data)',
        )
    ),
));

function getRowActions($data)
{
    $html = '';//CHtml::link("<i class='fa fa-edit'></i>", "#", array("onclick" => "return showTaskJob('{$data->id}')", "class" => "btn-action"));
    if(count($data->files))$html .= CHtml::link("<i class='fa fa-download'></i>", "#", array("onclick" => "return downloadTaskJobFiles('{$data->id}')", "class" => "btn-action"));
    if ($data->status != Job::STATUS_APPROVED)
        return CHtml::link("<i class='fa fa-check'></i>", "#", array("onclick" => "return approveTaskJob('{$data->id}')", "class" => "btn-action")) . $html;

    return CHtml::link("<i class='fa fa-ban'></i>", "#", array("onclick" => "return rejectTaskJob('{$data->id}')", "class" => "btn-action")) . $html;

}

?>