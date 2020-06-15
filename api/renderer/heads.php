<!DOCTYPE html>
<html lang="<?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/lang"); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
    
    if ($MPCMSRendererPageNameValue == "index") {
        echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
    } else {
        echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $eee . "/pagename") . " · " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
    }
    
    ?></title>
    <link href="<?= $_MD_INCLUDES ?>/material-components-web.min.css" rel="stylesheet">
    <script src="<?= $_MD_INCLUDES ?>/material-components-web.min.js"></script>
    <link rel="stylesheet" href="<?= $_MDI_PATH ?>">
    <link rel="stylesheet" href="/resources/css/polymer/fonts.css">
    <link rel="stylesheet" href="/resources/css/themes/blue-light.css">
    <link rel="stylesheet" href="/resources/css/polymer/menubar.css">
    <link rel="stylesheet" href="/resources/css/polymer/content.css">
    <link rel="shortcut icon" href="/resources/upload/siteicon<?= file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/siteicon-uncomp.png") ? "-uncomp" : "" ?>.png" type="image/png">
    <link rel="stylesheet" href="/resources/css/polymer/responsive.css">
    <link rel="stylesheet" href="/resources/css/polymer/warnings.css">
    <link rel="stylesheet" href="/resources/lib/pushbar.js/library.css">
    <script src="/resources/lib/pushbar.js/library.js"></script>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/headers/documenthead.php"; ?>
</head>
<body>
<script src="/resources/js/home.js"></script>
<script>
    pushbar = new Pushbar({
        blur: true,
        overlay: true
    });
</script>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/headers/documentbody.php"; ?>