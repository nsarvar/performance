<div class="panel panel-default">
    <div class="panel-heading">
        <h4><?= __('Executers') ?>
            <small><a
                    href="<?= Yii::app()->createUrl("task/full", array("id" => $model->id)) ?>"><?= __('Show Full') ?></a>
            </small>
        </h4>
    </div>
    <?php $this->widget('bootstrap.widgets.BsGridView', array(
        'id'           => "task-jobs-grid",
        'dataProvider' => $model->getTaskJobs(),
        'template'     => "{items}\n{pager}<div class='defender'></div>",
        'type'         => BsHtml::GRID_TYPE_STRIPED_HOVER,

        'columns'      => array(
            array(
                'name'  => 'organization_name',
                'value' => 'CHtml::link($data->organization_name, Yii::app()->createUrl("task/job",array("id"=>$data->id)),array("onclick"=>"return showTaskJob(\'$data->id\')"))',
                'type'  => 'raw',
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
    ?>

</div>
<?php
function getRowActions($data)
{
    $html = ''; //CHtml::link("<i class='fa fa-edit'></i>", "#", array("onclick" => "return showTaskJob('{$data->id}')", "class" => "btn-action"));
    if (count($data->files)) $html .= CHtml::link("<i class='fa fa-download'></i>", "#", array("onclick" => "return downloadTaskJobFiles('{$data->id}','" . count($data->files) . "')", "class" => "btn-action"));
    if ($data->status != Job::STATUS_APPROVED)
        return CHtml::link("<i class='fa fa-check'></i>", Yii::app()->createUrl("task/approve", array("id" => $data->id, 'page' => 'view')), array("class" => "btn-action", 'onclick' => "return approveTaskJob('{$data->id}')")) . $html;
    if ($data->status == Job::STATUS_APPROVED)
        return CHtml::link("<i class='fa fa-ban'></i>", Yii::app()->createUrl("task/reject", array("id" => $data->id, 'page' => 'view')), array("class" => "btn-action", 'onclick' => "return rejectTaskJob('{$data->id}')")) . $html;

}

?>