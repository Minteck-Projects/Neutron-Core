<?php

$invalid = false;

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {

    } else {
        die("<script>location.href = '/cms-special/admin'</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin'</script>");
}

if (isset($_POST['password'])) {
    if (password_verify($_POST['password'], file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/password"))) {
        die("<script>location.href = '/cms-special/admin/home';</script>");
        return;
    } else {
        $invalid = true;
    }
}

?>

<?php echo("<!--\n\n" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/license") . "\n\n-->") ?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    $ready = true;
} else {
    $ready = false;
}

?>
<?php

if (isset($_GET['id'])) {
    $foundone = false;
    $db = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store/packages.json"));
    foreach ($db as $package) {
        if (array_search($package, (array)$db) == $_GET['id']) {
            $name = $package->name;
            $foundone = true;
        }
    }
    if (!$foundone) {
        die("<script>location.href = '/cms-special/admin/store';</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/store';</script>");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/resources/css/admin.css">
    <link rel="stylesheet" href="/resources/css/fonts-import.css">
    <link rel="stylesheet" href="/resources/css/ui.css">
    <title><?php
    
    if ($ready) {
        echo("Administration du site - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
    } else {
        echo("Administration du site - MPCMS");
    }

    ?></title>
    <?php
        if (!$ready) {
            die("<script>location.href = '/cms-special/setup';</script></head>");
        }
    ?>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/header.php"; ?>
</head>
<body>
    <div id="settings">
    <?php $banner = "/resources/image/codename.jpg";if (getAvgLuminance($_SERVER['DOCUMENT_ROOT'] . "/resources/image/codename.jpg") > 50) {$blackBannerText = true;} else {$blackBannerText = false;}function getAvgLuminance($filename, $num_samples=30) {$img = imagecreatefromjpeg($filename);$width = imagesx($img);$height = imagesy($img);$x_step = intval($width/$num_samples);$y_step = intval($height/$num_samples);$total_lum = 0;$sample_no = 1;for ($x=0; $x<$width; $x+=$x_step) {for ($y=0; $y<$height; $y+=$y_step) {$rgb = imagecolorat($img, $x, $y);$r = ($rgb >> 16) & 0xFF;$g = ($rgb >> 8) & 0xFF;$b = $rgb & 0xFF;$lum = ($r+$r+$b+$g+$g+$g)/6;$total_lum += $lum;$sample_no++;}}$avg_lum  = $total_lum / $sample_no;return ($avg_lum / 255) * 100;}function getData(string $dir, $ignoreUploadDir = false) {global $size;$dircontent = scandir($dir);foreach ($dircontent as $direl) {if (($ignoreUploadDir && ($direl == "/upload" || $dir . "/" . $direl == $_SERVER['DOCUMENT_ROOT'] . "/resources/upload")) || $direl == ".git") {} else {if ($direl == "." || $direl == "..") {} else {if (is_link($dir . "/" . $direl)) {} else {if (is_dir($dir . "/" . $direl)) {getData($dir . "/" . $direl);} else {$size = $size + filesize($dir . "/" . $direl);}}}}}}getData($_SERVER['DOCUMENT_ROOT']);$sizestr = $size . " octets";if ($size > 1024) {if ($size > 1048576) {if ($size > 1073741824) {$sizestr = round($size / 1073741824, 2) . " Gio";} else {$sizestr = round($size / 1048576, 2) . " Mio";}} else {$sizestr = round($size / 1024, 2) . " Kio";}} else {$sizestr = $size . " octets";}$sizestr = str_replace(".", ",", $sizestr); ?>
    <div id="banner" style='background-image: url("<?= $banner ?>");'>
        <center><table style="width:100%;"><tr><td style="width:50%;"><img style="float:right;" id="banner-logo" src="/resources/upload/siteicon.png"><td><td><span style="float:left;" id="adminb" <?php if ($blackBannerText) {echo("class=\"banner-black\"");} ?>><span id="banner-name" <?php if ($blackBannerText) {echo("class=\"banner-black\"");} ?>><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename") ?><br></span><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version") ?> <?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/codename") ?> • <?= $sizestr ?></span></td></tr></table></center>
    </div><div id="navigation"><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/store" class="sblink">CMS Store</a> &gt; <a href="/cms-special/admin/store/package/?id=<?= $_GET['id'] ?>" class="sblink"><?= $name ?></a></div>
        <?php
        
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store")) {
            die("<script>location.href = \"/cms-special/admin/store\"</script></div></body></html>");
        }

        ?>
        <center><span id="store-info">
            <h2 style="margin-bottom:8px;"><?= $package->name ?></h2>
            <div style="margin-bottom:12px;"><code><?= array_search($package, (array)$db) ?></code> • <?= $package->author ?></div>
            <?php
            
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db))) {
                echo('<a id="store-install" href="/cms-special/admin/store/remove/?id=' . array_search($package, (array)$db) . '">Désinstaller</a>&nbsp;&nbsp;<a id="store-more" href="/cms-special/admin/store/update/?id=' . array_search($package, (array)$db) . '">Mettre à jour</a><br><br>');
            } else {
                echo('<a id="store-install" href="/cms-special/admin/store/install/?id=' . array_search($package, (array)$db) . '">Installer</a>&nbsp;&nbsp;<a id="store-more" onclick="window.open(&quot;https://gitlab.com/minteck-projects/mpcms/plugins/tree/master/' . array_search($package, (array)$db) . '&quot;)">Explorer</a><br><br>');
            }
            
            if (strpos($package->author, 'Minteck Projects') !== false || strpos($package->author, 'Mozilla') !== false || strpos($package->author, 'Google') !== false || strpos($package->author, 'Microsoft') !== false || strpos($package->author, 'Canonical') !== false || strpos($package->author, 'Ubuntu') !== false || strpos($package->author, 'Firefox') !== false || strpos($package->author, 'Windows') !== false || strpos($package->author, 'Red Numérique') !== false) {
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
                echo("<i>Cette application ne requiert aucune permission</i>");
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

                if ($permission == "PLUGINS") {
                    echo("<li>Communiquer et partager des informations avec d'autres extensions</li>");
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
    </div>
</body>

<script>

window.onload = () => {
    if (<?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store")) { echo("true"); } else { echo("false"); } ?>) {} else {
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/store_setup.php",
            success: function (data) {
                if (data == "ok") {
                    document.getElementById('loadmsg').innerHTML = "Terminé"
                    location.reload()
                } else {
                    document.getElementById('loadmsg').innerHTML = "Une erreur s'est produite : " + data;
                }
            },
            error: function (error) {
                document.getElementById('loadmsg').innerHTML = "Erreur de communication";
                window.onbeforeunload = undefined;
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
}

</script>

</html>
