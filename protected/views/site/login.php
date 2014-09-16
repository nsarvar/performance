<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - ' . __('Login');
$this->breadcrumbs = array(
    __('Login'),
);
?>

<div class="panel panel-default">
    <div class="panel-heading"><?=__('User Dashboard')?></div>
    <div class="panel-body">
        <div id="messages-area">

        </div>

        <?php $form = $this->beginWidget('BsActiveForm', array(
            'id'                     => 'login-form',
            'layout'                 => BsHtml::FORM_LAYOUT_VERTICAL,
            'enableClientValidation' => true,
            'clientOptions'          => array(
                'validateOnSubmit' => true,
            ),
        ));

        echo $form->textFieldControlGroup($model, 'login', array(
            'prepend'      => BsHtml::icon(BsHtml::GLYPHICON_USER),
            'placeholder'  => 'Login',
            'labelOptions' => array(),
        ));

        echo $form->passwordFieldControlGroup($model, 'password', array(
            'prepend'      => BsHtml::icon(BsHtml::GLYPHICON_LOCK),
            'placeholder'  => 'Login',
            'labelOptions' => array(),
        ));
        ?>
        <div style="width: 100%;" class="form-group input-group">
            <?php
            echo BsHtml::submitButton(__('Sign In'), array(
                'color' => BsHtml::BUTTON_COLOR_PRIMARY,
                'name'  => 'submit'
            ));
            ?>
            <div style="margin: 8px 10px 0 0" class="pull-right small">
                <a class="text-muted " href="/user/reset"><?= __('Reset Password') ?></a>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

