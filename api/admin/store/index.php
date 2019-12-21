<?php

$invalid = false;

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {

    } else {
        die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/store&pa='</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/store&pa='</script>");
}

if (isset($_POST['password'])) {
    if (password_verify($_POST['password'], file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/password"))) {
        die("<script>location.href = '/cms-special/admin/home';</script>");
        return;
    } else {
        $invalid = true;
    }
}

function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

?>

<?php ob_start();echo("<!--\n\n" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/license") . "\n\n-->") ?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    $ready = true;
} else {
    $ready = false;
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
        echo("CMS Store - Administration du site - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
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
    </div><div id="navigation"><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/store" class="sblink">CMS Store</a></div>
        <?php
        
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store")) {
            echo("<br><br><center><img src=\"/resources/image/storeloader.svg\" width=\"48px\" height=\"48px\" style=\"filter:brightness(50%);\"><br><span id=\"loadmsg\">Construction de la base de données...</span></center><br><br>");
        } else {
            if (isJson(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store/packages.json"))) {
                echo("<p><a href=\"/cms-special/admin/store/dbupdate\" class=\"sblink\">Regénérer la base de données</a></p><p>Cliquez sur le nom d'une extension pour en savoir plus, l'installer/la désinstaller/la mettre à jour, voir les permissions, et plus</p><table cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;border-collapse: separate;border-spacing: 0px;\"><tbody style=\"width:100%;\"><tr><td class=\"storelist\"><center><b>Paquet</b></center></td><td class=\"storelist\"><center><b>Nom</b></center></td><td class=\"storelist\"><center><b>Développeur</b></center></td><td class=\"storelist\"><center><b>Langage de programmation</b></center></td></tr>");
                $db = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store/packages.json"));
                foreach ($db as $package) {
                    $packagename = array_search($package, (array)$db);
                    echo("<tr><td class=\"storelist\"><center><code>" . $packagename . "</code></center></td><td class=\"storelist\"><center><a class=\"sblink\" href=\"/cms-special/admin/store/package/?id=" . $packagename . "\">" . $package->name . "</a></center></td><td class=\"storelist\"><center>" . $package->author . "</center></td><td class=\"storelist\"><center>" . $package->language . "</center></td></tr>");
                }
            } else {
                echo('<p><table class="message_warning"><tbody><tr><td><img src="/resources/image/message_warning.svg" class="message_img"></td><td style="width:100%;"><p>La base de données des paquets du CMS Store est corrompue, vous devez donc <a href="/cms-special/admin/store/dbupdate" class="sblink">la regénérer en cliquant ici</a>, auquel cas elle n\'est pas exploitable par Minteck Projects CMS.</p><p>Cette corruption peut se produire si vous tentez de mettre à jour la base de données lorsque le serveur n\'a pas accès à Internet, ou que vous la modifiez vous-même.</p></td></tr></tbody></table></p>');
            }
            echo("</tbody></table>");
            echo("<p><center><i><b>CMS Store</b> version " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/store_version") . "</i></center></p>");
        }

        ?>
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