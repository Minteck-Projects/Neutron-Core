<?php

    $offlineMode = false;
    function initerr($level, $description, $file, $line) {
        global $offlineMode;
        if (!$offlineMode) {
            echo("<p class=\"php-internal-error\">Votre site s'exécute en mode hors-ligne, le chargement de certaines librairies peut échouer et vous pourriez rencontrer des erreurs importantes. Afin d'éviter tout problème de corruption ou autre, préférez connecter votre serveur à Internet</p>");
            $offlineMode = true;
        }
        return true;
    }
    set_error_handler("initerr");
    file_get_contents("https://gitlab.com/minteck-projects/mpcms/code-base");
    file_get_contents("https://cdn.ckeditor.com");
    file_get_contents("https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.6/ace.js");

?>

<?php

function dataValid($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json")) {
    if (dataValid(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json"))) {
        $customSettings = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json"));
        if (isset($customSettings->AfficherBoutonAdministration) && isset($customSettings->AdministrationBarreNavigation) && isset($customSettings->RessourcesPersonnalisées) && isset($customSettings->RessourcesPersonnalisées->CSS) && isset($customSettings->RessourcesPersonnalisées->JS) && isset($customSettings->PagesMasquées)) {
            if (!$customSettings->AfficherBoutonAdministration) {
                echo("<style>#siteadmin-button{display:none;}</style>");
            }
            if (!$customSettings->AdministrationBarreNavigation) {
                echo("<style>#settings #navigation{display:none;}</style>");
            }
            echo("<style type=\"text/css\">" . $customSettings->RessourcesPersonnalisées->CSS . "</style>");
            echo("<script type=\"text/javascript\">" . $customSettings->RessourcesPersonnalisées->JS . "</script>");
        } else {
            die("<h1>Erreur interne</h1><p>Le fichier des paramètres avancés nst pas dans une syntaxe reconnue, mais il ne contient pas certains paramètres requis. Le chargement de la page s'est arrêté ici.</p><p>Si vous contactez votre administrateur système, demandez lui de supprimer le fichier <code>/data/webcontent/customSettings.json</code>, Minteck Projects CMS se chargera d'en générer un nouveau pour vous.</p><hr><i>Minteck Projects CMS " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version") . " " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/codename") . "</i>");
        }
    } else {
        die("<h1>Erreur interne</h1><p>Le fichier des paramètres avancés n'est pas dans une syntaxe reconnue, le chargement de la page s'est arrêté ici.</p><p>Si vous contactez votre administrateur réseau, demandez lui de supprimer le fichier <code>/data/webcontent/customSettings.json</code>, Minteck Projects CMS se chargera d'en générer un nouveau pour vous.</p><hr><i>Minteck Projects CMS " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version") . " " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/codename") . "</i>");
    }
} else {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json", "{
    \"RessourcesPersonnalisées\": {
        \"CSS\": \"\",
        \"JS\": \"\"
    },
    \"PagesMasquées\": [],
    \"AfficherBoutonAdministration\": true,
    \"AdministrationBarreNavigation\": true
}");
}

?>
<script src="/resources/js/jquery.js"></script>

<?php

//
// Tout le code inséré ici affectera TOUTES LES PAGES du site, incluant les pages d'administration
//

function errors($level, $description, $file, $line) {
    if ($level == E_USER_ERROR) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/ERROR - " . $file . ":" . $line . " - " . $description . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/ERROR - " . $file . ":" . $line . " - " . $description . "\n\n");
        }
    }
    if ($level == E_USER_WARNING) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/WARNING - " . $file . ":" . $line . " - " . $description . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/WARNING - " . $file . ":" . $line . " - " . $description . "\n\n");
        }
    }
    if ($level == E_USER_NOTICE) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/NOTICE - " . $file . ":" . $line . " - " . $description . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/NOTICE - " . $file . ":" . $line . " - " . $description . "\n\n");
        }
    }
    if ($level != E_USER_NOTICE && $level != E_USER_ERROR && $level != E_USER_WARNING) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/UNKNOWN - " . $file . ":" . $line . " - " . $description . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/UNKNOWN - " . $file . ":" . $line . " - " . $description . "\n\n");
        }
    }
    echo('<p><table class="message_error"><tbody><tr><td><img src="/resources/image/message_error.svg" class="message_img"></td><td style="width:100%;"><p>Une erreur s\'est produite lors du chargement de cette page, des informations détaillées ont été inscrites dans les fichiers journaux.</p><p>Le message d\'erreur dans les fichiers journaux commence généralement par <b>PHP-INTERNAL-ERROR/</b></p><p>Merci de contacter l\'administrateur système du site. Si vous êtes l\'administrateur système, nous vous conseillons d\'analyser et de corriger cette erreur.</p></td></tr></tbody></table></p>');
    return true;
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    set_error_handler("errors");
} else {
    return;
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - INTERFACE/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
} else {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - INTERFACE/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
}

