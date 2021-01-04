<article id="page-content">
    <div id="page-elements">
        <div id="page-content-inner">
            <span id="page-content-colorbar"></span>
            <h1><?= getPageName() ?></h1>
            <?= getPageContent() ?>
        </div>
        <div id="page-content-widgets-desktop"><?php rlgps("Generating desktop widgets..."); ?>
            <h3><?= $lang["menu"]["info"] ?></h3>
            <?php require $_SERVER['DOCUMENT_ROOT'] . "/api/engine-cyclic/components/widgets.php"; ?>
        </div>
        <div id="page-content-widgets-mobile" data-pushbar-id="widgets" data-pushbar-direction="right"><?php rlgps("Generating mobile widgets..."); ?>
            <span class="mdc-list-item" onclick="pushbar.close();">
                <i class="material-icons-outlined mdc-list-item__graphic" aria-hidden="true">close</i>
                <span class="mdc-list-item__text"><?= $lang["viewer"]["close"] ?></span>
            </span>
            <hr class="mdc-list-divider">
            <h3><?= $lang["menu"]["info"] ?></h3>
            <?php require $_SERVER['DOCUMENT_ROOT'] . "/api/engine-cyclic/components/widgets.php"; ?>
        </div>
    </div>
</article>
