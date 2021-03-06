<?php

if (isset($_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN']) && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != "." && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != ".." && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != "/") {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'])) {

    } else {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Jeton d'authentification invalide");
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
        }
    }
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Jeton d'authentification invalide");
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    } else {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    }
}

function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

$jsonraw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json");
if (isJson($jsonraw)) {
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
    } else {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Pas de nom");
    }
    if (isset($_POST['desc'])) {
        $desc = $_POST['desc'];
    } else {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Pas de description");
    }
    if (isset($_POST['link'])) {
        $link = $_POST['link'];
    } else {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Pas de lien");
    }
    if (isset($_POST['day'])) {
        $day = $_POST['day'];
    } else {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Pas de jour");
    }
    if (isset($_POST['month'])) {
        $month = $_POST['month'];
    } else {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Pas de mois");
    }
    if (isset($_POST['year'])) {
        $year = $_POST['year'];
    } else {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Pas d'année");
    }
    $date = strtotime($year . "-" . $month . "-" . $day);
    if (($month == "4" || $month == "6" || $month == "9" || $month == "11") && ($day == "31")) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Jour sélectionné invalide par rapport au mois sélectionné");
    }
    if (($month == "2") && ($day == "30" || $day == "31" || ((bool)date('L', strtotime("$year-01-01")) === false && $day == "29"))) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Jour sélectionné invalide par rapport au mois sélectionné");
    }
    if ((int)date('Y', $date) < (int)date('Y')) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Impossible de créer un événement dans le passé");
    }
    if (((int)date('m', $date) < (int)date('m')) && ((int)date('Y', $date) == (int)date('Y'))) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Impossible de créer un événement dans le passé");
    }
    if (((int)date('d', $date) < (int)date('d')) && ((int)date('m', $date) == (int)date('m'))) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Impossible de créer un événement dans le passé");
    }
    $name = str_replace('>', '&gt;', $name);
    $name = str_replace('<', '&lt;', $name);
    if (strlen($name) > 75) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le nom de l'événement est trop long. Si vous avez des informations à ajouter, ajoutez les dans la description");
    }
    if (trim($name) == "") {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le nom de l'événement ne peut pas être vide");
    }
    $desc = str_replace('>', '&gt;', $desc);
    $desc = str_replace('<', '&lt;', $desc);
    if ($day == "1") {
        $daystr = "1er";
    } else {
        $daystr = $day;
    }
    if ($month == "01") {
        $monthstr = "janv.";
    }
    if ($month == "02") {
        $monthstr = "févr.";
    }
    if ($month == "03") {
        $monthstr = "mars";
    }
    if ($month == "04") {
        $monthstr = "avr.";
    }
    if ($month == "05") {
        $monthstr = "mai";
    }
    if ($month == "06") {
        $monthstr = "juin";
    }
    if ($month == "07") {
        $monthstr = "juil.";
    }
    if ($month == "08") {
        $monthstr = "août";
    }
    if ($month == "09") {
        $monthstr = "sept.";
    }
    if ($month == "10") {
        $monthstr = "oct.";
    }
    if ($month == "11") {
        $monthstr = "nov.";
    }
    if ($month == "12") {
        $monthstr = "déc.";
    }
    $json = json_decode($jsonraw);
    foreach($json->events as $event) {
        if (isset($event->timestamp)) {
            if ($event->timestamp == $year . date('m', $date) . date('d', $date)) {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Un événement existe déjà ce jour là");
            }
        }
    }
    $pos = count($json->events);
    $json->events[$pos] = new stdClass();
    $json->events[$pos]->timestamp = $year . date('m', $date) . date('d', $date);
    $json->events[$pos]->name = $name;
    $json->events[$pos]->description = $desc;
    if (substr($link, 0, 4) == "http") {
        $json->events[$pos]->link = $link;
    } else {
        $json->events[$pos]->link = "http://" . $link;
    }
    $json->events[$pos]->datestr = $daystr . " " . $monthstr . " " . $year;
    $newjsonraw = json_encode($json, JSON_PRETTY_PRINT);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json", $newjsonraw);
    require $_SERVER['DOCUMENT_ROOT'] . "/api/admin/cache_content_reset.php";
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Impossible d'initialiser la base de données");
}