<?php $pageConfig = [ "domName" => "Mise à jour et sécurité", "headerName" => "Mise à jour et sécurité" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <?php

        $currentVersion = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version");
        $latestVersion = file_get_contents("https://gitlab.com/minteck-projects/mpcms/changelog/raw/master/latest_version");
        $returned = false;

        if (version_compare($currentVersion, $latestVersion) >= 1) {
            echo("<div id=\"protect\" class=\"s1\"><b>Votre site est potentiellement vulnérable</b><br>Vous utilisez une préversion de Minteck Projects CMS</div>");
            $returned = true;
        }
        
        if (!$returned) {
            if (!strpos($currentVersion, 'LTS') !== false) {
                if (version_compare($currentVersion, $latestVersion) <= -1) {
                    echo("<div id=\"protect\" class=\"s0\"><b>Votre site n'est pas protégé</b><br>Une mise à jour pour Minteck Projects CMS est disponible</div>");
                }
            } else {
                if (implode("", explode(".", explode(" ", $latestVersion)[0])) - implode("", explode(".", explode(" ", $currentVersion)[0])) >= 3) {
                    echo("<div id=\"protect\" class=\"s0\"><b>Votre site n'est pas protégé</b><br>Le support à long terme de votre version est terminé, il vous est fortement recommandé de mettre à jour votre site vers la dernière version disposant du support à long terme</div>");
                } else {
                    if (version_compare($currentVersion, $latestVersion) <= -1) {
                        echo("<div id=\"protect\" class=\"s2\"><b>Votre site est protégé</b><br>Une nouvelle version sans support à long terme est disponible, mais vous utilisez une version disposant du support à long terme</div><br>");
                    } else {
                        echo("<div id=\"protect\" class=\"s2\"><b>Votre site est protégé</b><br>Minteck Projects CMS est à jour, vous exécutez une version disposant du support à long terme</div><br>");
                        $returned = true;
                    }
                }
            }
        }
        
        if (version_compare($currentVersion, $latestVersion) == 0 && !$returned) {
            echo("<div id=\"protect\" class=\"s2\"><b>Votre site est protégé</b><br>Minteck Projects CMS est à jour</div><br>");
        }

        ?>
    <h3>Informations</h3>
    <ul><li>
    <?php

    if (version_compare($currentVersion, $latestVersion) == 0) {
        echo("Votre serveur exécute Minteck Projects CMS version <b>" . $currentVersion . "</b>");
    } else {
        if (version_compare($currentVersion, $latestVersion) <= -1) {
            echo("Votre serveur exécute Minteck Projects CMS version <b>" . $currentVersion . "</b>, et la dernière version disponible est la version <b>" . $latestVersion . "</b>");
        } else {
            echo("Votre serveur exécute Minteck Projects CMS version <b>" . $currentVersion . "</b>, et la dernière version stable en circulation est la version <b>" . $latestVersion . "</b>");
        }
    }
    echo("</li>");

    $size = 0;
    getData($_SERVER['DOCUMENT_ROOT']);
    $sizestr = $size . " octets";
    if ($size > 1024) {
        if ($size > 1048576) {
            if ($size > 1073741824) {
                $sizestr = round($size / 1073741824, 3) . " gibioctets";
            } else {
                $sizestr = round($size / 1048576, 3) . " mibioctets";
            }
        } else {
            $sizestr = round($size / 1024, 3) . " kibioctets";
        }
    } else {
        $sizestr = $size . " octets";
    }

    $sizestr = str_replace(".", ",", $sizestr);
    
    echo("<li>Votre site utilise <b>" . $sizestr . "</b> d'espace disque</li>");

    ?>
    </ul>
    <h3>Espace disque</h3>
    <meter id="storagebar" value="0" max="1" title="Espace disque utilisé"></meter>
    <span style="margin-left: 10px;"></span>
    <?php
    
    $globalSize = $size;

    $size = 0;
    getData($_SERVER['DOCUMENT_ROOT'] . "/api");
    $mpcmsSize = $size;
    getData($_SERVER['DOCUMENT_ROOT'] . "/cms-special");
    $mpcmsSize = $mpcmsSize + $size;
    getData($_SERVER['DOCUMENT_ROOT'] . "/widgets");
    $mpcmsSize = $mpcmsSize + $size;

    $size = 0;
    getData($_SERVER['DOCUMENT_ROOT'] . "/data");
    $dataSize = $size;

    $calSize = filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json");
    $confSize = filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename") + filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") + filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json") + filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/password") + filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/footer");
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-notes-data")) {
        $confSize = $confSize + filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-notes-data");
    }
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-contact-data")) {
        $confSize = $confSize + filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-contact-data");
    }

    $size = 0;
    getData($_SERVER['DOCUMENT_ROOT'] . "/resources");
    $resSize = $size;
    
    ?>
    <span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:#8bcf69;position:relative;width:15px;height:15px;display:inline-block;"></span><span style="margin-right:30px;">Minteck Projects CMS (<?= round(($mpcmsSize*100)/$globalSize, 2) ?>%)</span>
    <span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:#e6d450;position:relative;width:15px;height:15px;display:inline-block;"></span><span style="margin-right:30px;">Pages, configuration et calendrier (<?= round(($dataSize*100)/$globalSize, 2) ?>%)</span>
    <span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:#cf82bf;position:relative;width:15px;height:15px;display:inline-block;"></span><span style="margin-right:30px;">Galerie de photos et ressources (<?= round(($resSize*100)/$globalSize, 2) ?>%)</span>
    <span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:gray;position:relative;width:15px;height:15px;display:inline-block;"></span><span style="margin-right:30px;">Autre</span>
    <!-- <?= $globalSize - ($mpcmsSize + $dataSize + $resSize) ?>
    <?= "<br>" ?>
    <?= (($mpcmsSize + $dataSize + $resSize) * 100)/$globalSize ?> -->
    <style>
        #storagebar {
            width: 100%; /* To support legacy browsers */
            width: calc(100% - 16px);
            margin: 8px;
            border-radius: 5px;
            box-shadow: 0 5px 5px -5px #999 inset;
            background-image: linear-gradient(
                90deg, 
                #8bcf69 <?= round(($mpcmsSize*100)/$globalSize, 2) ?>%, 
                #e6d450 <?= round(($mpcmsSize*100)/$globalSize, 2) ?>%,
                #e6d450 <?= round(($dataSize*100)/$globalSize, 2) ?>%,
                #cf82bf <?= round(($dataSize*100)/$globalSize, 2) ?>%,
                #cf82bf <?= round(($resSize*100)/$globalSize, 2) ?>%,
                gray <?= round(($resSize*100)/$globalSize, 2) ?>%,
                gray 100%
                /* #719fd1 95%,
                #719fd1 100% */
            );
            background-size: 100% 100%;
        }
    </style>
    <h4>Légende</h4>
    <h5><span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:#8bcf69;position:relative;width:15px;height:15px;display:inline-block;"></span>Minteck Projects CMS</h5>
    Fichiers critiques pour le bon fonctionnement du logiciel Minteck Projects CMS. Si un de ces fichiers est supprimé, Minteck Projects CMS ou une partie du logiciel peut ne plus fonctionner correctement.
    <h5><span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:#e6d450;position:relative;width:15px;height:15px;display:inline-block;"></span>Pages, configuration et calendrier</h5>
    Fichiers spécifiques à votre site contenant les informations de ce dernier (les widgets activés, le calendrier, les différentes pages, etc...). Ces fichiers ne sont pas critiques pour le bon fonctionnement de Minteck Projects CMS, mais requis pour le bon fonctionnement de votre site. Vous pouvez les supprimer via l'option de <a href="/cms-special/admin/housekeeping/reset" class="sblink" title="Lien vers : Administration > Maintenance > Réinitiliser">Réinitialisation</a> du site.
    <h5><span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:#cf82bf;position:relative;width:15px;height:15px;display:inline-block;"></span>Galerie de photos et ressources</h5>
    Fichiers requis pour l'interface graphique de Minteck Projects CMS et pour la galerie de photos. Ces fichiers incluent notamment les différentes polices de caractères, les définitions de l'apparance, les îcones, les librairies utilisées, le code de l'éditeur, la licence, et les définitions de code partagé. Les images utilisateur (dans le dossier <code>/resources/upload</code>) sont des images que vous avez vous-même importé sur votre site (logo du site, bannière, photos de la galerie de photos)
    <h5><span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:gray;position:relative;width:15px;height:15px;display:inline-block;"></span>Autre</h5>
    Fichiers non classés par Minteck Projects CMS qui peuvent être plus ou moins critiques. Si vous avez l'intention de supprimer l'un d'entre eux, préférez contacter les développeurs avant toute manipulation.
    <h3>Changements</h3>
    <h4>Version actuelle (<?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version") ?>)</h4>
    <?php
    
    if (!startsWith(file_get_contents("https://gitlab.com/minteck-projects/mpcms/changelog/raw/master/changelog/" . str_replace(" ", "%20", $currentVersion),false,stream_context_create(['http' => ['ignore_errors' => true,],])), "<!DOCTYPE")) {
        echo(file_get_contents("https://gitlab.com/minteck-projects/mpcms/changelog/raw/master/changelog/" . str_replace(" ", "%20", $currentVersion),false,stream_context_create(['http' => ['ignore_errors' => true,],])));
    } else {
        echo("<i>Aucune information concernant votre version de Minteck Projects CMS</i>");
    }
    
    ?>
    <?php

    if (version_compare($currentVersion, $latestVersion) == 0) {
    } else {
        if (version_compare($currentVersion, $latestVersion) <= -1) {
            echo("<h4>Dernière version stable (" . $latestVersion . ")</h4>");
        } else {
            echo("<h4>Version stable en circulation (" . $latestVersion . ")</h4>");
        }
        if (!startsWith(file_get_contents("https://gitlab.com/minteck-projects/mpcms/changelog/raw/master/changelog/" . str_replace(" ", "%20", $latestVersion),false,stream_context_create(['http' => ['ignore_errors' => true,],])), "<!DOCTYPE")) {
            echo(file_get_contents("https://gitlab.com/minteck-projects/mpcms/changelog/raw/master/changelog/" . str_replace(" ", "%20", $latestVersion),false,stream_context_create(['http' => ['ignore_errors' => true,],])));
        } else {
            echo("<i>Aucune information concernant votre version de Minteck Projects CMS</i>");
        }
    }

    ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>