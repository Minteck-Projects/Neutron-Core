<?php

$invalid = false;

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {

    } else {
        die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/plugins&pa='</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/plugins&pa='</script>");
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
        echo("Extensions - Administration du site - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
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
    </div><div id="navigation"><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/plugins" class="sblink">Extensions</a></div>
        <h2>Extensions installés</h2>
        <p><table class="message_info"><tbody><tr><td><img src="/resources/image/message_info.svg" class="message_img"></td><td style="width:100%;"><p>Minteck Projects CMS dispose du support d'extensions, qui vous permettent de modifier les fonctionnalités et/ou le comportement du logiciel, ou d'afficher des widgets supplémentaires dans la barre des widgets (sortes d'informations enrichies qui sont affichés à la suite)</p></td></tr></tbody></table></p>
        <?php

        $widgets = scandir($_SERVER['DOCUMENT_ROOT'] . "/widgets/");
        $json = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json"));
        foreach ($widgets as $widget) {
            if ($widget != "." && $widget != ".." && $widget != ".htaccess") {
                echo("<div class=\"widget\"><div id=\"header-{$widget}\" class=\"widget-header ");
                if (array_search($widget, $json->list) === false) {
                    echo("disabled");
                } else {
                    echo("enabled");
                }
                echo("\"><table><tbody><tr><td><input type=\"checkbox\" onclick=\"updateWidgetStatus('" . $widget . "')\" name=\"" . $widget . "\"");
                if (array_search($widget, $json->list) === false) {} else {
                    echo("checked");
                }
                $size = filesize($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/name") + filesize($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/description") + filesize($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/author") + filesize($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/source.php");
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/config")) {
                    $size = $size + filesize($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/config");
                }
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/dependancies")) {
                    $deps = explode(':', file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/dependancies"));
                    foreach ($deps as $dep) {
                        $size = $size + filesize($_SERVER['DOCUMENT_ROOT'] . $dep);
                    }
                }
                $sizestr = $size . " octets";if ($size > 1024) {if ($size > 1048576) {if ($size > 1073741824) {$sizestr = round($size / 1073741824, 2) . " Gio";} else {$sizestr = round($size / 1048576, 2) . " Mio";}} else {$sizestr = round($size / 1024, 2) . " Kio";}} else {$sizestr = $size . " octets";}$sizestr = str_replace(".", ",", $sizestr);
                echo("></td><td><label for=\"" . $widget . "\"><b>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/name") . "</b></label><br>par <b>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/author") . "</b>");
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/cms-store")) {
                    echo(", installé via le CMS Store");
                }
                echo("<i> (" . $sizestr . ")</i></td></tr></tbody></table></div><p>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/description") . "</p>");
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/config")) {
                    echo("<p><a href=\"" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/config") . "\" title=\"Modifier les paramètres de cette extension\" class=\"sblink\">Configurer...</a></p>");
                }
                echo("</div>");
            }
        }
        
        ?>
        
    </div>
</body>
</html>

<script>

function updateWidgetStatus(widget) {
    checkbox = document.getElementsByName(widget)[0]
    if (typeof checkbox == "undefined") {} else {
        if (checkbox.checked) {
            document.getElementById('header-' + widget).classList.remove('disabled');
            document.getElementById('header-' + widget).classList.add('enabled');
        } else {
            document.getElementById('header-' + widget).classList.remove('enabled');
            document.getElementById('header-' + widget).classList.add('disabled');
        }
        Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = true})

        var formData = new FormData();
        formData.append("element", widget);
        formData.append("value", checkbox.checked.toString());
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/widgets.php",
            success: function (data) {
                if (data == "ok") {
                    console.log("Sauvegardé avec succès")
                    setTimeout(() => {
                        Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
                    }, 500)
                } else {
                    alert("Erreur : " + data);
                }
            },
            error: function (error) {
                alert("Erreur de communication");
                window.onbeforeunload = undefined;
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });

    }
}

</script>