<?php

$pageConfig = [ "domName" => "Tableau de bord", "headerName" => "Tableau de bord" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
<center>
    <a title="<?= $lang["admin-home"]["language"] ?>/Switch Language" href="/cms-special/admin/language" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button" id="language-selector">translate</a>

    <h1><?= $lang["admin-home"]["greeting"] ?></h1>

    <div id="home-grid">
        <div class="home-grid-item">
            <a title="<?= $lang["admin-home"]["items"][0] ?>" id="home-grid-item-pages" href="/cms-special/admin/pages" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button home-grid-item-button">layers</a>
            <br>
            <?= $lang["admin-home"]["items"][0] ?>
        </div>
        <div class="home-grid-item">
            <a title="<?= $lang["admin-home"]["items"][1] ?>" id="home-grid-item-calendar" href="/cms-special/admin/calendar" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button home-grid-item-button">event_note</a><br>
            <?= $lang["admin-home"]["items"][1] ?>
        </div>
        <div class="home-grid-item">
            <a title="<?= $lang["admin-home"]["items"][2] ?>" id="home-grid-item-gallery" href="/cms-special/admin/gallery" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button home-grid-item-button">photo</a><br>
            <?= $lang["admin-home"]["items"][2] ?>
        </div>
        <div class="home-grid-item">
            <a title="<?= $lang["admin-home"]["items"][3] ?>" id="home-grid-item-appearance" href="/cms-special/admin/home/appearance" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button home-grid-item-button">brush</a><br>
            <?= $lang["admin-home"]["items"][3] ?>
        </div>
        <div class="home-grid-item">
            <a title="<?= $lang["admin-home"]["items"][4] ?>" id="home-grid-item-data" href="/cms-special/admin/home/data" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button home-grid-item-button">dns</a><br>
            <?= $lang["admin-home"]["items"][4] ?>
        </div>
        <div class="home-grid-item">
            <a title="<?= $lang["admin-home"]["items"][5] ?>" id="home-grid-item-housekeeping" href="/cms-special/admin/home/housekeeping" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button home-grid-item-button">cleaning_services</a><br>
            <?= $lang["admin-home"]["items"][5] ?>
        </div>
    </div>
    
    <br>
    
    <a onclick="document.getElementsByTagName('spotlight-bar')[0].show()" class="mdc-button mdc-button--outlined">
        <div class="mdc-button__ripple"></div>
        <i class="material-icons-outlined mdc-button__icon" aria-hidden="true">settings</i>
        <span class="mdc-button__label"><?= $lang["admin-home"]["items"][6] ?></span>
    </a>
    &nbsp;
    <a href="/cms-special/admin/logout" class="mdc-button mdc-button--outlined">
        <div class="mdc-button__ripple"></div>
        <i class="material-icons-outlined mdc-button__icon" aria-hidden="true">power_settings_new</i>
        <span class="mdc-button__label"><?= $lang["admin-home"]["items"][8] ?></span>
    </a>
    &nbsp;
    <a href="/?source=admin" target="_blank" class="mdc-button mdc-button--outlined">
        <div class="mdc-button__ripple"></div>
        <i class="material-icons-outlined mdc-button__icon" aria-hidden="true">public</i>
        <span class="mdc-button__label"><?= $lang["admin-home"]["items"][9] ?></span>
    </a>
</center>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>
