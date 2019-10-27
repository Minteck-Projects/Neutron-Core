<?php

$invalid = false;

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {

    } else {
        die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/plugins/widget-contact-configure&pa='</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/plugins/widget-contact-configure&pa='</script>");
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
    <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/translations/fr.js"></script>
    <title><?php
    
    if ($ready) {
        echo("Paramètres du widget - Extensions - Administration du site - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
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
    </div><div id="navigation"><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/plugins" class="sblink">Extensions</a> &gt; <a href="/cms-special/admin/widgets/widget-contact-configure" class="sblink"><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/contact/name") ?></a></div>
        <h2>Paramètres du widget</h2>
        <p>Entrez les informations de contact que vous souhaitez fournir à vos visiteurs. Laissez vide les champs que vous ne souhaitez pas afficher</p>
        <div id="data">
        <?php
        
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-contact-data")) {
            $data = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-contact-data");
            $parts = explode('|', $data);
        }

        ?>
            <table>
                <tbody>
                    <tr>
                        <td>Numéro de téléphone : </td>
                        <td><input type="text" id="phone" placeholder="ex: +33 1 23 45 67 89" value="<?php if (isset($parts)) {echo($parts[0]);} ?>"></td>
                    </tr>
                    <tr>
                        <td>Adresse email : </td>
                        <td><input type="text" id="email" placeholder="ex: contact@example.com" value="<?php if (isset($parts)) {echo($parts[1]);} ?>"></td>
                    </tr>
                    <tr>
                        <td>Adresse postale : </td>
                        <td><input type="text" id="address" placeholder="ex: 123 Rue du Test, Paris, France" value="<?php if (isset($parts)) {echo($parts[2]);} ?>"></td>
                    </tr>
                    <tr>
                        <td>Personne à contacter en cas de nécessité : </td>
                        <td><input type="text" id="people" placeholder="ex: John Doe" value="<?php if (isset($parts)) {echo($parts[3]);} ?>"></td>
                    </tr>
                </tbody>
            </table>
            <p><center><a class="button" onclick="saveChanges()" title="Sauvegarder la configuration du widget">Sauvegarder</a></center></p>
        </div>
        <div class="hide" id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
    </div>
</body>
</html>

<script>

function saveChanges() {
    document.getElementById('data').classList.add('hide')
    document.getElementById('loader').classList.remove('hide')
    var formData = new FormData();
    formData.append("phone", document.getElementById('phone').value);
    formData.append("email", document.getElementById('email').value);
    formData.append("address", document.getElementById('address').value);
    formData.append("people", document.getElementById('people').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/widget-contact-configure.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/widgets"
            } else {
                alert("Erreur : " + data);
                document.getElementById('data').classList.remove('hide')
                document.getElementById('loader').classList.add('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication");
            document.getElementById('data').classList.remove('hide')
            document.getElementById('loader').classList.add('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>