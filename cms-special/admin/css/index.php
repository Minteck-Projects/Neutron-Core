<?php $pageConfig = [ "domName" => "Maintenance", "headerName" => "Maintenance" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <h1><div style="text-align: center;"><?= $lang["admin-css"]["intro"][0] ?><br><?= $lang["admin-css"]["intro"][1] ?></div></h1>
        <br><p><?= $lang["admin-css"]["intromsg"][0] ?></p>
        <p><b><?= $lang["admin-css"]["intromsg"][1] ?></b> <?= $lang["admin-css"]["intromsg"][2] ?></p>
        <div style="text-align: center;"><p><a href="/cms-special/admin/css/studio" class="button"><?= $lang["admin-css"]["start"] ?></a></p></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>