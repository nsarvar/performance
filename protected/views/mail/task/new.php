<!--@styles
body,td { color:#2f2f2f; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; }
@-->
<style>
    body, td {
        color: #2f2f2f;
        font: 11px/1.35em Verdana, Arial, Helvetica, sans-serif;
    }
</style>
<?php
/**
 * @var $task Task
 */
?>
<body
    style="background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
<div
    style="background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
    <table cellspacing="0" cellpadding="0" border="0" height="100%" width="100%">
        <tr>
            <td align="center" valign="top" style="padding:20px 0 10px 0">
                <table bgcolor="#FFFFFF" cellspacing="0" cellpadding="10" border="0" width="650"
                       style="border:1px solid #E0E0E0;">
                    <tr>
                        <td bgcolor="#EAEAEA" align="center" style="background:#EAEAEA; text-align:center;">
                            <center><h1 style="font-size:22px; font-weight:normal; line-height:22px; margin:0 0 0px 0;">
                                    <?= $task->name ?>
                                </h1></center>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table cellspacing="0" cellpadding="0" border="0" width="650">
                                <thead>
                                <tr>
                                    <th align="left" width="325" bgcolor="#EAEAEA"
                                        style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">
                                        <?= __('Description') ?>
                                    </th>
                                    <th width="10"></th>
                                    <th align="left" width="325" bgcolor="#EAEAEA"
                                        style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">
                                        <?= __('Details') ?>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td valign="top"
                                        style="font-size:12px; padding:7px 9px 9px 9px; border-left:1px solid #EAEAEA; border-bottom:1px solid #EAEAEA; border-right:1px solid #EAEAEA;">
                                        <?= $task->description ?>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td valign="top"
                                        style="font-size:12px; padding:7px 9px 9px 9px; border-left:1px solid #EAEAEA; border-bottom:1px solid #EAEAEA; border-right:1px solid #EAEAEA;">
                                        <table>
                                            <tbody>
                                            <tr>
                                                <td style="border-bottom:1px solid #EAEAEA;font-size:12px;padding-right: 10px"><?= __('Number') ?></td>
                                                <td style="border-bottom:1px solid #EAEAEA;font-size:12px;padding-left: 10px"><?= $task->number ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom:1px solid #EAEAEA;font-size:12px;padding-right: 10px"><?= __('Priority') ?></td>
                                                <td style="border-bottom:1px solid #EAEAEA;font-size:12px;padding-left: 10px"><?= $task->getPriorityLabel() ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom:1px solid #EAEAEA;font-size:12px;padding-right: 10px"><?= __('Curator') ?></td>
                                                <td style="border-bottom:1px solid #EAEAEA;font-size:12px;padding-left: 10px"><?= $task->user->name ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom:1px solid #EAEAEA;font-size:12px;padding-right: 10px"><?= __('Created At') ?></td>
                                                <td style="border-bottom:1px solid #EAEAEA;font-size:12px;padding-left: 10px"><?= Yii::app()->dateFormatter->format("d-MMMM, y HH:mm:ss", strtotime($task->created_at)) ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td valign="top">
                            <?php $link = Yii::app()->createUrl('task/view', array('id' => $task->id)) ?>
                            <p style="font-size:12px; line-height:16px; margin:0;">
                                <?=
                                __('You can view and accomplish the task opening it via this link :link',
                                    array(':link' => "<a href='$link'>{$task->name}</a>"))?>
                            </p>
                            <br/>

                        </td>
                    </tr>

                    <tr>
                        <td bgcolor="#EAEAEA" align="center" style="background:#EAEAEA; text-align:center;">
                            <center>
                                <p style="font-size:12px; margin:0;">
                                    <?= __('Thank you again') ?>, <strong><?= $task->user->name ?></strong>
                                </p>
                            </center>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>