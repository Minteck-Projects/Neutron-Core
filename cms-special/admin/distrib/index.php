<?php $pageConfig = [ "domName" => "Distribution", "headerName" => "Distribution" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
<div style="text-align: center;"><h2 style="font-weight:normal;">
    <?= $lang["admin-distrib"]["intro"] ?><b>
    <?php
    
    $distro = explode("-", trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")))[count(explode("-", trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")))) - 1];
    
    if (isset($lang["admin-distrib"]["defaultDistros"]->$distro)) {
        echo($lang["admin-distrib"]["defaultDistros"]->$distro);
    } else {
        echo("<code>" . $distro . "</code>");
    }

    ?></b></h2>
    <p>
        <?= str_replace("]]", "</a>", str_replace("[[", "<a target=\"_blank\" href=\"" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/public") . "\">", $lang["admin-distrib"]["change"])) ?>
    </p>
</div>