<?php $pageConfig = [ "domName" => "Options avancées", "headerName" => "Options avancées" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
<center>
<?php

$version = explode("-", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version"))[0];
$json = json_decode(@file_get_contents(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/update") . "/" . $version . "/updates.json"));

if (isset($json)) {
    if (json_last_error() != JSON_ERROR_NONE) {
        $updates = -1;
        $uperr = $lang["admin-updates"]["errors"][0];
    }

    if ($json->version->name != $version) {
        $updates = -1;
        $uperr = $lang["admin-updates"]["errors"][1];
    }
    
    foreach ($json->updates as $update) {
        if (!isset($updates)) {
            $updates = 1;
        }
    }
    
    if (!isset($updates)) {
        $updates = 0;
    }
} else {
    $updates = -1;
    $uperr = $lang["admin-updates"]["errors"][2];
}

if ($updates == -1): ?>
    <i class="material-icons-outlined updates-status" aria-hidden="true">admin_panel_settings</i>
    <h2><?= $lang["admin-updates"]["status"][0] ?><small> (<?= $uperr ?>)</small></h2>
    <a href="/cms-special/admin/ota" class="mdc-button mdc-button--outlined">
        <div class="mdc-button__ripple"></div>
        <i class="material-icons-outlined mdc-button__icon" aria-hidden="true">sms_failed</i>
        <span class="mdc-button__label"><?= $lang["admin-updates"]["install"][0] ?></span>
    </a>
<?php endif; ?>
<?php if ($updates == 0): ?>
    <i class="material-icons-outlined updates-status" aria-hidden="true">verified_user</i>
    <h2><?= $lang["admin-updates"]["status"][2] ?></h2>
    <a href="/cms-special/admin/ota" class="mdc-button mdc-button--outlined">
        <div class="mdc-button__ripple"></div>
        <i class="material-icons-outlined mdc-button__icon" aria-hidden="true">archive</i>
        <span class="mdc-button__label"><?= $lang["admin-updates"]["install"][1] ?></span>
    </a>
<?php endif; ?>
<?php if ($updates == 1): ?>
    <i class="material-icons-outlined updates-status" aria-hidden="true">policy</i>
    <h2><?= $lang["admin-updates"]["status"][1] ?></h2>
    <a href="/cms-special/admin/ota" class="mdc-button mdc-button--outlined">
        <div class="mdc-button__ripple"></div>
        <i class="material-icons-outlined mdc-button__icon" aria-hidden="true">new_releases</i>
        <span class="mdc-button__label"><?= $lang["admin-updates"]["install"][2] ?></span>
    </a>
<?php endif; ?>
</center>
<hr class="separator">
<h2><?= $lang["admin-updates"]["logs"] ?></h2>
<?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/UPDATE.log")): ?>
    <pre class="update-logs" id="logs"><?= str_replace("\n", "<br>", str_replace("<", "&lt;", str_replace(">", "&gt;", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/UPDATE.log")))) ?></pre>
<?php else: ?>
    <p><i><?= $lang["admin-updates"]["nologs"] ?></i></p>
<?php endif; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>