<?php

// require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("API pas prêt");

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

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - API/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
} else {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - API/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
}

if (isset($_POST['page'])) {
    $oldslug = $_POST['page'];
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
        if (isset($_POST['newname'])) {
            $newname = $_POST['newname'];
            $newname = str_replace('>', '&gt;', $newname);
            $newname = str_replace('<', '&lt;', $newname);
            if (trim($newname) == "") {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le nouveau nom ne peut pas être vide");
            }
            $newslug = preg_replace("/[^0-9a-zA-Z ]/m", "", $newname );
            $newslug = str_replace(" ", "-", $newslug);
            $newslug = strtolower($newslug);
            if ($newslug == "api" || $newslug == "cms-special" || $newslug == "galery" || $newslug == "vendor" || $newslug == "cms-unrelated" || $newslug == "data" || $newslug == "resources" || $newslug == "widgets" || $newslug == "-htaccess" || $newslug == "index" || $newslug == "index-php") {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Vous ne pouvez pas utiliser un nom réservé en interne par le logiciel");
            }
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $newslug)) {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Une page du même nom existe déjà");
            }
            if (strlen($newslug) > 70) {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Le nouveau nom de la page est trop long");
            }
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $newslug, file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $oldslug));
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagetypes/" . $newslug, file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagetypes/" . $oldslug));
            mkdir($_SERVER['DOCUMENT_ROOT'] . "/" . $newslug);
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $newslug . "/index.php", '<?php require_once $_SERVER[\'DOCUMENT_ROOT\'] . "/api/renderer/render.php"; render(\'' . $newslug . '\'); ?>');
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $newslug . "/pagename", $newname);
            unlink($_SERVER['DOCUMENT_ROOT'] . "/" . $oldslug . "/index.php");
            unlink($_SERVER['DOCUMENT_ROOT'] . "/" . $oldslug . "/pagename");
            rmdir($_SERVER['DOCUMENT_ROOT'] . "/" . $oldslug);
            unlink($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $oldslug);
            unlink($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagetypes/" . $oldslug);
            require_once $_SERVER['DOCUMENT_ROOT'] . "/api/admin/cache_pages_update.php";
            require $_SERVER['DOCUMENT_ROOT'] . "/api/admin/cache_content_reset.php";
            require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");
        } else {
            require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Aucun nouveau nom spécifié");
        }
    } else {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("La page n'existe pas");
    }
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Aucune page spécifiée");
}