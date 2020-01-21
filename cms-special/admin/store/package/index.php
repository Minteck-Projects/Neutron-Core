<?php

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store")) {
    die("<script>location.href = '/cms-special/admin/store';</script>");
}

if (isset($_GET['id'])) {
    $foundone = false;
    $db = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store/packages.json"));
    foreach ($db as $package) {
        if (array_search($package, (array)$db) == $_GET['id']) {
            $pf = $package;
            $name = $package->name;
            $foundone = true;
        }
    }
    if ($foundone) {
        $package = $pf;
    } else {
        $package = null;
    }
    if (!$foundone) {
        die("<script>location.href = '/cms-special/admin/store';</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/store';</script>");
}

?>
<?php $pageConfig = [ "domName" => "{$name} - CMS Store", "headerName" => "{$name}" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <?php
        
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store")) {
            die("<script>location.href = \"/cms-special/admin/store\"</script></div></body></html>");
        }

        ?>
        <center><span id="store-info">
            <h2 style="margin-bottom:8px;"><?= $package->name ?></h2>
            <?php

            if (isset($package->id)) {
                echo('<div style="margin-bottom:12px;"><code>' . $package->id . '</code><br>' . $package->author . '</div>');
            } else {
                echo('<div style="margin-bottom:12px;"><code>' . array_search($package, (array)$db) . '</code> • ' . $package->author . '</div>');
            }
            
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db))) {
                echo('<a id="store-install" href="/cms-special/admin/store/remove/?id=' . array_search($package, (array)$db) . '">Désinstaller</a>&nbsp;&nbsp;<a id="store-more" href="/cms-special/admin/store/update/?id=' . array_search($package, (array)$db) . '">Mettre à jour</a><br><br>');
            } else {
                echo('<a id="store-install" href="/cms-special/admin/store/install/?id=' . array_search($package, (array)$db) . '">Installer</a>&nbsp;&nbsp;<a id="store-more" target="_blank" href="https://gitlab.com/minteck-projects/mpcms/plugins/tree/master/' . array_search($package, (array)$db) . '">Explorer</a><br><br>');
            }
            
            if (strpos($package->author, 'Minteck Projects') !== false || strpos($package->author, 'Mozilla') !== false || strpos($package->author, 'Google') !== false || strpos($package->author, 'Microsoft') !== false || strpos($package->author, 'Canonical') !== false || strpos($package->author, 'Ubuntu') !== false || strpos($package->author, 'Firefox') !== false || strpos($package->author, 'Windows') !== false || strpos($package->author, 'Red Numérique') !== false || strpos($package->author, 'KDE') !== false) {
                echo("<small id=\"store-info-verified\">");
                echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/image/store_verified.svg"));
                echo("Éditeur vérifié par Secure CMS</small>");
            }
            
            ?>
            <div id="store-info-details">
                <center><span class="store-info-details-el"><?= $package->language ?></span> &nbsp;&nbsp;&nbsp; <span class="store-info-details-sep">|</span> &nbsp;&nbsp;&nbsp; <span class="store-info-details-el"><?= $package->license ?></span></center>
            </div>
            <div id="store-info-summary">
                <h3 id="store-info-summary-title">Résumé de l'extension <?php echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/image/store_go.svg"); ?></h3>
                <?= $package->description ?>
            </div>
            <div id="store-info-permissions">
            <h3 id="store-info-permissions-title">Permissions requises <?php echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/image/store_go.svg"); ?></h3>
            <?php
            
            if (count($package->permissions) == 0) {
                echo("<i>Cette extension ne requiert aucune permission</i>");
            } else {
                echo("<ul>");
            }

            foreach ($package->permissions as $permission) {
                $defined = false;

                if ($permission == "TEXT") {
                    echo("<li>Afficher du texte dans la barre des widgets</li>");
                    $defined = true;
                }

                if ($permission == "FILES") {
                    echo("<li>Accéder librement aux fichiers du serveur</li>");
                    $defined = true;
                }

                if ($permission == "INTERNET") {
                    echo("<li>Accéder librement à Internet</li>");
                    $defined = true;
                }

                if ($permission == "EDITUI") {
                    echo("<li>Modifier l'apparence et la position des éléments de votre site</li>");
                    $defined = true;
                }

                if ($permission == "ONTOP") {
                    echo("<li>S'afficher par dessus l'interface du site</li>");
                    $defined = true;
                }

                if ($permission == "GETINFO") {
                    echo("<li class=\"specialperm\">Obtenir des informations concernant les visiteurs de votre site</li>");
                    $defined = true;
                }

                if ($permission == "IMAGES") {
                    echo("<li class=\"specialperm\">Afficher des médias (images, vidéos, musiques, etc...) sur certaines pages de votre site</li>");
                    $defined = true;
                }

                if ($permission == "SETTINGS") {
                    echo("<li class=\"specialperm\">Modifier les paramètres de votre site</li>");
                    $defined = true;
                }

                if ($permission == "GETPAGES") {
                    echo("<li>Obtenir le contenu des pages</li>");
                    $defined = true;
                }

                if ($permission == "CHANGEPAGES") {
                    echo("<li>Modifier et publier le contenu des pages</li>");
                    $defined = true;
                }

                if ($permission == "UPDATES") {
                    echo("<li>Se mettre à jour automatiquement en utilisant son propre système de mise à jour</li>");
                    $defined = true;
                }

                if ($permission == "CMSSTORE") {
                    echo("<li>Accéder au CMS Store, modifier les informations, et/ou mettre à jour la base de données</li>");
                    $defined = true;
                }

                if ($permission == "PLUGINSMGMT") {
                    echo("<li>Installer, mettre à jour, et/ou désinstaller d'autres extensions</li>");
                    $defined = true;
                }

                if ($permission == "ROOT") {
                    echo("<li class=\"criticalperm\">Accéder à des fichiers hors de votre site sur votre serveur</li>");
                    $defined = true;
                }

                if ($permission == "SHELL") {
                    echo("<li class=\"criticalperm\">Exécuter des commandes sur votre serveur</li>");
                    $defined = true;
                }

                if ($permission == "RESET") {
                    echo("<li class=\"criticalperm\">Réinitialiser votre site sans avertissement</li>");
                    $defined = true;
                }

                if (!$defined) {
                    echo("<li><code>" . $permission . "</code></li>");
                }
            }

            if (count($package->permissions) == 0) {} else {
                echo("</ul>");
            }
            
            ?>
            </div>
        </span></center>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>