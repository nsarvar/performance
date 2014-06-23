<?php
/* @var $this PeriodController */
/* @var $data Period */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('task_count')); ?>:</b>
	<?php echo CHtml::encode($data->task_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('period_from')); ?>:</b>
	<?php echo CHtml::encode($data->period_from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('period_to')); ?>:</b>
	<?php echo CHtml::encode($data->period_to); ?>
	<br />


</div>