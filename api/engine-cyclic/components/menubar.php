<?php

if ((!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-old.mtd") || (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-full.mtd") && strpos(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-old.mtd"), "<a") === false)) || (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-full.mtd") || (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-full.mtd") && strpos(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-full.mtd"), "|") === false)) || (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-old.mtd") || (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist.mtd") && strpos(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist.mtd"), "|") === false))) {
    rlgps("Regenerating pages cache");
    require_once $_SERVER['DOCUMENT_ROOT'] . "/api/admin/cache_pages_update.php";
}

?>

<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <a href="/" id="menubar-home-link">
                <span id="menubar-logo"></span>
                <span class="mdc-top-app-bar__title title rsp-desktoponly"><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename") ?></span>
            </a>
        </section>
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
            <span class="rsp-desktoponly" id="menuitems">
                <?php
                rlgps("Loading pages from cache...");
            
                $preels = explode("\n", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist.mtd"));
                $els = [];
                foreach ($preels as $el) {
                    if (substr($el, 0, 1) != "@") {
                        $parts = explode("|", $el);
                        array_push($els, $parts);
                    }
                }

                ?>
                <?php rlgps("Generating menubar");foreach ($els as $el): ?>
                <?php if (trim($el[1]) != ""): ?>
                <a href="/<?= $el[0] ?>" class="mdc-button rsp-desktoponly">
                    <div class="mdc-button__ripple"></div>
                    <span class="mdc-button__label menubutton"><?= $el[1] ?></span>
                </a>
                <?php endif;endforeach; ?>
                <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures") && count(scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures")) > 2): ?>
                <a href="/cms-special/gallery" class="mdc-button rsp-desktoponly">
                    <div class="mdc-button__ripple"></div>
                    <span class="mdc-button__label menubutton"><?= $lang["viewer"]["gallery"] ?></span>
                </a>
                <?php endif ?>
            </span>
            <a href="/" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button">home</a>
            <button class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button" onclick="pushbar.open('navigation');">menu</button>
            <button class="material-icons-outlined mdc-top-app-bar__action-item mdc-icon-button rsp-mobileonly rsp-widgetbar" onclick="pushbar.open('widgets');">info</button>
        </section>
    </div>
</header>
