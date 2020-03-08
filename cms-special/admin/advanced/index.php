<?php $pageConfig = [ "domName" => "Options avancées", "headerName" => "Options avancées" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <ul>
            <li>
                <a href="/cms-special/admin/advanced/jsonconf" title="<?= $lang["admin-advanced-home"]["placeholders"]->dev ?>" class="sblink"><?= $lang["admin-advanced-home"]["dev"] ?></a>
            </li>
            <li>
                <a href="/cms-special/admin/advanced/regedit" title="<?= $lang["admin-advanced-home"]["placeholders"]->regedit ?>" class="sblink"><?= $lang["admin-advanced-home"]["regedit"] ?></a>
            </li>
        </ul>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>