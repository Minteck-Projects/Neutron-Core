<?php $pageConfig = [ "domName" => "Maintenance", "headerName" => "Maintenance" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <h1><center><?= $lang["admin-css"]["intro"][0] ?><br><?= $lang["admin-css"]["intro"][1] ?></center></h1>
        <br><p><?= $lang["admin-css"]["intromsg"][0] ?></p>
        <p><b><?= $lang["admin-css"]["intromsg"][1] ?></b> <?= $lang["admin-css"]["intromsg"][2] ?></p>
        <center><p><a href="/cms-special/admin/css/studio" class="button"><?= $lang["admin-css"]["start"] ?></a></p></center>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>