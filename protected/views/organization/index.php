<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>
<?php $types = Organization::getTypesArray(false); ?>
<?php $organizations = Organization::getListByType(); ?>


<ol class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li>Organizations</li>
</ol>

<div class="page-header">
    <h3>
        <i class="fa fa-university"></i> Organizations
    </h3>
</div>

<ul class="nav nav-tabs" role="tablist">
    <?php foreach ($types as $type=> $label): ?>
    <li class="<?=$type == 'ministry' ? 'active' : ''?>"><a href="#organization_<?= $type?>"><?= $label?></a></li>
    <?php endforeach;?>
</ul>


<div class="tab-content" id="list_organizations">
    <?php foreach ($organizations as $type=> $data) { ?>
    <div class="tab-pane <?=$type == 'ministry' ? 'active' : ''?>" id="organization_<?=$type?>">
        <table class="table table-bordered table-responsible table-striped table-hover" style="border-top: none;">
            <thead>
            <th class="col_name">Name</th>
            <th class="col_active" style="width: 140px;">Active Periods</th>
            <th class="col_archive" style="width: 140px;">Archive Periods</th>
            </thead>
            <?php foreach ($data as $organization): ?>
            <tr>
                <td class="col_name hider">
                    <a href='/organization/view/<?=$organization['id']?>'><?=$organization['name']?></a>
                    <span class="action action_admin">
                        <a href="/organization/update/<?=$organization['id']?>">Edit</a>
                    </span>
                </td>
                <td class="col_archive"></td>
                <td class="col_active"></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php };?>
</div>


