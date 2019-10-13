<?php

$invalid = false;

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {

    } else {
        die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/customization&pa='</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/customization&pa='</script>");
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
    </div><div id="navigation"><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/customization" class="sblink">Personnalisation</a></div>
        <h2>Personnalisez l'apparance de votre site</h2>
        <!-- <blockquote>Les modifications apportées ne s'appliqueront qu'après le <a onclick="location.reload()" class="sblink" title="Recharger la page">rechargement de la page</a>.</blockquote> -->
        <p><table class="message_info"><tbody><tr><td><img src="/resources/image/message_info.svg" class="message_img"></td><td style="width:100%;"><p>Les modifications apportées ne s'appliqueront qu'après le <a onclick="location.reload()" class="sblink" title="Recharger la page">rechargement de la page</a>.</p><p>Si les changements ne s'appliquent pas, essayez de purger le cache (<b><a title="Contrôle" class="indication">⌃</a>+<a title="Majuscule" class="indication">⇧</a>+R</b> sur Windows ou Linux, ou <b><a title="Commande, Super" class="indication">⌘</a>+<a title="Majuscule" class="indication">⇧</a>+R</b> sur Mac)</p></td></tr></tbody></table></p>
        <h3>Pack d'îcones</h3>
        <select id="icons" onchange="updateIcons()">
            <option value="default" <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/suru-enabled")) {echo("selected");} ?>>Minteck Projects CMS</option>
            <option value="suru" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/suru-enabled")) {echo("selected");} ?>>Suru</option>
            <option value="classic" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/classic-enabled")) {echo("selected");} ?>>Classique</option>
        </select>
        <h3>Police de caractères</h3>
        <select id="font" onchange="updateFont()">
            <option value="default" <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ubuntufont-enabled") && !file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ubuntulfont-enabled")) {echo("selected");} ?>>Google Sans</option>
            <option value="ubuntu" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ubuntufont-enabled")) {echo("selected");} ?>>Ubuntu</option>
            <option value="ubuntul" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ubuntulfont-enabled")) {echo("selected");} ?>>Ubuntu Thin</option>
        </select>
        <h3>Couleurs</h3>
        <select id="colors" onchange="updateColors()">
            <option value="default" <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/darktheme-enabled")) {echo("selected");} ?>>Clair</option>
            <option value="dark" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/darktheme-enabled")) {echo("selected");} ?>>Sombre</option>
        </select>
    </div>
</body>
<script>

function updateIcons() {
    document.getElementById('icons').disabled = true;
    var formData = new FormData();
    formData.append("theme", document.getElementById('icons').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/customization_icons.php",
        success: function (data) {
            if (data == "ok") {
                console.log("Sauvegardé avec succès")
                setTimeout(() => {
                    document.getElementById('icons').disabled = false;
                }, 500)
            } else {
                alert("Erreur : " + data);
            }
        },
        error: function (error) {
            alert("Erreur de communication");
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function updateColors() {
    document.getElementById('colors').disabled = true;
    var formData = new FormData();
    formData.append("theme", document.getElementById('colors').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/customization_colors.php",
        success: function (data) {
            if (data == "ok") {
                console.log("Sauvegardé avec succès")
                setTimeout(() => {
                    document.getElementById('colors').disabled = false;
                }, 500)
            } else {
                alert("Erreur : " + data);
            }
        },
        error: function (error) {
            alert("Erreur de communication");
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function updateFont() {
    document.getElementById('font').disabled = true;
    var formData = new FormData();
    formData.append("theme", document.getElementById('font').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/customization_font.php",
        success: function (data) {
            if (data == "ok") {
                console.log("Sauvegardé avec succès")
                setTimeout(() => {
                    document.getElementById('font').disabled = false;
                }, 500)
            } else {
                alert("Erreur : " + data);
            }
        },
        error: function (error) {
            alert("Erreur de communication");
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>
</html>