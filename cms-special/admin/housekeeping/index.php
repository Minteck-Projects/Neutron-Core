<?php $pageConfig = [ "domName" => "Maintenance", "headerName" => "Maintenance" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <p><center><a href="/cms-special/admin/housekeeping/reset" title="<?= $lang["admin-housekeeping"]["resetph"] ?>" class="sblink"><?= $lang["admin-housekeeping"]["reset"] ?></a></center></p>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>