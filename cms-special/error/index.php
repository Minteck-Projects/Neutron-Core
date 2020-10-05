<?php ob_start();echo("<!--\n\n" . str_replace('%year%', date('Y'), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/license")) . "\n\n-->") ?>
<?php

function rlgps() {}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    $ready = true;
} else {
    $ready = false;
    header("Location: /cms-special/setup");
    die();
}

if ($ready) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/lang/processor.php";
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
        if (isset($_GET['id'])) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - INTERFACE/HTTP-ERROR - " . $_GET['id'] . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - INTERFACE/HTTP-ERROR - Unknown \n\n");
        }
    } else {
        if (isset($_GET['id'])) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - INTERFACE/HTTP-ERROR - " . $_GET['id'] . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - INTERFACE/HTTP-ERROR - Unknown \n\n");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/resources/css/error.css">
    <link rel="stylesheet" href="/resources/css/fonts-import.css">
    <link rel="stylesheet" href="/resources/css/ui.css">
    <title><?php
    
    if ($ready) {
        echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
    } else {
        echo("Minteck Projects CMS");
    }

    ?></title>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/header.php" ?>
</head>
<body mpcms-error-body>
    <div class="centered discover">
        <h2><?= $lang["error"]["title"] ?></h2>
        <p><?= $lang["error"]["message"][0] ?></p>
        <p><?= $lang["error"]["message"][1] ?></p>
        <p><b><?php
        
        if (isset($_GET['id'])) {
            echo($lang["error"]["code"] . " " . $_GET['id']);
        } else {
            echo($lang["error"]["other"]);
        }

        ?></b></p>
        <a class="button" href="/"><?= $lang["error"]["direction"] ?></a>
    </div>
</body>
</html>