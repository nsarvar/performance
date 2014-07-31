<div class="form-task-organizations-selected-search">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'action' => Yii::app()->createUrl('task/selectedOrg'),
        'method' => 'get',
        'id'     => 'form_selected_org'
    ));
    ?>
    <?php echo $form->hiddenField($search, 'so_ids', array('name' => 'so_ids', 'id' => 'so_ids')); ?>
    <?php $this->endWidget(); ?>

    <?php $this->widget('bootstrap.widgets.BsGridView', array(
        'id'             => "task-organizations-selected-grid",
        'dataProvider'   => $search->getSelectedOrganizationsForTaskCreate(),
        'template'       => "{items}\n{pager}<div class='defender'></div>",
        'type'           => BsHtml::GRID_TYPE_STRIPED,
        'selectableRows' => 1000,
        'columns'        => array(
            array(
                'id'                  => 'selectedOrganizationIds',
                'class'               => 'CCheckBoxColumn',
                'checked'             => '$data->id>0',
                'checkBoxHtmlOptions' => array('name'    => 't_orgs_selected[]',
                                               ),
            ),
            'name',
        ),
    )); ?>
    <div class="clearfix"></div>
</div>
