<?php

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist.mtd") || (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist.mtd") && strpos(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist.mtd"), "|") === false)) {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/api/admin/cache_pages_update.php";
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-full.mtd") || (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-full.mtd") && strpos(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-full.mtd"), "|") === false)) {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/api/admin/cache_pages_update.php";
}

?>

<aside class="mdc-drawer" data-pushbar-direction="left" data-pushbar-id="navigation">
    <div class="mdc-drawer__content">
        <nav class="mdc-list">
            <a class="mdc-list-item" onclick="pushbar.close();">
                <i class="material-icons-outlined mdc-list-item__graphic" aria-hidden="true">close</i>
                <span class="mdc-list-item__text"><?= $lang["viewer"]["close"] ?></span>
            </a>
            <hr class="mdc-list-divider">
            <a class="mdc-list-item <?= $_SERVER['PHP_SELF'] == "/index.php" ? " mdc-list-item--activated" : "" ?>" href="/" aria-current="page">
                <i class="material-icons-outlined mdc-list-item__graphic" aria-hidden="true">home</i>
                <span class="mdc-list-item__text"><?= $lang["viewer"]["home"] ?></span>
            </a>
            <?php
            
            $preels = explode("\n", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-full.mtd"));
            $els = [];
            foreach ($preels as $el) {
                if (substr($el, 0, 1) != "@") {
                    $parts = explode("|", $el);
                    array_push($els, $parts);
                }
            }
            
            ?>
            <?php foreach ($els as $el): ?>
            <a class="mdc-list-item" href="/<?= $el[0] ?>">
                <i class="material-icons-outlined mdc-list-item__graphic" aria-hidden="true">insert_drive_file</i>
                <span class="mdc-list-item__text"><?= $el[1] ?></span>
            </a>
            <?php endforeach ?>
            <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures") && count(scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures")) > 0): ?>
            <a class="mdc-list-item<?= $_SERVER['PHP_SELF'] == "/cms-special/galery/index.php" ? " mdc-list-item--activated" : "" ?>" href="/cms-special/gallery" aria-current="page">
                <i class="material-icons-outlined mdc-list-item__graphic" aria-hidden="true">image</i>
                <span class="mdc-list-item__text"><?= $lang["viewer"]["gallery"] ?></span>
            </a>
            <?php endif ?>
        </nav>
    </div>
</aside>
<div class="mdc-drawer-app-content">