<?php
/**
 * Created by JetBrains PhpStorm.
 * User: complex
 * Date: 6/17/14
 * Time: 4:52 PM
 * To change this template use File | Settings | File Templates.
 */

function __($message, $params = array(), $source = null, $language = null)
{
    return Yii::t('app', $message, $params, $source = null, $language = null);
}