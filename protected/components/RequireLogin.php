<?php
/**
 * Created by PhpStorm.
 * User: complex
 * Date: 13/8/14
 * Time: 6:30 PM
 */

class RequireLogin extends CBehavior
{
    public function attach($owner)
    {
        $owner->attachEventHandler('onBeginRequest', array($this, 'handleBeginRequest'));
    }

    public function handleBeginRequest($event)
    {
        if (Yii::app()->user->isGuest && trim($_SERVER['REQUEST_URI'], '/') != 'site/login') {
            Yii::app()->user->loginRequired();
        }
    }
} 