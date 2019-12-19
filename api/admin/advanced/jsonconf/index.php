<?php

$invalid = false;

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {

    } else {
        die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/pages/add&pa='</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/pages/add&pa='</script>");
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
    <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/translations/fr.js"></script>
    <title><?php
    
    if ($ready) {
        echo("Préférences de développement - Paramètres avancés - Administration du site - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
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
    </div><div id="navigation"><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/advanced" class="sblink">Paramètres avancés</a></div>
    <h2>Modification des paramètres avancés <i>(JSON)</i></h2>
    <p><table class="message_warning"><tbody><tr><td><img src="/resources/image/message_warning.svg" class="message_img"></td><td style="width:100%;"><p>Modifiez ces paramètres avec les plus grandes précautions, car toute modification erronée peut empêcher votre site de fonctionner.</p><p>Si votre site ne fonctionne plus après une modification, demandez à votre administrateur système de supprimer le fichier <code>/data/webcontent/customSettings.json</code>. Le logiciel se chargera de regénérer un nouveau fichier de paramètres avancés sans erreurs.</p></td></tr></tbody></table></p>
    <div id="editing">
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/CodeEditor$3.php" ?>
    </div>
    <div class="hide" id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
    <p><h3>Description des paramètres</h3></p>
    <p><table style="width:100%;border-collapse: separate;border-spacing: 0px;" cellspacing="0" cellpadding="0"><tbody style="width:100%;">
        <tr>
            <td class="storelist"><center><b>Paramètre</b></center></td>
            <td class="storelist"><center><b>Type de valeur</b></center></td>
            <td class="storelist"><center><b>Valeur initiale</b></center></td>
            <td class="storelist"><center><b>Description</b></center></td>
        </tr>
        <tr>
            <td class="storelist"><center><code>RessourcesPersonnalisées</code></center></td>
            <td class="storelist"><center>Objet (<code>object</code>)</center></td>
            <td class="storelist"><center><code>{"CSS": "","JS": ""}</code></center></td>
            <td class="storelist"><center>Ressources externes importées sur toutes les pages de votre site</center></td>
        </tr>
        <tr>
            <td class="storelist"><center><code>RessourcesPersonnalisées/CSS</code></center></td>
            <td class="storelist"><center>Texte (<code>string</code>)</center></td>
            <td class="storelist"><center><code>""</code></center></td>
            <td class="storelist"><center>Feuille de style globale importée sur toutes les pages de votre site</center></td>
        </tr>
        <tr>
            <td class="storelist"><center><code>RessourcesPersonnalisées/JS</code></center></td>
            <td class="storelist"><center>Texte (<code>string</code>)</center></td>
            <td class="storelist"><center><code>""</code></center></td>
            <td class="storelist"><center>Script JavaScript (compatible ECMAScript) importé sur toutes les pages de votre site</center></td>
        </tr>
        <tr>
            <td class="storelist"><center><code>PagesMasquées</code></center></td>
            <td class="storelist"><center>Liste (<code>array</code>)</center></td>
            <td class="storelist"><center><code>[]</code></center></td>
            <td class="storelist"><center>Liste des identifiants des pages à ne pas afficher dans le menu</center></td>
        </tr>
        <tr>
            <td class="storelist"><center><code>AfficherBoutonAdministration</code></center></td>
            <td class="storelist"><center>Booléenne (<code>boolean</code>)</center></td>
            <td class="storelist"><center><code>true</code></center></td>
            <td class="storelist"><center>Afficher le bouton "Administration du site" en haut à droite de votre site</center></td>
        </tr>
        <tr>
            <td class="storelist"><center><code>AdministrationBarreNavigation</code></center></td>
            <td class="storelist"><center>Booléenne (<code>boolean</code>)</center></td>
            <td class="storelist"><center><code>true</code></center></td>
            <td class="storelist"><center>Afficher la barre de navigation dans l'administration du site</center></td>
        </tr>
    </tbody></table></p><br>
    </div>
</body>
</html>

<script>
    window.onbeforeunload = function (e) {
    e = e || window.event;

    // For IE and Firefox prior to version 4
    if (e) {
        e.returnValue = "En quittant cette page, vous perdrez les modifications non enregistrées sur cette page.";
    }

        // For Safari
        return "En quittant cette page, vous perdrez les modifications non enregistrées sur cette page.";
    };
</script>

<script>

function pushSettings() {
    Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = true})
    document.getElementById('loader').classList.remove('hide')
    document.getElementById('editing').classList.add('hide')
    var formData = new FormData();
    formData.append("content", ace.edit("editor").getValue());
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/save_advanced.php",
        success: function (data) {
            if (data == "ok") {
                window.onbeforeunload = undefined;
                location.href = "/cms-special/admin/home";
            } else {
                alert("Erreur : " + data)
                Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
                document.getElementById('loader').classList.add('hide')
                document.getElementById('editing').classList.remove('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication")
            document.getElementById('loader').classList.add('hide')
            document.getElementById('editing').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>