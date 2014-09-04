<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::encode($data->name); ?>
    <br/>

    <b><?php echo CHtml::encode($data->organization->getAttributeLabel('organization_id')); ?>:</b>
    <?php echo CHtml::encode($data->organization->name); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
    <?php echo CHtml::encode($data->email); ?>
    <br/>
</div>