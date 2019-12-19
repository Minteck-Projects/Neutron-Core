<?php

$invalid = false;

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {

    } else {
        die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/calendar&pa='</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/calendar&pa='</script>");
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
        echo("Calendrier - Administration du site - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
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
    </div><div id="navigation"><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/calendar" class="sblink">Calendrier</a></div>
        <h2>Ajouter/supprimer des événements</h2>
        <?php
        
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/calendar_events")) {
            $calevn = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/calendar_events");
        } else {
            $calevn = "3";
        }
        
        ?>
        Afficher les <select onchange="updateNextEvents()" id="nextevents">
            <option value="1" <?php if ($calevn == "1") { echo("selected"); } ?>>1</option>
            <option value="2" <?php if ($calevn == "2") { echo("selected"); } ?>>2</option>
            <option value="3" <?php if ($calevn == "3") { echo("selected"); } ?>>3</option>
            <option value="4" <?php if ($calevn == "4") { echo("selected"); } ?>>4</option>
            <option value="5" <?php if ($calevn == "5") { echo("selected"); } ?>>5</option>
            <option value="6" <?php if ($calevn == "6") { echo("selected"); } ?>>6</option>
            <option value="7" <?php if ($calevn == "7") { echo("selected"); } ?>>7</option>
            <option value="8" <?php if ($calevn == "8") { echo("selected"); } ?>>8</option>
            <option value="9" <?php if ($calevn == "9") { echo("selected"); } ?>>9</option>
            <option value="10" <?php if ($calevn == "10") { echo("selected"); } ?>>10</option>
        </select> prochains événements dans le widget.
        <h3>Événements</h3>
        <ul>
        <?php
        
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json")) {
            $dbraw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json");
            $corrupted = false;
            if (isJson($dbraw)) {
                $events = json_decode($dbraw);
                foreach ($events->events as $event) {
                    if (isset($event->timestamp)) {
                        echo("<li><span style=\"cursor:help;\" title=\"" . $event->description . "\">" . $event->name . "</span> (" . $event->datestr . ")" . " - <a class=\"sblink\" href=\"/cms-special/admin/calendar/manage/?id=" . $event->timestamp . "\" title=\"Supprimer l'événément\">Gérer</a></li>");
                    }
                }
            } else {
                echo("<center style=\"color:red;\"><b><u>Important :</u> La base de données du calendrier semble corrompue. Si vous n'avez pas effectué d'actions particulières récemment, cela peut venir de corruption du disque ou d'une intrusion dans votre serveur. <u>Contactez votre administrateur réseau</u></b></center>");
                $corrupted = true;
            }
        } else {
            echo("<center>Aucun événement dans le calendrier pour le moment</center>");
        }

        ?>
        <?php
        
        if (!$corrupted) {
            echo('<br><li><i><a href="/cms-special/admin/calendar/add" title="Ajouter un nouvel événement au calendrier" class="sblink">Ajouter un nouvel événement</a></i></li>');
        }
        
        ?>
        </ul>
    </div>
</body>
<script>

function updateNextEvents() {
    value = document.getElementById('nextevents').value;
    var formData = new FormData();
    formData.append("value", value);
    document.getElementById('nextevents').disabled = true;
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/calendar_nextevents.php",
        success: function (data) {
            if (data == "ok") {
                document.getElementById('nextevents').disabled = false;
            } else {
                alert("Erreur : " + data)
                document.getElementById('nextevents').disabled = false;
            }
        },
        error: function (error) {
            alert("Erreur de communication")
            document.getElementById('nextevents').disabled = false;
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>
</html>