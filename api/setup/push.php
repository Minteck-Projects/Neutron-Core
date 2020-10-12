<?php

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/upload")) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/resources/upload");
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("La configuration du site Web à déjà été effectuée, vous devez le réinitialiser pour relancer la configurer");
}

if (isset($_POST['sitename'])) {
    if (trim($_POST['sitename']) == "") {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le nom du site ne peut pas être vide");
    }
    if (strpos($_POST['sitename'], '<') !== false || strpos($_POST['sitename'], '>') !== false || strpos($_POST['sitename'], '{') !== false || strpos($_POST['sitename'], '}') !== false || strpos($_POST['sitename'], '@') !== false || strpos($_POST['sitename'], '#') !== false || strpos($_POST['sitename'], '|') !== false) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le nom du site contient des caractères invalides");
    }
    if (strlen($_POST['sitename']) > 75) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le nom du site est trop long");
    }
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Aucun nom n'a été spécifié pour le site");
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/i18n/" . $_POST['language'])) {
    $lang = $_POST['language'];
} else {
    $lang = "fr";
}

if (isset($_FILES['file'])) {
    if ($_FILES['file']['error'] == 1) {
        $maxsize = ini_get('upload_max_filesize');
        if ($maxsize > 1000) {
            if ($maxsize > 1000000) {
                $maxsizestr = round($maxsize / 1000000, 2) . " Mio";
            } else {
                $maxsizestr = round($maxsize / 1000, 2) . " Kio";
            }
        } else {
            $maxsizestr = $maxsize . " octets";
        }
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("La taille du fichier d'îcone dépasse la taille maximale imposée par le serveur ({$maxsizestr})");
    }
    if ($_FILES['file']['error'] == 2) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("La taille maximale du fichier de formulaire à été dépassée");
    }
    if ($_FILES['file']['error'] == 3) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le fichier d'îcone est incomplet (n'a pas été transmis entièrement)");
    }
    if ($_FILES['file']['error'] == 4) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le fichier est renseigné au serveur, mais il n'a pas été transmis");
    }
    if ($_FILES['file']['error'] == 6) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Aucun dossier temporaire présent sur le serveur");
    }
    if ($_FILES['file']['error'] == 7) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Impossible d'écrire sur le disque");
    }
    if ($_FILES['file']['error'] == 8) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Un autre programme à interrompu la transmission du fichier");
    }
    if ($_FILES['file']['type'] != "image/png" && $_FILES['file']['type'] != "image/jpeg" && $_FILES['file']['type'] != "image/gif") {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Ce type de fichier n'est pas supporté");
    }
    if ($_FILES['file']['error'] == 0) {
        imagepng(imagecreatefromstring(file_get_contents($_FILES['file']['tmp_name'])), $_SERVER['DOCUMENT_ROOT'] . "/resources/upload/siteicon.png");
        unlink($_FILES['file']['tmp_name']);
    }
} else {
    copy($_SERVER['DOCUMENT_ROOT'] . "/resources/image/siteicon.png", $_SERVER['DOCUMENT_ROOT'] . "/resources/upload/siteicon.png");
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent");
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages")) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages");
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagetypes")) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagetypes");
}

$password = password_hash("MPCMS-usr-motdepasse", PASSWORD_BCRYPT, ['cost' => 12,]);

file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/index", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/setup/defaultHomepage.html"));
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagetypes/index", "0");
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/lang", $lang);
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/footer", "Copyright © Votre nom ici<br>Tous droits réservés");
$sitename = str_replace('>', '&gt;', $_POST['sitename']);
$sitename = str_replace('<', '&lt;', $sitename);
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename", $sitename);
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json", "{\"list\": [\"test\"],\"settings\": {\"test\": {\"sampleSetting\": \"This is a sample setting\"}}}");
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json", "{\"events\":[{}]}");
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/password", $password);
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - SETUP/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
} else {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - SETUP/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
}

require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");