try {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats")) {} else {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/")) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats");
        }
    }
    
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/")) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d"))) {
            (int)$actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d"));
            $actual = $actual + 1;
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d"), $actual);
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d"), "1");
        }
    }
} catch (E_WARNING $err) {
}

// file_get_contents("unexistingfile");

?>

<div id="snowapi-placeholder"><div snowapi-enable-snowfall></div></div>
<?= "<script>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/global.js") . "</script>" ?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/suru-enabled")) {
    echo('<script src="/resources/themes/icons/suru.js"></script>');
    echo("<style>img[src='/resources/image/suru_menu.png'] {filter:brightness(200%);}img[src='/resources/image/suru_tools.png'] {filter:brightness(200%);}img[src='/resources/image/suru_admin.png'] {filter:brightness(200%) !important;}img[src='/resources/image/suru_contact_address.png'] {filter:brightness(0%);}img[src='/resources/image/suru_contact_email.png'] {filter:brightness(0%);}img[src='/resources/image/suru_contact_phone.png'] {filter:brightness(0%);}img[src='/resources/image/suru_contact_priority.png'] {filter:brightness(0%);}</style>");
}

?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/classic-enabled")) {
    echo('<script src="/resources/themes/icons/classic.js"></script>');
}

?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ubuntufont-enabled")) {
    echo('<link rel="stylesheet" href="/resources/themes/fonts/ubuntu.css">');
}

?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ubuntulfont-enabled")) {
    echo('<link rel="stylesheet" href="/resources/themes/fonts/ubuntu-light.css">');
}

?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/darktheme-enabled")) {
    echo('<link rel="stylesheet" href="/resources/themes/colors/dark.css">');
    echo('<script src="/resources/themes/colors/dark.js"></script>');
}

?>
<script src="/resources/js/right-click.js"></script>
<link rel="stylesheet" href="/resources/css/right-click.css" />
<div class="hide" id="rmenu">
  <?php
  
  if (isset($name)) {
      echo('<a href="/cms-special/admin/pages/manage/?slug=' . $name . '" class="rmenulink"><img src="/resources/image/rightclick_page.svg" class="rmenuimg"> &nbsp; Gérer cette page</a>');
      $widgets = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json"));
    if (!empty($widgets->list)) {
        echo('<a onclick="pushbar.open(\'panel-sidebar\')" class="rmenulink"><img src="/resources/image/rightclick_details.svg" class="rmenuimg"> &nbsp; Détails</a>');
    }
  } else {
    echo('<a href="/cms-special/admin/logout" class="rmenulink"><img src="/resources/image/rightclick_exit.svg" class="rmenuimg"> &nbsp; Terminer la session</a>');
    echo('<a href="/cms-special/admin/store" class="rmenulink"><img src="/resources/image/rightclick_store.svg" class="rmenuimg"> &nbsp; CMS Store</a>');
  }
  
  ?>
  <hr class="rmenusep">
  <a onclick="history.back()" class="rmenulink"><img src="/resources/image/rightclick_back.svg" class="rmenuimg"> &nbsp; Précédent</a>
  <a onclick="history.forward()" class="rmenulink"><img src="/resources/image/rightclick_forward.svg" class="rmenuimg"> &nbsp; Suivant</a>
  <a onclick="location.reload()" class="rmenulink"><img src="/resources/image/rightclick_refresh.svg" class="rmenuimg"> &nbsp; Actualiser</a>
  <!-- <a onclick="location.reload()" class="rmenulink"><img src="/resources/image/rightclick_save.svg" class="rmenuimg"> &nbsp; Enregistrer la page</a> -->
  <hr class="rmenusep">
  <a href="/" class="rmenulink"><img src="/resources/image/rightclick_home.svg" class="rmenuimg"> &nbsp; Accueil</a>
  <a href="/cms-special/admin" class="rmenulink"><img src="/resources/image/rightclick_admin.svg" class="rmenuimg"> &nbsp; Administration du site</a>
</div>