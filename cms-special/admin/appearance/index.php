<?php

$invalid = false;

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {

    } else {
        die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/appearance&pa='</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/appearance&pa='</script>");
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
    <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/balloon/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/balloon/translations/fr.js"></script>
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
    </div><div id="navigation"><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/appearance" class="sblink">Apparance</a></div>
        <h2>Apparance du site</h2>
        <span id="appearance-error-box" class="hide"><div id="error"><span id="appearance-error">Erreur inconnue</span></div></span>
        <div id="appearance-settings"><center>
            Nom du site : <input onchange="validateName()" onkeyup="validateName()" onkeydown="validateName()" type="text" id="name-field" placeholder="Nom du site" value="<?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename") ?>"><br><p id="04-name-tip" class="tip-red">Le nom ne peut pas être vide</p>
            <input type="file" id="icon-file" class="hide">
            <p><img id="icon-img" src="/resources/image/config_file_replace.svg" onclick="Icon_UploadFile()" class="icon_button"><br><small>Modifier l'îcone</small></p>
            <input type="file" id="banner-file" class="hide">
            <p><img id="icon-img" src="/resources/image/config_file_replace.svg" onclick="Banner_UploadFile()" class="icon_button"><br><small>Modifier la bannière</small></p>
            <p><input type="checkbox" id="alwaysmenu" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/alwaysmenu")) {echo("checked");} ?>><label for="alwaysmenu">Afficher le lanceur même sur l'interface de bureau</label></p><br>
            <a onclick="submitData()" class="button">Sauvegarder</a>
        </center></div>
        <center><div id="appearance-loader" class="hide"><img src="/resources/image/loader.svg" class="loader"></div></center>
        <h2>Modifier le pied de page</h2>
        <span id="footer-error-box" class="hide"><div id="error"><span id="footer-error">Erreur inconnue</span></div></span>
        <div id="footer-settings"><center>
        <center>Ce pied de page s'affiche sur toutes les pages de votre site</center>
            <div name="content" id="editor">
                <?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/footer") ?>
            </div><br>
            <a onclick="updateFooter()" class="button">Publier</a>
            <script>
        let editor;
        BalloonEditor
            .create( document.querySelector( '#editor' ), {
                language: {
                    ui: 'fr',
                    content: 'fr'
                },
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'link', '|', 'mediaembed', 'blockquote', 'inserttable', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo'
                ]
            } )
            .then( newEditor => {
                editor = newEditor;
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
        </center></div>
        <center><div id="footer-loader" class="hide"><img src="/resources/image/loader.svg" class="loader"></div></center>
        <h2>Modifier le mot de passe</h2>
        <span id="password-error-box" class="hide"><div id="error"><span id="password-error">Erreur inconnue</span></div></span>
        <div id="password-settings"><center>
            <p>Ancien mot de passe : <input type="password" id="old-password" placeholder="Ancien mot de passe"></p>
            <p>Nouveau mot de passe : <input type="password" id="new-password" placeholder="Nouveau mot de passe"></p>
            <p>Répétez le mot de passe : <input type="password" id="repeat-password" placeholder="Répétez le mot de passe"></p>
            <a onclick="changePassword()" class="button">Changer le mot de passe</a>
        </center></div>
        <center><div id="password-loader" class="hide"><img src="/resources/image/loader.svg" class="loader"></div></center>
    </div>
</body>
</html>

<script>

function validateName() {
    document.getElementById('04-name-tip').classList.remove('tip-orange')
    document.getElementById('04-name-tip').classList.remove('tip-green')
    document.getElementById('04-name-tip').classList.remove('tip-red')
    document.getElementById('04-name-tip').innerHTML = "...";
    setTimeout(() => {
        name = document.getElementById('name-field').value
        if (name.trim() == "") {
            document.getElementById('04-name-tip').classList.add('tip-red')
            document.getElementById('04-name-tip').innerHTML = "Le nom ne peut pas être vide";
            return;
        }
        if (name.includes("<") || name.includes(">") || name.includes("#") || name.includes("@") || name.includes("}") || name.includes("{") || name.includes("|")) {
            document.getElementById('04-name-tip').classList.add('tip-red')
            document.getElementById('04-name-tip').innerHTML = "Le nom contient des charactères invalides";
            return;
        }
        if (name.length > 75) {
            document.getElementById('04-name-tip').classList.add('tip-red')
            document.getElementById('04-name-tip').innerHTML = "Le nom est trop long";
            return;
        }
        if (name.length < 4) {
            document.getElementById('04-name-tip').classList.add('tip-orange')
            document.getElementById('04-name-tip').innerHTML = "Nom plus long recommandé";
            return;
        }
        if (name.length > 30) {
            document.getElementById('04-name-tip').classList.add('tip-orange')
            document.getElementById('04-name-tip').innerHTML = "Nom plus court recommandé";
            return;
        }
        document.getElementById('04-name-tip').classList.add('tip-green')
        document.getElementById('04-name-tip').innerHTML = "Ce nom semble parfait";
        return;
    }, 100)
}

function Icon_UploadFile() {
    $("#icon-file").trigger('click');
}

function Banner_UploadFile() {
    $("#banner-file").trigger('click');
}

function submitData() {
    document.getElementById('appearance-loader').classList.remove('hide')
    document.getElementById('appearance-settings').classList.add('hide')
    var formData = new FormData();
    if (document.getElementById('icon-file').value.trim() != "") {
        formData.append("icon", document.getElementById('icon-file').files[0], document.getElementById('icon-file').files[0].name);
    }
    if (document.getElementById('banner-file').value.trim() != "") {
        formData.append("banner", document.getElementById('banner-file').files[0], document.getElementById('banner-file').files[0].name);
    }
    formData.append("sitename", document.getElementById('name-field').value);
    formData.append("alwaysmenu", document.getElementById('alwaysmenu').checked.toString());
    document.getElementById('appearance-error-box').classList.add("hide")
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/appearance.php",
        success: function (data) {
            if (data == "ok") {
                location.reload()
            } else {
                document.getElementById('appearance-error').innerHTML = data
                document.getElementById('appearance-error-box').classList.remove("hide")
                document.getElementById('appearance-loader').classList.add('hide')
                document.getElementById('appearance-settings').classList.remove('hide')
            }
        },
        error: function (error) {
            document.getElementById('password-error').innerHTML = "Erreur de communication"
            document.getElementById('password-error-box').classList.remove("hide")
            document.getElementById('password-loader').classList.add('hide')
            document.getElementById('password-settings').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function changePassword() {
    document.getElementById('password-loader').classList.remove('hide')
    document.getElementById('password-settings').classList.add('hide')
    var formData = new FormData();
    formData.append("oldpass", document.getElementById('old-password').value);
    formData.append("newpass", document.getElementById('new-password').value);
    formData.append("newpassr", document.getElementById('repeat-password').value);
    document.getElementById('password-error-box').classList.add("hide")
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/password.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin";
            } else {
                document.getElementById('password-error').innerHTML = data
                document.getElementById('password-error-box').classList.remove("hide")
                document.getElementById('password-loader').classList.add('hide')
                document.getElementById('password-settings').classList.remove('hide')
            }
        },
        error: function (error) {
            document.getElementById('password-error').innerHTML = "Erreur de communication"
            document.getElementById('password-error-box').classList.remove("hide")
            document.getElementById('password-loader').classList.add('hide')
            document.getElementById('password-settings').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function updateFooter() {
    document.getElementById('footer-loader').classList.remove('hide')
    document.getElementById('footer-settings').classList.add('hide')
    var formData = new FormData();
    formData.append("footer", editor.getData());
    document.getElementById('footer-error-box').classList.add("hide")
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/footer.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/appearance";
            } else {
                document.getElementById('footer-error').innerHTML = data
                document.getElementById('footer-error-box').classList.remove("hide")
                document.getElementById('footer-loader').classList.add('hide')
                document.getElementById('footer-settings').classList.remove('hide')
            }
        },
        error: function (error) {
            document.getElementById('footer-error').innerHTML = "Erreur de communication"
            document.getElementById('footer-error-box').classList.remove("hide")
            document.getElementById('footer-loader').classList.add('hide')
            document.getElementById('footer-settings').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

validateName()

document.getElementById('banner-file').value = ""
document.getElementById('icon-file').value = ""

</script>