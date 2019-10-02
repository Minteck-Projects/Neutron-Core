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
    </div><div id="navigation"><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/housekeeping" class="sblink">Maintenance</a> &gt; <a href="/cms-special/admin/housekeeping/reset" class="sblink">Réinitialiser</a></div>
        <h2>Réinitialiser votre site</h2>
        <div id="page-confirm">
            <center><p>Cette action aura pour effet de supprimer :<ul><li>toutes les pages de votre site</li><li>toutes les images des galeries de photo</li><li>les images de l'îcone et de la bannière</li><li>les informations du nom de votre site, et le pied de page</li></ul></p>
            <p><b>Entrez le nom de votre site dans le champ suivant pour pouvoir le réinitialiser :</b></p><input id="confirm" onkeyup="validate()" onkeydown="validate()" onchange="validate()" type="text" placeholder="Nom de votre site"></center>
            <p><center><a onclick="confirmPass()" id="reset-confirm" class="hide button-dangerous">Réinitialiser</a></center></p>
        </div>
        <div id="page-select" class="hide">
            Sélectionnez comment nous devons réinitialiser votre site :
            <div class="reset-option" onclick="resetKeep()">
                <b>Conserver le contenu</b>
                <p>Réinitialise la configuration de votre site et conserve le contenu que vous y avez inséré. Utile si vous rencontrez des problèmes avec votre site ou que vous avez besoin d'espace disque suplémentaire.</p>
            </div>
            <div class="reset-option" onclick="resetClear()">
                <b>Tout supprimer</b>
                <p>Supprimer toutes les données de votre site et vous redirige vers l'utilitaire de première configuration. Utile si vous souhaitez recréer votre site depuis le début, ou qu'une mise à jour a causé des problèmes.</p>
            </div>
        </div>
    </div>
    <div class="hide" id="resetbox-placeholder">
        <div id="resetbox" class="centered">
            <p>La réinitialisation de votre site est en cours...</p>
            <div id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
            <p><small>Ne quittez pas cette page<br><span id="reset-message">-</span></small></p>
        </div>
    </div>
</body>
</html>

<script>

function resetKeep() {
    document.getElementById('reset-message').innerHTML = "Conserver le contenu"
    progressbox(true)
    var formData = new FormData();
    formData.append("keep", "1");
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/reset.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/resetted";
            } else {
                alert("Erreur : " + data + "\n\nVotre site risque d'être endommagé")
                Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
                progressbox(false)
            }
        },
        error: function (error) {
            alert("Erreur de communication\n\nAucune modification n'a été apportée à votre site")
            progressbox(false)
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function resetClear() {
    document.getElementById('reset-message').innerHTML = "Tout supprimer"
    progressbox(true)
    var formData = new FormData();
    formData.append("keep", "0");
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/reset.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/resetted";
            } else {
                alert("Erreur : " + data + "\n\nVotre site risque d'être endommagé")
                Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
                progressbox(false)
            }
        },
        error: function (error) {
            alert("Erreur de communication\n\nAucune modification n'a été apportée à votre site")
            progressbox(false)
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function progressbox(toggle) {
    if (typeof toggle != "boolean") {
        throw new TypeError("Argument 1 expected to be boolean, " + typeof toggle + " given")
    } else {
        if (toggle) {
            $('#resetbox-placeholder').fadeIn(200)
            document.getElementById('settings').classList.add('blurred')
        } else {
            $('#resetbox-placeholder').fadeOut(200)
            document.getElementById('settings').classList.remove('blurred')
        }
    }
}

function confirmPass() {
    document.getElementById('page-confirm').classList.add('hide')
    document.getElementById('page-select').classList.remove('hide')
}

function validate() {
    if (document.getElementById('confirm').value == "<?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename") ?>") {
        document.getElementById('reset-confirm').classList.remove('hide')
    } else {
        document.getElementById('reset-confirm').classList.add('hide')
    }
}

document.getElementById('confirm').value = ""

</script>