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

if (isset($_GET['slug'])) {
    $currentSlug = $_GET['slug'];
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $currentSlug)) {} else {
        die("<script>location.href = '/cms-special/admin/pages';</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/pages';</script>");
}

if ($currentSlug == "index") {
    $currentName = "Accueil";
} else {
    $currentName = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $currentSlug . "/pagename");
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
    <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/banner.jpg")) {$banner = "/resources/upload/banner.jpg";if (getAvgLuminance($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/banner.jpg") > 50) {$blackBannerText = true;} else {$blackBannerText = false;}} else {$banner = "/resources/image/default.jpg";if (getAvgLuminance($_SERVER['DOCUMENT_ROOT'] . "/resources/image/default.jpg") > 50) {$blackBannerText = true;} else {$blackBannerText = false;}}function getAvgLuminance($filename, $num_samples=30) {$img = imagecreatefromjpeg($filename);$width = imagesx($img);$height = imagesy($img);$x_step = intval($width/$num_samples);$y_step = intval($height/$num_samples);$total_lum = 0;$sample_no = 1;for ($x=0; $x<$width; $x+=$x_step) {for ($y=0; $y<$height; $y+=$y_step) {$rgb = imagecolorat($img, $x, $y);$r = ($rgb >> 16) & 0xFF;$g = ($rgb >> 8) & 0xFF;$b = $rgb & 0xFF;$lum = ($r+$r+$b+$g+$g+$g)/6;$total_lum += $lum;$sample_no++;}}$avg_lum  = $total_lum / $sample_no;return ($avg_lum / 255) * 100;}function getData(string $dir, $ignoreUploadDir = false) {global $size;$dircontent = scandir($dir);foreach ($dircontent as $direl) {if (($ignoreUploadDir && ($direl == "/upload" || $dir . "/" . $direl == $_SERVER['DOCUMENT_ROOT'] . "/resources/upload")) || $direl == ".git") {} else {if ($direl == "." || $direl == "..") {} else {if (is_link($dir . "/" . $direl)) {} else {if (is_dir($dir . "/" . $direl)) {getData($dir . "/" . $direl);} else {$size = $size + filesize($dir . "/" . $direl);}}}}}}getData($_SERVER['DOCUMENT_ROOT']);$sizestr = $size . " octets";if ($size > 1024) {if ($size > 1048576) {if ($size > 1073741824) {$sizestr = round($size / 1073741824, 2) . " Gio";} else {$sizestr = round($size / 1048576, 2) . " Mio";}} else {$sizestr = round($size / 1024, 2) . " Kio";}} else {$sizestr = $size . " octets";}$sizestr = str_replace(".", ",", $sizestr); ?>
    <div id="banner" style='background-image: url("<?= $banner ?>");'>
        <center><table style="width:100%;"><tr><td style="width:50%;"><img style="float:right;" id="banner-logo" src="/resources/upload/siteicon.png"><td><td><span style="float:left;" id="adminb" <?php if ($blackBannerText) {echo("class=\"banner-black\"");} ?>><span id="banner-name" <?php if ($blackBannerText) {echo("class=\"banner-black\"");} ?>><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename") ?><br></span>MPCMS <?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version") ?> • <?= $sizestr ?></span></td></tr></table></center>
    </div><div id="navigation"><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/pages" class="sblink">Pages</a> &gt; <a href="/cms-special/admin/pages/manage/?slug=<?= $currentSlug ?>" class="sblink"><?= $currentName ?></a></div>
        <h2><?= $currentName ?></h2>
        <div id="confirm">
            <p>Voulez-vous vraiment supprimer la page "<?= $currentName ?>" ? Cette action est irréversible et tout lien menant vers cette page renverra à une page     d'erreur...</p>
            <?php

            if ($currentSlug == "index") {
                die("<i>Vous ne pouvez pas supprimer la page d'accueil de votre site</i></div></body></html>");
            }

            ?>
            <ul>
                <li><a onclick="deletePage()" class="sblink" title="Supprimer la page sélectionnée">Oui</a></li>
                <li><a onclick="location.href='/cms-special/admin/pages/manage/?slug=<?= $currentSlug ?>'" class="sblink" title="Annuler la suppresion de la page sélectionnée">Non</a></li>
            </ul>
        </div>
        <div class="hide" id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
    </div>
</body>
</html>

<script>

function deletePage() {
    document.getElementById('confirm').classList.add('hide')
    document.getElementById('loader').classList.remove('hide')
    var formData = new FormData();
    formData.append("page", "<?= $currentSlug ?>");
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/delete_page.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/pages"
            } else {
                alert("Erreur : " + data);
                document.getElementById('confirm').classList.remove('hide')
                document.getElementById('loader').classList.add('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication");
            document.getElementById('confirm').classList.remove('hide')
            document.getElementById('loader').classList.add('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>