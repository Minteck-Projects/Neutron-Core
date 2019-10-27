<?php

function getAvgLuminance($filename, $num_samples=30) {
    // needs a mimetype check
    $img = imagecreatefromjpeg($filename);
    $width = imagesx($img);
    $height = imagesy($img);
    $x_step = intval($width/$num_samples);
    $y_step = intval($height/$num_samples);
    $total_lum = 0;
    $sample_no = 1;
    for ($x=0; $x<$width; $x+=$x_step) {
        for ($y=0; $y<$height; $y+=$y_step) {
            $rgb = imagecolorat($img, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            // choose a simple luminance formula from here
            // http://stackoverflow.com/questions/596216/formula-to-determine-brightness-of-rgb-color
            $lum = ($r+$r+$b+$g+$g+$g)/6;
            $total_lum += $lum;
            $sample_no++;
        }
    }
    // work out the average
    $avg_lum  = $total_lum / $sample_no;
    return ($avg_lum / 255) * 100;
}

?>
<?php echo("<!--\n\n" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/license") . "\n\n-->") ?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    $ready = true;
} else {
    $ready = false;
}

// $ready = false; // Switch to 'false' to test the OOBE

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php

    if ($ready) {
        echo('<link rel="stylesheet" href="/resources/css/main.css">');
        echo('<link rel="stylesheet" href="/resources/lib/pushbar.js/library.css">');
        echo('<script src="/resources/lib/pushbar.js/library.js"></script>');
        echo('<link rel="shortcut icon" href="/resources/upload/siteicon.png" type="image/png">');
    } else {
        echo('<link rel="stylesheet" href="/resources/css/ready.css">');
    }

    ?>
    <link rel="stylesheet" href="/resources/css/fonts-import.css">
    <link rel="stylesheet" href="/resources/css/ui.css">
    <title><?php
    
    if ($ready) {
        echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
    } else {
        echo("Votre site est presque prêt - MPCMS");
    }

    ?></title>
    <?php
    
    if ($ready) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/header.php";
    }
    
    ?>
</head>
<body>
    <?php

    if (!$ready) {
        die('<div class="centered discover"><h1>Minteck Projects CMS</h1><h3>La nouvelle génération de sites Web</h3><p>Tous les fichiers ont été copiés correctement, vous devez maintenant configurer le logiciel Minteck Projects CMS.</p><p>Pour cela, nous vous conseillons d\'utiliser un ordinateur, ou tout autre appareil avec un écran plus grand.</p><a href="/cms-special/setup"><img src="/resources/image/config_explore.svg">Configurer</a><br><br><hr><small>' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version") . '</small></div>');
    }
    
    if ($ready) {
        echo("<script type=\"text/javascript\">\nvar pushbar = new Pushbar({\nblur:true,\noverlay:true,\n});\n</script>");
    }
    

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/banner.jpg")) {
        $banner = "/resources/upload/banner.jpg";
        if (getAvgLuminance($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/banner.jpg") > 50) {
            $blackBannerText = true;
        } else {
            $blackBannerText = false;
        }
    } else {
        $banner = "/resources/image/default.jpg";
        if (getAvgLuminance($_SERVER['DOCUMENT_ROOT'] . "/resources/image/default.jpg") > 50) {
            $blackBannerText = true;
        } else {
            $blackBannerText = false;
        }
    }

    ?>
    <div id="always-on-top">
        <div id="siteadmin"><span class="branding-desktop">fonctionne sur Minteck Projects CMS <?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version") ?></span><span class="branding-mobile">MPCMS <?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version") ?></span><a href="/cms-special/admin" id="siteadmin-button"><img id="siteadmin-img" src="/resources/image/admin.svg">Administration du site</a></div>
        <div id="menubar"><span class="menubar-link menubar-mobile" id="menubar-link-navigation" onclick="pushbar.open('panel-navigation')"><img src="/resources/image/menu.svg" class="menubar-img"><span class="menubar-link-text">Menu</span></span>
        <?php
        
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/alwaysmenu")) {
            echo('<span class="menubar-link menubar-desktop" id="menubar-link-navigation" onclick="pushbar.open(\'panel-navigation\')"><img src="/resources/image/menu.svg" class="menubar-img"><span class="menubar-link-text">Menu</span></span>');
        } else {
            $count = 0;
            echo('<a href="/" title="/" class="menulink-desktop">Accueil</a>');
            $count = $count + 1;

            $pages = scandir($_SERVER['DOCUMENT_ROOT']);
            foreach ($pages as $page) {
                if ($page != ".." && $page != ".") {
                    if (is_dir($_SERVER['DOCUMENT_ROOT'] . "/" . $page)) {
                        if ($count < 4) {
                            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename")) {
                                if (!in_array($page, $customSettings->PagesMasquées)) {
                                    echo("<a href=\"/{$page}\" title=\"/{$page}\" class=\"menulink-desktop\">" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename") . "</a>");
                                    $count = $count + 1;
                                }
                            }
                        }
                    }
                }
            }
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/enabled")) {echo("<a href=\"/cms-special/galery\" title=\"/cms-special/galery\" class=\"menulink-desktop\">Galerie de photos</a>");$count = $count + 1;}
            if ($count >= 5) {
                echo("<a onclick=\"pushbar.open('panel-navigation')\" title=\"Ouvrir le menu\" class=\"menulink-desktop\">Plus...</a>");
            }
        }
        
        ?>
        <?php

