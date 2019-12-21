<?php

$invalid = false;

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {

    } else {
        die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/calendar/add&pa='</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/calendar/add&pa='</script>");
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
        echo("Ajouter un événement - Calendrier - Administration du site - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
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
    </div><div id="navigation"><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/calendar" class="sblink">Calendrier</a> &gt; <a href="/cms-special/admin/calendar/zff" class="sblink">Ajouter un événement</a></div>
        <h2>Ajouter un événement</h2>
        <div id="datainput">
            <h3>Date</h3>
            <ul>
                <li>Jour : </li>
                <select id="day">
                    <option value="01" <?php if ("01" == date('d')) {echo("selected");} ?>>1er</option>
                    <option value="02" <?php if ("02" == date('d')) {echo("selected");} ?>>2</option>
                    <option value="03" <?php if ("03" == date('d')) {echo("selected");} ?>>3</option>
                    <option value="04" <?php if ("04" == date('d')) {echo("selected");} ?>>4</option>
                    <option value="05" <?php if ("05" == date('d')) {echo("selected");} ?>>5</option>
                    <option value="06" <?php if ("06" == date('d')) {echo("selected");} ?>>6</option>
                    <option value="07" <?php if ("07" == date('d')) {echo("selected");} ?>>7</option>
                    <option value="08" <?php if ("08" == date('d')) {echo("selected");} ?>>8</option>
                    <option value="09" <?php if ("09" == date('d')) {echo("selected");} ?>>9</option>
                    <option value="10" <?php if ("10" == date('d')) {echo("selected");} ?>>10</option>
                    <option value="11" <?php if ("11" == date('d')) {echo("selected");} ?>>11</option>
                    <option value="12" <?php if ("12" == date('d')) {echo("selected");} ?>>12</option>
                    <option value="13" <?php if ("13" == date('d')) {echo("selected");} ?>>13</option>
                    <option value="14" <?php if ("14" == date('d')) {echo("selected");} ?>>14</option>
                    <option value="15" <?php if ("15" == date('d')) {echo("selected");} ?>>15</option>
                    <option value="16" <?php if ("16" == date('d')) {echo("selected");} ?>>16</option>
                    <option value="17" <?php if ("17" == date('d')) {echo("selected");} ?>>17</option>
                    <option value="18" <?php if ("18" == date('d')) {echo("selected");} ?>>18</option>
                    <option value="19" <?php if ("19" == date('d')) {echo("selected");} ?>>19</option>
                    <option value="20" <?php if ("20" == date('d')) {echo("selected");} ?>>20</option>
                    <option value="21" <?php if ("21" == date('d')) {echo("selected");} ?>>21</option>
                    <option value="22" <?php if ("22" == date('d')) {echo("selected");} ?>>22</option>
                    <option value="23" <?php if ("23" == date('d')) {echo("selected");} ?>>23</option>
                    <option value="24" <?php if ("24" == date('d')) {echo("selected");} ?>>24</option>
                    <option value="25" <?php if ("25" == date('d')) {echo("selected");} ?>>25</option>
                    <option value="26" <?php if ("26" == date('d')) {echo("selected");} ?>>26</option>
                    <option value="27" <?php if ("27" == date('d')) {echo("selected");} ?>>27</option>
                    <option value="28" <?php if ("28" == date('d')) {echo("selected");} ?>>28</option>
                    <option value="29" <?php if ("29" == date('d')) {echo("selected");} ?>>29</option>
                    <option value="30" <?php if ("30" == date('d')) {echo("selected");} ?>>30</option>
                    <option value="31" <?php if ("31" == date('d')) {echo("selected");} ?>>31</option>
                </select><br><br>
                <li>Mois : </li>
                <select id="month">
                    <option disabled>1er trimestre</option>
                    <option value="1" <?php if ("01" == date('m')) {echo("selected");} ?>>Janvier</option>
                    <option value="2" <?php if ("02" == date('m')) {echo("selected");} ?>>Février</option>
                    <option value="3" <?php if ("03" == date('m')) {echo("selected");} ?>>Mars</option>
                    <option disabled>2ème trimestre</option>
                    <option value="4" <?php if ("04" == date('m')) {echo("selected");} ?>>Avril</option>
                    <option value="5" <?php if ("05" == date('m')) {echo("selected");} ?>>Mai</option>
                    <option value="6" <?php if ("06" == date('m')) {echo("selected");} ?>>Juin</option>
                    <option disabled>3ème trimestre</option>
                    <option value="7" <?php if ("07" == date('m')) {echo("selected");} ?>>Juillet</option>
                    <option value="8" <?php if ("08" == date('m')) {echo("selected");} ?>>Août</option>
                    <option value="9" <?php if ("09" == date('m')) {echo("selected");} ?>>Septembre</option>
                    <option disabled>4ème trimestre</option>
                    <option value="10" <?php if ("10" == date('m')) {echo("selected");} ?>>Octobre</option>
                    <option value="11" <?php if ("11" == date('m')) {echo("selected");} ?>>Novembre</option>
                    <option value="12" <?php if ("12" == date('m')) {echo("selected");} ?>>Décembre</option>
                </select><br><br>
                <li>Année :</li>
                <select id="year">
                    <option value="<?= date('Y') ?>" selected><?= date('Y') ?></option>
                    <option value="<?= date('Y') + 1 ?>"><?= date('Y') + 1 ?></option>
                    <option value="<?= date('Y') + 2 ?>"><?= date('Y') + 2 ?></option>
                    <option value="<?= date('Y') + 3 ?>"><?= date('Y') + 3 ?></option>
                    <option value="<?= date('Y') + 4 ?>"><?= date('Y') + 4 ?></option>
                    <option value="<?= date('Y') + 5 ?>"><?= date('Y') + 5 ?></option>
                </select>
            </ul>
            <h3>Informations</h3>
            <ul>
                <li>Nom de l'événement :</li>
                <input type="text" placeholder="Nom de l'événement" id="name"><br><br>
                <li>Description <i>(facultatif)</i> :</li>
                <input type="text" placeholder="Description" id="desc"><br><br>
                <li>Adresse du lien <i>(facultatif)</i> :</li>
                <input onchange="validateUrl()" onkeyup="validateUrl()" onkeydown="validateUrl()" type="text" placeholder="Lien externe" id="link"><img id="link_check" src="/resources/image/storeloader.svg" style="vertical-align:middle;" class="hide" width="24px" height="24px"><a class="hide" id="link_invalid" title="L'adresse du lien est invalide"><img src="/resources/image/close.svg" style="vertical-align:middle;" class="invert" width="24px" height="24px"></a>
            </ul>
            <p><table class="message_info"><tbody><tr><td><img src="/resources/image/message_info.svg" class="message_img"></td><td style="width:100%;"><p>La description de l'événement s'affichera entièrement sur le widget "Prochains événements", nous vous conseillons donc de ne pas écrire une description trop longue</p></td></tr></tbody></table></p>
            <center><p><a class="button" onclick="createCmsEvent()">Ajouter l'événement</a></p></center><br>
        </div>
    </div>
</body>
</html>

<script>

function UrlRegex(str) {
  var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
    '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
    '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
    '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
  return !!pattern.test(str);
}

function validateUrl() {
    document.getElementById('link_invalid').classList.add('hide');
    document.getElementById('link_check').classList.remove('hide');
    setTimeout(() => {
        if (!UrlRegex(document.getElementById('link').value)) {
            document.getElementById('link_invalid').classList.remove('hide');
        } else {
            document.getElementById('link_invalid').classList.add('hide');
        }
        document.getElementById('link_check').classList.add('hide');
    }, 2000)
}

function createCmsEvent() {
    document.getElementById('datainput').classList.add('hide')
    var formData = new FormData();
    formData.append("day", document.getElementById('day').value);
    formData.append("month", document.getElementById('month').value);
    formData.append("year", document.getElementById('year').value);
    formData.append("name", document.getElementById('name').value);
    formData.append("desc", document.getElementById('desc').value);
    formData.append("link", document.getElementById('link').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/calendar_create.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/calendar";
            } else {
                alert("Erreur : " + data + "\n\nLa base de données du calendrier est peut être corrompue")
                document.getElementById('datainput').classList.remove('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication\n\nRien a été modifié dans le calendrier")
            document.getElementById('datainput').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>