<?php

header("Content-Type: application/json");
$data = array();

if (isset($_COOKIE['ADMIN_TOKEN']) && $_COOKIE['ADMIN_TOKEN'] != "." && $_COOKIE['ADMIN_TOKEN'] != ".." && $_COOKIE['ADMIN_TOKEN'] != "/") {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {} else {
        die("\"Invalid token\"");
    }
} else {
    die("\"Invalid token\"");
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    die("\"Website not installed\"");
}

if (filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") > 1048576) {
    array_push($data, [
        "code" => "DISKSPACE_LOGJUNK",
        "size" => filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log"),
        "message" => "Le fichier journal du site prend plus de 1 Mio d'espace disque"
    ]);
}

$size = 0;
foreach (scandir($_SERVER['DOCUMENT_ROOT'] . "/resources/upload") as $file) {
    if ($file != "." && $file != ".." && $file != ".gitkeep") {
        $size = filesize($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/" . $file);
    }
}
if ($size > 52428800) {
    array_push($data, [
        "code" => "DISKSPACE_UPLOAD",
        "size" => $size,
        "message" => "Les fichiers importés prennenent plus de 50 Mio d'espace disque"
    ]);
}

$size = 0;
foreach (scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages") as $file) {
    if ($file != "." && $file != ".." && $file != ".gitkeep") {
        $size = filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $file);
    }
}
if ($size > 5242880) {
    array_push($data, [
        "code" => "DISKSPACE_PAGES",
        "size" => $size,
        "message" => "Le contenu des pages du site prend plus de 5 Mio d'espace disque"
    ]);
}

$size = 0;
foreach (scandir($_SERVER['DOCUMENT_ROOT'] . "/widgets") as $file) {
    if ($file != "." && $file != ".." && $file != ".gitkeep") {
        $size = filesize($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $file . "/source.php");
    }
}
if ($size > 1048576) {
    array_push($data, [
        "code" => "DISKSPACE_WIDGETS",
        "size" => $size,
        "message" => "Les extesions installées prennent plus de 1 Mio d'espace disque"
    ]);
}

die(json_encode($data, JSON_PRETTY_PRINT));
