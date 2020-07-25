<?php

$pageConfig = [ "domName" => "Tableau de bord", "headerName" => "Tableau de bord" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
<center>
    <a href="/cms-special/admin/home" class="mdc-button mdc-button--outlined">
        <div class="mdc-button__ripple"></div>
        <i class="material-icons-outlined mdc-button__icon" aria-hidden="true">arrow_back</i>
        <span class="mdc-button__label"><?= $lang["admin-home"]["items"][7] ?></span>
    </a>

    <h1><?= $lang["admin-home"]["data"]->greeting ?></h1>

    <div id="home-grid">
        <div class="home-grid-item">
            <a title="<?= $lang["admin-home"]["data"]->items[0] ?>" id="home-grid-item-data" href="/cms-special/admin/stats" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button home-grid-item-button">pie_chart</a>
            <br>
            <?= $lang["admin-home"]["data"]->items[0] ?>
        </div>
        <div class="home-grid-item">
            <a title="<?= $lang["admin-home"]["data"]->items[1] ?>" id="home-grid-item-data" href="/cms-special/admin/logs" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button home-grid-item-button">text_snippet</a>
            <br>
            <?= $lang["admin-home"]["data"]->items[1] ?>
        </div>
        <div class="home-grid-item">
            <a title="<?= $lang["admin-home"]["data"]->items[2] ?>" id="home-grid-item-data" href="/cms-special/admin/renderer" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button home-grid-item-button">device_hub</a>
            <br>
            <?= $lang["admin-home"]["data"]->items[2] ?>
        </div>
    </div>
</center>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>