<?php

$pageConfig = [ "domName" => "Tableau de bord", "headerName" => "Tableau de bord" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
<div style="text-align: center;">
    <a href="/cms-special/admin/home" class="mdc-button mdc-button--outlined">
        <div class="mdc-button__ripple"></div>
        <i class="material-icons-outlined mdc-button__icon" aria-hidden="true">arrow_back</i>
        <span class="mdc-button__label"><?= $lang["admin-home"]["items"][7] ?></span>
    </a>

    <h1><?= $lang["admin-home"]["appearance"]->greeting ?></h1>

    <div id="home-grid">
        <div class="home-grid-item">
            <a title="<?= $lang["admin-home"]["appearance"]->items[0] ?>" id="home-grid-item-appearance" href="/cms-special/admin/appearance" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button home-grid-item-button">tour</a>
            <br>
            <?= $lang["admin-home"]["appearance"]->items[0] ?>
        </div>
        <div class="home-grid-item">
            <a title="<?= $lang["admin-home"]["appearance"]->items[1] ?>" id="home-grid-item-appearance" href="/cms-special/admin/customization" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button home-grid-item-button">palette</a>
            <br>
            <?= $lang["admin-home"]["appearance"]->items[1] ?>
        </div>
        <div class="home-grid-item">
            <a title="<?= $lang["admin-home"]["appearance"]->items[2] ?>" id="home-grid-item-appearance" href="/cms-special/admin/css" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button home-grid-item-button">construction</a>
            <br>
            <?= $lang["admin-home"]["appearance"]->items[2] ?>
        </div>
        <div class="home-grid-item">
            <a title="<?= $lang["admin-home"]["appearance"]->items[3] ?>" id="home-grid-item-appearance" href="/cms-special/admin/language" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button home-grid-item-button">language</a>
            <br>
            <?= $lang["admin-home"]["appearance"]->items[3] ?>
        </div>
        <div class="home-grid-item">
            <a title="<?= $lang["admin-home"]["appearance"]->items[4] ?>" id="home-grid-item-appearance" href="/cms-special/admin/plugins" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button home-grid-item-button">extension</a>
            <br>
            <?= $lang["admin-home"]["appearance"]->items[4] ?>
        </div>
    </div>
</div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>