$widgets = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json"));
if (!empty($widgets->list)) {
    echo("<span class=\"menubar-link\" id=\"menubar-link-tools\" onclick=\"pushbar.open('panel-sidebar')\"><img src=\"/resources/image/tools.svg\" class=\"menubar-img\"><span class=\"menubar-link-text\">Détails</span></span>");
}

?></div>
    </div>
    <div id="banner" style='background-image: url("<?= $banner ?>");'>
        <img id="banner-logo" src="/resources/upload/siteicon.png"><span id="banner-name" <?php if ($blackBannerText) {echo("class=\"banner-black\"");} ?>><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename") ?></span>
    </div>
    <div data-pushbar-id="panel-navigation" class="pushbar from_left">
        <div id="banner-menu" style='background-image: url("<?= $banner ?>");'>
            <img id="banner-menu-logo" src="/resources/upload/siteicon.png"><span id="banner-menu-name" <?php if ($blackBannerText) {echo("class=\"banner-black\"");} ?>><?php
            
            $sitename = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename");

            if (strlen($sitename) < 15) {
                echo($sitename);
            } else {
                echo(substr($sitename, 0, 14) . "...");
            }
            
            ?></span>
        </div>
        <img src="/resources/image/close.svg" id="menubar-close" onclick="pushbar.close()">
        <br>
        <a href="/" title="/" class="menu-link">Accueil</a>
        <?php

        $pages = scandir($_SERVER['DOCUMENT_ROOT']);
        foreach ($pages as $page) {
            if ($page != ".." && $page != ".") {
                if (is_dir($_SERVER['DOCUMENT_ROOT'] . "/" . $page)) {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename")) {
                        if (!in_array($page, $customSettings->PagesMasquées)) {
                            echo("<a href=\"/{$page}\" title=\"/{$page}\" class=\"menu-link\">" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename") . "</a>");
                        }
                    }
                }
            }
        }
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/enabled")) {echo("<a href=\"/cms-special/galery\" title=\"/cms-special/galery\" class=\"menu-link\">Galerie de photos</a>");}

        ?>
	</div>
	<div data-pushbar-id="panel-sidebar" class="pushbar from_right">
        <img src="/resources/image/close.svg" id="sidebar-close" onclick="pushbar.close()">
        <span id="sidebar-title">Détails du site</span>
        <span id="sidebar-separator"></span>
        <span id="sidebar-widgets">
            <?php

            if (isset($_COOKIE['ADMIN_TOKEN'])) {
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {
                    echo('<p><table class="message_info"><tbody><tr><td><img src="/resources/image/message_info.svg" class="message_img"></td><td style="width:100%;"><p>Vous êtes encore connecté à l\'administration de votre site, cliquez <a href="/cms-special/admin/logout" style="color:inherit;text-decoration:none;">ici</a> pour vous déconnecter</p></td></tr></tbody></table></p>');
                }
            }

            ?>
            <?php
                $config = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json"));
                foreach ($config->list as $widget) {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/source.php")) {
                        include_once $_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/source.php";
                    }
                }
            ?>
        </span>
	</div>
    <div id="page-placeholder">
        <div id="page-content">
            <?php
            
            $html_string = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/index");
            preg_match_all('#<h[1-6]*[^>]*>.*?<\/h[1-6]>#',$html_string,$results);

            $toc = implode("\n",$results[0]);
            $toc = preg_replace('#<h2>#','<li class="toc$1" style="margin-left: 0px;">',$toc);
            $toc = preg_replace('#<\/h2>#','</li>',$toc);
            $toc = preg_replace('#<h3>#','<li class="toc$1" style="margin-left: 20px;">',$toc);
            $toc = preg_replace('#<\/h3>#','</li>',$toc);
            $toc = preg_replace('#<h4>#','<li class="toc$1" style="margin-left: 40px;">',$toc);
            $toc = preg_replace('#<\/h4>#','</li>',$toc);
            $toc = preg_replace('#<h5>#','<li class="toc$1" style="margin-left: 60px;">',$toc);
            $toc = preg_replace('#<\/h5>#','</li>',$toc);
            $toc = preg_replace('#<h6>#','<li class="toc$1" style="margin-left: 80px;">',$toc);
            $toc = preg_replace('#<\/h6>#','</li>',$toc);
        
            $toc = '<div id="toc"> 
            <h3>Table des matières</h3>
            <ul>
            '.$toc.'
            </ul>
            </div><hr>';
        
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_toc")) {
                echo($toc);
            }
            
            ?>
            <?php echo($html_string); ?>
        </div>
        <div id="page-footer">
        <?php echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/footer")); ?>
        </div>
    </div>
</body>
</html>