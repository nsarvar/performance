<div class="panel panel-default">
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BsGridView', array(
            'id'                    => 'job-grid',
            'dataProvider'          => $model->userTasks($this->_user()),
            'template'              => "{items}\n{pager}<div class='defender'></div>",
            'type'                  => BsHtml::GRID_TYPE_STRIPED,
            'rowCssClassExpression' => '"prt-".$data->priority." sts-".$data->status',
            'columns'               => array(
                array(
                    'name'  => 'number',
                    'value' => 'CHtml::link("<span class=\'prt priority-".$data->priority."\'>".$data->number."</span>", Yii::app()->createUrl("task/job",array("id"=>$data->primaryKey)))',
                    'type'  => 'raw',
                ),
                array(
                    'name'  => 'status',
                    'type'  => 'raw',
                    'value' => '$data->getStatusLabel()'
                ),
                array(
                    'name'   => 'user_name',
                    'header' => 'User',
                    'value'  => 'CHtml::link($data->user_name, Yii::app()->createUrl("user/view",array("id"=>$data->task_user_id)))',
                    'type'   => 'raw',
                ),
            ),
        )); ?>
    </div>
</div>