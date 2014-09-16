<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - ' . __('Error');
$this->breadcrumbs = array(
    __('Error'),
);
?>

<h2><?= __('Error') ?> <?php echo $code; ?></h2>

<div class="error">
    <?php echo CHtml::encode($message); ?>
</div>