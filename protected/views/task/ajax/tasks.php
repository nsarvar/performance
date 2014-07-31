<div class="modal-body form-task-parent-search">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'action' => Yii::app()->createUrl('task/tasks'),
        'method' => 'get',
    ));
    ?>
    <div class="input-group" style="width: 100%;">
        <?php echo $form->textField($search, 'number'); ?>
        <span class="input-group-btn">
            <?php echo BsHtml::submitButton('Search', array('color' => BsHtml::BUTTON_COLOR_PRIMARY,)); ?>
        </span>
    </div>

    <div class="clearfix"></div>
    <?php $this->endWidget(); ?>

    <?php $this->widget('bootstrap.widgets.BsGridView', array(
        'id'           => "task-parent-grid",
        'dataProvider' => $search->getTasksForTaskCreate(),
        'template'     => "{items}\n{pager}<div class='defender'></div>",
        'type'         => BsHtml::GRID_TYPE_STRIPED,
        'columns'      => array(
            array(
                'id'                  => 't_parent',
                'class'               => 'CCheckBoxColumn',
                'checkBoxHtmlOptions' => array(
                    'name'  => 't_parent[]',
                    'class' => 't_p_s',
                ),
                'value'               => '($data->number)?$data->id."|".$data->number:$data->id."|".$data->name'
            ),
            array('name' => 'number', 'header' => 'Number'),
            array(
                'name'   => 'name',
                'header' => 'Task Name',
                'value'  => 'CHtml::link($data->name, Yii::app()->createUrl("task/view",array("id"=>$data->primaryKey)))',
                'type'   => 'raw'
            ),
        ),
    )); ?>
    <div class="clearfix"></div>
</div>
