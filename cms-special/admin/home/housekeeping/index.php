<?php

$pageConfig = [ "domName" => "Tableau de bord", "headerName" => "Tableau de bord" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
<div style="text-align: center;">
    <a href="/cms-special/admin/home" class="mdc-button mdc-button--outlined">
        <div class="mdc-button__ripple"></div>
        <i class="material-icons-outlined mdc-button__icon" aria-hidden="true">arrow_back</i>
        <span class="mdc-button__label"><?= $lang["admin-home"]["items"][7] ?></span>
    </a>

    <h1><?= $lang["admin-home"]["housekeeping"]->greeting ?></h1>

    <div id="home-grid">
        <div class="home-grid-item">
            <a title="<?= $lang["admin-home"]["housekeeping"]->items[0] ?>" id="home-grid-item-housekeeping" href="/cms-special/admin/reset" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button home-grid-item-button">restore</a>
            <br>
            <?= $lang["admin-home"]["housekeeping"]->items[0] ?>
        </div>
        <div class="home-grid-item">
            <a title="<?= $lang["admin-home"]["housekeeping"]->items[1] ?>" id="home-grid-item-housekeeping" href="/cms-special/admin/about" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button home-grid-item-button">info</a>
            <br>
            <?= $lang["admin-home"]["housekeeping"]->items[1] ?>
        </div>
        <div class="home-grid-item">
            <a title="<?= $lang["admin-home"]["housekeeping"]->items[2] ?>" id="home-grid-item-housekeeping" href="/cms-special/admin/updates" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button home-grid-item-button">system_update_alt</a>
            <br>
            <?= $lang["admin-home"]["housekeeping"]->items[2] ?>
        </div>
    </div>
</div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>