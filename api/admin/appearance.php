<?php

if (isset($_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN']) && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != "." && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != ".." && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != "/") {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'])) {
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
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Aucun nom n'a été reçu");
}

if (isset($_POST['alwaysmenu'])) {
    (string)$am = $_POST['alwaysmenu'];
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Pas d'AlwaysMenu passé");
}

if (isset($_POST['oldrenderer'])) {
    (string)$or = $_POST['oldrenderer'];
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Pas d'OldRenderer passé");
}

if (isset($_POST['showpages'])) {
    (integer)$sp = $_POST['showpages'];
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Pas de ShowPages passé");
}

if ($am == "true") {
    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/alwaysmenu")) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/alwaysmenu", "");
    }
} else {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/alwaysmenu")) {
        unlink($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/alwaysmenu");
    }
}
// var_dump($or);require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit();
if ($or == "true") {
    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/oldRenderer")) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/oldRenderer", "");
    }
} else {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/oldRenderer")) {
        unlink($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/oldRenderer");
    }
}

file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagesInMenuBar", $sp);

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - API/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
} else {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - API/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
}

if (isset($_FILES['icon'])) {
    if ($_FILES['icon']['error'] == 1) {
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
    if ($_FILES['icon']['error'] == 2) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("La taille maximale du fichier de formulaire à été dépassée");
    }
    if ($_FILES['icon']['error'] == 3) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le fichier d'îcone est incomplet (n'a pas été transmis entièrement)");
    }
    if ($_FILES['icon']['error'] == 4) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le fichier d'îcone est renseigné au serveur, mais il n'a pas été transmis");
    }
    if ($_FILES['icon']['error'] == 6) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Aucun dossier temporaire présent sur le serveur");
    }
    if ($_FILES['icon']['error'] == 7) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Impossible d'écrire sur le disque");
    }
    if ($_FILES['icon']['error'] == 8) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Un autre programme à interrompu la transmission du fichier");
    }
    if ($_FILES['icon']['type'] != "image/png" && $_FILES['icon']['type'] != "image/jpeg" && $_FILES['icon']['type'] != "image/gif") {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le type de fichier du fichier îcone n'est pas supporté");
    }
    if ($_FILES['icon']['error'] == 0) {
        imagepng(imagecreatefromstring(file_get_contents($_FILES['icon']['tmp_name'])), $_SERVER['DOCUMENT_ROOT'] . "/resources/upload/siteicon.png");
        if ($_FILES['icon']['type'] == "image/png") {
            copy($_FILES['icon']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . "/resources/upload/siteicon-uncomp.png");
        } else {
            copy($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/siteicon.png", $_SERVER['DOCUMENT_ROOT'] . "/resources/upload/siteicon-uncomp.png");
        }
        require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/components/favicon.php";
        unlink($_FILES['icon']['tmp_name']);
    }
}

if (isset($_FILES['banner'])) {
    if ($_FILES['banner']['error'] == 1) {
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
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("La taille du fichier de bannière dépasse la taille maximale imposée par le serveur ({$maxsizestr})");
    }
    if ($_FILES['banner']['error'] == 2) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("La taille maximale du fichier de formulaire à été dépassée");
    }
    if ($_FILES['banner']['error'] == 3) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le fichier de bannière est incomplet (n'a pas été transmis entièrement)");
    }
    if ($_FILES['banner']['error'] == 4) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le fichier de bannière est renseigné au serveur, mais il n'a pas été transmis");
    }
    if ($_FILES['banner']['error'] == 6) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Aucun dossier temporaire présent sur le serveur");
    }
    if ($_FILES['banner']['error'] == 7) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Impossible d'écrire sur le disque");
    }
    if ($_FILES['banner']['error'] == 8) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Un autre programme à interrompu la transmission du fichier");
    }
    if ($_FILES['banner']['type'] != "image/png" && $_FILES['banner']['type'] != "image/jpeg" && $_FILES['banner']['type'] != "image/gif") {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le type de fichier du fichier de bannière n'est pas supporté");
    }
    if ($_FILES['banner']['error'] == 0) {
        imagejpeg(imagecreatefromstring(file_get_contents($_FILES['banner']['tmp_name'])), $_SERVER['DOCUMENT_ROOT'] . "/resources/upload/banner.jpg");
        $img = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/banner.jpg");
        $width = imagesx($img);
        $height = imagesy($img);
        $x_step = intval($width/$num_samples);
        $y_step = intval($height/$num_samples);
        $total_lum = 0;
        $sample_no = 1;
        for ($x=0; $x<$width; $x+=$x_step) {
            for ($y=0; $y<$height; $y+=$y_step) {
                $rgb = imagecolorat($img, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                $lum = ($r+$r+$b+$g+$g+$g)/6;
                $total_lum += $lum;
                $sample_no++;
            }
        }
        $avg_lum  = $total_lum / $sample_no;
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/banner.mtd", ($avg_lum / 255) * 100);
        unlink($_FILES['banner']['tmp_name']);
    }
}

$sitename = str_replace('>', '&gt;', $_POST['sitename']);
$sitename = str_replace('<', '&lt;', $sitename);
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename", $sitename);
require $_SERVER['DOCUMENT_ROOT'] . "/api/admin/cache_content_reset.php";
echo("ok");
} else {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    } else {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    }
}
} else {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    } else {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    }
}