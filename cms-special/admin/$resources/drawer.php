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
        Minteck Projects CMS <?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version") ?></h6>
    </div>
    <div class="mdc-drawer__content">
        <nav class="mdc-list">
            <a class="mdc-list-item <?php if ($path == "/cms-special/admin/home") { echo("mdc-list-item--activated"); } ?>" href="/cms-special/admin/home" aria-current="page">
                <i class="material-icons mdc-list-item__graphic" aria-hidden="true">home</i>
                <span class="mdc-list-item__text">Tableau de bord</span>
            </a>

            <hr class="mdc-list-divider">
            <h6 class="mdc-list-group__subheader">Contenu</h6>
            <?= renderItem("/cms-special/admin/pages", "insert_drive_file", "Pages") ?>
            <?= renderItem("/cms-special/admin/galery", "insert_photo", "Galerie de photos") ?>
            <?= renderItem("/cms-special/admin/calendar", "calendar_today", "Calendrier") ?>

            <hr class="mdc-list-divider">
            <h6 class="mdc-list-group__subheader">Extensions</h6>
            <?= renderItem("/cms-special/admin/store", "store", "CMS Store") ?>
            <?= renderItem("/cms-special/admin/plugins", "extension", "Option des extensions") ?>

            <hr class="mdc-list-divider">
            <h6 class="mdc-list-group__subheader">Tâches récurrentes</h6>
            <?= renderItem("/cms-special/admin/advanced", "settings", "Options avancées") ?>
            <?= renderItem("/cms-special/admin/housekeeping", "autorenew", "Maintenance") ?>
            <?= renderItem("/cms-special/admin/updates", "info", "Mise à jour et sécurité") ?>

            <hr class="mdc-list-divider">
            <h6 class="mdc-list-group__subheader">Visuel et comportement</h6>
            <?= renderItem("/cms-special/admin/appearance", "web", "Apparence") ?>
            <?= renderItem("/cms-special/admin/customization", "format_paint", "Personnalisation") ?>
            <?= renderItem("/cms-special/admin/logs", "short_text", "Historique d'activité") ?>

            <hr class="mdc-list-divider">
            <h6 class="mdc-list-group__subheader">Données et optimisation</h6>
            <?= renderItem("/cms-special/admin/semantic", "adjust", "CMS Sémantique") ?>
            <?= renderItem("/cms-special/admin/stats", "insert_chart", "Statistiques") ?>

            <hr class="mdc-list-divider">
            <h6 class="mdc-list-group__subheader">Accès rapide</h6>
            <?= renderItem("/cms-special/admin/logout", "exit_to_app", "Déconnexion") ?>
            <?= renderItem("/?source=admin", "power", "Retourner au site", true) ?>

            <h6 class="mdc-drawer__subtitle">
                <center>
                    propulsé par Minteck Projects CMS<br>
                    © 2019-<?= date('Y') ?> Minteck Projects Ltd.<br><br>
                    Minteck Projects CMS est distribué sous licence <a href="https://www.gnu.org/licenses/gpl-3.0.fr.html" target="_blank">GNU GPL3</a> ou version ultérieure. Tout travail dérivé doit aussi être distribué sous cette licence.
                </center>
            </h6>
        </nav>
    </div>
</aside>