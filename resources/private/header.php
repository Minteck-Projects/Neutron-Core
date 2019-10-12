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
    echo("<p class=\"php-internal-error\">Une erreur s'est produite lors de l'initialisation de cette page, au niveau de cet emplacement, nous vous conseillons de contacter l'administrateur du site Web. Si vous êtes l'administrateur du site Web, vous pouvez consulter les fichiers journaux. Cherchez un message du type <code>PHP-INTERNAL-ERROR/*</code></p>");
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
      echo('<a href="/cms-special/admin/pages/manage/?slug=' . $name . '" class="rmenulink">Gérer cette page</a>');
      $widgets = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json"));
    if (!empty($widgets->list)) {
        echo('<a onclick="pushbar.open(\'panel-sidebar\')" class="rmenulink">Détails</a>');
    }
  } else {
    echo('<a href="/cms-special/admin/logout" class="rmenulink">Terminer la session</a>');
    echo('<a href="/cms-special/admin/store" class="rmenulink">CMS Store</a>');
  }
  
  ?>
  <hr class="rmenusep">
  <a href="/" class="rmenulink">Accueil</a>
  <a href="/cms-special/admin" class="rmenulink">Administration du site</a>
</div>