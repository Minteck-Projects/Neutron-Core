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

<?php ob_start();echo("<!--\n\n" . str_replace('%year%', date('Y'), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/license")) . "\n\n-->") ?>
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
        echo("Affichage connecté - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
    } else {
        echo("Affichage connecté - MPCMS");
    }

    ?></title>
    <?php
        if (!$ready) {
            die("<script>location.href = '/cms-special/setup';</script></head>");
        }
    ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/header.php"; ?>
</head>
<body>
    <div id="settings">
    <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/banner.jpg")) {$banner = "/resources/upload/banner.jpg";if (getAvgLuminance($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/banner.jpg") > 50) {$blackBannerText = true;} else {$blackBannerText = false;}} else {$banner = "/resources/image/default.jpg";if (getAvgLuminance($_SERVER['DOCUMENT_ROOT'] . "/resources/image/default.jpg") > 50) {$blackBannerText = true;} else {$blackBannerText = false;}}function getAvgLuminance($filename, $num_samples=30) {$img = imagecreatefromjpeg($filename);$width = imagesx($img);$height = imagesy($img);$x_step = intval($width/$num_samples);$y_step = intval($height/$num_samples);$total_lum = 0;$sample_no = 1;for ($x=0; $x<$width; $x+=$x_step) {for ($y=0; $y<$height; $y+=$y_step) {$rgb = imagecolorat($img, $x, $y);$r = ($rgb >> 16) & 0xFF;$g = ($rgb >> 8) & 0xFF;$b = $rgb & 0xFF;$lum = ($r+$r+$b+$g+$g+$g)/6;$total_lum += $lum;$sample_no++;}}$avg_lum  = $total_lum / $sample_no;return ($avg_lum / 255) * 100;}function getData(string $dir, $ignoreUploadDir = false) {global $size;$dircontent = scandir($dir);foreach ($dircontent as $direl) {if (($ignoreUploadDir && ($direl == "/upload" || $dir . "/" . $direl == $_SERVER['DOCUMENT_ROOT'] . "/resources/upload")) || $direl == ".git") {} else {if ($direl == "." || $direl == "..") {} else {if (is_link($dir . "/" . $direl)) {} else {if (is_dir($dir . "/" . $direl)) {getData($dir . "/" . $direl);} else {$size = $size + filesize($dir . "/" . $direl);}}}}}}getData($_SERVER['DOCUMENT_ROOT']);$sizestr = $size . " octets";if ($size > 1024) {if ($size > 1048576) {if ($size > 1073741824) {$sizestr = round($size / 1073741824, 2) . " Gio";} else {$sizestr = round($size / 1048576, 2) . " Mio";}} else {$sizestr = round($size / 1024, 2) . " Kio";}} else {$sizestr = $size . " octets";}$sizestr = str_replace(".", ",", $sizestr); ?>
    <div id="banner" style='background-image: url("<?= $banner ?>");'>
        <center><table style="width:100%;"><tr><td style="width:50%;"><img style="float:right;" id="banner-logo" src="/resources/upload/siteicon.png"><td><td><span style="float:left;" id="adminb" <?php if ($blackBannerText) {echo("class=\"banner-black\"");} ?>><span id="banner-name" <?php if ($blackBannerText) {echo("class=\"banner-black\"");} ?>><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename") ?><br></span>MPCMS <?= str_replace("#", substr(md5(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")), 0, 2), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")) ?> • <?= $sizestr ?></span></td></tr></table></center>
    </div><div id="navigation"><a href="/cms-special/display" class="sblink">Affichage connecté</a></div>
        <h2>Configurez l'affichage connecté en quelques étapes</h2>
        <center>
            <p><span class="step">①</span> Installez l'application <b>MPCMS Display</b> sur votre smartphone Android</p>
            <p><span class="step">②</span> Configurez l'<b><a onclick="window.open('/cms-special/display/display')" title="Ouvrir l'affichage connecté dans un nouvel onglet" class="sblink">affichage connecté</a></b> dans votre navigateur en l'ouvrant dans un nouvel onglet</p>
            <p><span class="step">③</span> Lancez l'application <b>MPCMS Display</b> et suivez les instructions affichées sur l'affichage connecté</p>
        </center>
    </div>
</body>
</html>