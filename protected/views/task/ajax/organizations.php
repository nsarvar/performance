<div class="modal-body form-task-organizations-search">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'action' => Yii::app()->createUrl('task/organizations'),
        'method' => 'get',
    ));
    ?>
    <div class="row">
        <?php echo $form->hiddenField($search, 'so_ids'); ?>
        <div class="col col-md-3">
            <?php echo $form->dropDownListControlGroup($search, 'type', Organization::getTypesArray(), array('class' => 'selectpicker show-tick', 'title' => 'Type')); ?>
        </div>
        <div class="col col-md-3">
            <?php echo $form->dropDownListControlGroup($search, 'region_id', Region::getOptionLabels(), array('class' => 'selectpicker show-tick', 'title' => 'Region')); ?>
        </div>
        <div class="col col-md-6">
            <label class="control-label required">Name</label>
            <div class="input-group" style="width: 100%;">
                <?php echo $form->textField($search, 'name'); ?>
                <span class="input-group-btn">
                <?php echo BsHtml::submitButton('Search', array('color' => BsHtml::BUTTON_COLOR_PRIMARY,)); ?>
                </span>
            </div>
        </div>
    </div>


    <div class="clearfix"></div>
    <?php $this->endWidget(); ?>

    <?php $this->widget('bootstrap.widgets.BsGridView', array(
        'id'             => "task-organizations-grid",
        'dataProvider'   => $search->getOrganizationsForTaskCreate(),
        'template'       => "{items}\n{pager}<div class='defender'></div>",
        'type'           => BsHtml::GRID_TYPE_STRIPED,
        'selectableRows' => 1000,
        'columns'        => array(
            array(
                'id'                  => 'selectedOrganizationIds',
                'class'               => 'CCheckBoxColumn',
                'checkBoxHtmlOptions' => array('name' => 't_orgs[]',),
            ),
            'name',
        ),
    )); ?>
    <div class="clearfix"></div>
</div>
