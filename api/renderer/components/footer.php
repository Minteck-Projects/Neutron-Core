<div id="footer-container"><?php rlgps("Generating footer"); ?>
    <span id="page-footer-colorbar"></span>
    <footer id="page-footer">
        <div id="page-footer-title">
            <div id="page-footer-title-inner" class="title"><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename") ?></div>
            <div id="page-footer-title-buttons">
                <a id="page-footer-title-top-button" onclick="$('html, body').animate({scrollTop:0},'20');"><button class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button" id="page-footer-title-top-button-inner" onclick="$('html, body').animate({scrollTop:0},'20');">arrow_upward</button></a>
                <a href="/cms-special/admin" id="page-footer-title-settings-button"><button class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button" id="page-footer-title-settings-button-inner">settings</button></a>
            </div>
        </div>
        <div id="page-footer-content">
            <?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/footer") ?>
        </div>
        <div id="page-footer-links">
            <a href="<?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/public") ?>" target="_blank">Minteck Projects CMS <?= str_replace("#", substr(md5(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")), 0, 2), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")) ?></a> · <a href="<?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/bugs") ?>" target="_blank"><?= $lang["viewer"]["bugs"] ?></a> · <a href="/cms-special/version"><?= $lang["viewer"]["system"] ?></a>
        </div>
    </footer>
</div>