<?php

function renderItem(string $page, string $icon, string $name, $refresh = false) {
    global $path;
    $returnp = '<a class="mdc-list-item ';
    if ($path == $page) {
        $returnp = $returnp . "mdc-list-item--activated";
    }
    $returnp = $returnp . '" ';
    if ($refresh) {
        $returnp = $returnp . 'target="_blank" ';
    }
    $returnp = $returnp . 'href="' . $page . '">';
    $returnp = $returnp . '<i class="material-icons mdc-list-item__graphic" aria-hidden="true">' . $icon . '</i><span class="mdc-list-item__text">' . $name . '</span></a>';
    return $returnp;
}

?>

<script type="text/javascript">
    var pushbar = new Pushbar({
        blur: true,
        overlay: true,
    });
</script>
<aside class="mdc-drawer pushbar from_left" data-pushbar-id="drawer">
    <div class="mdc-drawer__header">
        <h3 class="mdc-drawer__title"><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename") ?></h3>
        <h6 class="mdc-drawer__subtitle"><?= $sizestr ?><br>
        version <?= str_replace("#", substr(md5(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")), 0, 2), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")) ?> "<?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/codename") ?>"
            <?php

            if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/experimental")) == "1") {
                echo("<br><br>" . $lang["admin-drawer-footer"]["experimental"]);
            }

            ?>
        </h6>
    </div>
    <div class="mdc-drawer__content">
        <nav class="mdc-list">
            <a class="mdc-list-item <?php if ($path == "/cms-special/admin/home") { echo("mdc-list-item--activated"); } ?>" href="/cms-special/admin/home" aria-current="page">
                <i class="material-icons mdc-list-item__graphic" aria-hidden="true">home</i>
                <span class="mdc-list-item__text"><?= $lang["admin-drawer-items"]["home"] ?></span>
            </a>
            <a class="mdc-list-item <?php if ($path == "/cms-special/admin/distrib") { echo("mdc-list-item--activated"); } ?>" href="/cms-special/admin/distrib" aria-current="page">
                <i class="material-icons mdc-list-item__graphic" aria-hidden="true">publish</i>
                <span class="mdc-list-item__text"><?= $lang["admin-drawer-items"]["distrib"] ?></span>
            </a>

            <hr class="mdc-list-divider">
            <h6 class="mdc-list-group__subheader"><?= $lang["admin-drawer-categories"]["content"] ?></h6>
            <?= renderItem("/cms-special/admin/pages", "insert_drive_file", $lang["admin-drawer-items"]["pages"]) ?>
            <?= renderItem("/cms-special/admin/galery", "insert_photo", $lang["admin-drawer-items"]["gallery"]) ?>
            <?= renderItem("/cms-special/admin/calendar", "calendar_today", $lang["admin-drawer-items"]["calendar"]) ?>

            <hr class="mdc-list-divider">
            <h6 class="mdc-list-group__subheader"><?= $lang["admin-drawer-categories"]["plugins"] ?></h6>
            <?= renderItem("http://" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/store_public"), "store", $lang["admin-drawer-items"]["store"], true) ?>
            <?= renderItem("/cms-special/admin/plugins", "extension", $lang["admin-drawer-items"]["plugins"]) ?>

            <hr class="mdc-list-divider">
            <h6 class="mdc-list-group__subheader"><?= $lang["admin-drawer-categories"]["repetitive"] ?></h6>
            <?= renderItem("/cms-special/admin/advanced", "settings", $lang["admin-drawer-items"]["advanced"]) ?>
            <?= renderItem("/cms-special/admin/housekeeping", "autorenew", $lang["admin-drawer-items"]["housekeeping"]) ?>
            <!-- <?= renderItem("/cms-special/admin/updates", "info", $lang["admin-drawer-items"]["updates"]) ?> -->
            <?= renderItem("/cms-special/admin/about", "info", $lang["admin-drawer-items"]["about"]) ?>

            <hr class="mdc-list-divider">
            <h6 class="mdc-list-group__subheader"><?= $lang["admin-drawer-categories"]["look-feel"] ?></h6>
            <?= renderItem("/cms-special/admin/appearance", "web", $lang["admin-drawer-items"]["appearance"]) ?>
            <?= renderItem("/cms-special/admin/customization", "format_paint", $lang["admin-drawer-items"]["customize"]) ?>
            <?= renderItem("/cms-special/admin/css", "style", $lang["admin-drawer-items"]["css"]) ?>
            <?= renderItem("/cms-special/admin/language", "translate", $lang["admin-drawer-items"]["language"]) ?>

            <hr class="mdc-list-divider">
            <h6 class="mdc-list-group__subheader"><?= $lang["admin-drawer-categories"]["data-opti"] ?></h6>
            <?= renderItem("/cms-special/admin/semantic", "adjust", $lang["admin-drawer-items"]["semantic"]) ?>
            <?= renderItem("/cms-special/admin/stats", "insert_chart", $lang["admin-drawer-items"]["stats"]) ?>
            <?= renderItem("/cms-special/admin/logs", "short_text", $lang["admin-drawer-items"]["logs"]) ?>

            <hr class="mdc-list-divider">
            <h6 class="mdc-list-group__subheader"><?= $lang["admin-drawer-categories"]["easy"] ?></h6>
            <?= renderItem("/cms-special/admin/logout", "exit_to_app", $lang["admin-drawer-items"]["logout"]) ?>
            <?= renderItem("/?source=admin", "power", $lang["admin-drawer-items"]["back"], true) ?>

            <h6 class="mdc-drawer__subtitle">
                <center>
                    <?= $lang["admin-drawer-footer"]["powered"] ?><br>
                    © 2019-<?= date('Y') ?> Minteck Projects Ltd.<br><br>
                    <?= $lang["admin-drawer-footer"]["license"][0] ?><a href="https://www.gnu.org/licenses/gpl-3.0.fr.html" target="_blank">GNU GPL3</a><?= $lang["admin-drawer-footer"]["license"][1] ?>
                </center>
            </h6>
        </nav>
    </div>
</aside>
