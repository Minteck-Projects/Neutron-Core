<article id="page-content">
    <div id="page-elements">
        <div id="page-content-inner">
            <span id="page-content-colorbar"></span>
            <h1><?= $MPCMSRendererPageNameValue == "index" ? file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename") : file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $MPCMSRendererPageNameValue . "/pagename") ?></h1>
            <?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $MPCMSRendererPageNameValue) ?>
        </div>
        <div id="page-content-widgets-desktop">
            <h3>Informations</h3>
            <?php require $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/components/widgets.php"; ?>
        </div>
        <div id="page-content-widgets-mobile" data-pushbar-id="widgets" data-pushbar-direction="right">
            <a class="mdc-list-item" onclick="pushbar.close();">
                <i class="material-icons-outlined mdc-list-item__graphic" aria-hidden="true">close</i>
                <span class="mdc-list-item__text"><?= $lang["viewer"]["close"] ?></span>
            </a>
            <hr class="mdc-list-divider">
            <h3>Informations</h3>
            <?php require $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/components/widgets.php"; ?>
        </div>
    </div>
</article>