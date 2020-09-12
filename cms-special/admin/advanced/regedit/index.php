<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/api/lang/processor.php"; ?>
<?php

if (isset($_COOKIE['_MPCMS_ADMIN_TOKEN']) && $_COOKIE['_MPCMS_ADMIN_TOKEN'] != "." && $_COOKIE['_MPCMS_ADMIN_TOKEN'] != ".." && $_COOKIE['_MPCMS_ADMIN_TOKEN'] != "/") {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['_MPCMS_ADMIN_TOKEN'])) {

    } else {
        die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/advanced/regedit&pa='</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/advanced/regedit&pa='</script>");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $lang["admin-advanced-regedit"]["win"] ?></title>
    <link rel="stylesheet" href="/resources/css/regedit.css">
</head>
<body>
    <h1><?= $lang["admin-advanced-regedit"]["title"] ?></h1>
    <h3>/</h3>
    <a href="/cms-special/admin/advanced/regedit"><small><?= $lang["admin-advanced-regedit"]["parent"] ?></small></a><br>
    <img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/keys.png"><a href="/cms-special/admin/advanced/regedit/view/?key=HKWC">HKEY_WEBSITE_CONTENT</a> <i>(<?= $lang["admin-advanced-regedit"]["content"] ?>)</i><br>
    <img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/keys.png"><a href="/cms-special/admin/advanced/regedit/view/?key=HKST">HKEY_SESSION_TOKENS</a> <i>(<?= $lang["admin-advanced-regedit"]["tokens"] ?>)</i><br>
    <img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/keys.png"><a href="/cms-special/admin/advanced/regedit/view/?key=HKUR">HKEY_UPLOADS_ROOT</a> <i>(<?= $lang["admin-advanced-regedit"]["upload"] ?>)</i>
</body>
</html>