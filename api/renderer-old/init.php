<?php

if ((!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-old.mtd") || (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-full.mtd") && strpos(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-old.mtd"), "<a") === false)) || (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-full.mtd") || (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-full.mtd") && strpos(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-full.mtd"), "|") === false)) || (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-old.mtd") || (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist.mtd") && strpos(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist.mtd"), "|") === false))) {
    rlgps("Regenerating pages cache");
    require_once $_SERVER['DOCUMENT_ROOT'] . "/api/admin/cache_pages_update.php";
}

?>
<?php

if (isset($MPCMSRendererPageMarkup)) {
    $pagename = $MPCMSRendererPageMarkupDN;
} else {
    $pagename = $MPCMSRendererPageNameValue;
}
$ready = true;

if ($ready) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagesInMenuBar")) {
        $pimb = (integer)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagesInMenuBar");
    } else {
        $pimb = 4;
    }
}

function getAvgLuminance($filename, $num_samples=30) {
    rlgps("Gathering average luminance from image");
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/banner.mtd")) {
        rlgps("Already in cache");
        return file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/banner.mtd");
    } else {
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
                $lum = ($r+$r+$b+$g+$g+$g)/6;
                $total_lum += $lum;
                $sample_no++;
            }
        }
        $avg_lum  = $total_lum / $sample_no;
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/banner.mtd", ($avg_lum / 255) * 100);
        return ($avg_lum / 255) * 100;
    }
}

function asciiComp($a, $b) {
    $at = iconv('UTF-8', 'ASCII//TRANSLIT', $a);
    $bt = iconv('UTF-8', 'ASCII//TRANSLIT', $b);
    return strcmp($at, $bt);
}

?>
<?php
rlgps("Loading widgets");
$json = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json"));
$widgets = $json->list;
foreach ($widgets as $widget): ?>
<?php $data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/feature.json")); ?>
<?php

if (isset($data->class) && is_string($data->class)) {
    require $_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/source.php";
}

?>
<?php endforeach ?>
<?php ob_start();echo("<!--\n\n" . str_replace('%year%', date('Y'), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/license")) . "\n\n-->") ?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {} else {
    die("<script>location.href = '/';</script>");
}

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
        echo('<link rel="shortcut icon" href="/resources/upload/siteicon-uncomp.png" type="image/png">');
    } else {
        echo('<link rel="stylesheet" href="/resources/css/ready.css">');
    }

    ?>
    <link rel="stylesheet" href="/resources/css/fonts-import.css">
    <link rel="stylesheet" href="/resources/css/ui.css">
    <title><?php

    if (isset($MPCMSRendererPageMarkup)) {
        echo($MPCMSRendererPageMarkupDN . " - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
    } else {
        echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $pagename . "/pagename") . " - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
    }

    ?></title>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/header.php" ?>
</head>
<body>
    <?php

    echo("<script type=\"text/javascript\">\nvar pushbar = new Pushbar({\nblur:true,\noverlay:true,\n});\n</script>");


    rlgps("Banner generation");
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
    rlgps("Branding");
    ?>
    <div id="always-on-top">
        <div id="siteadmin"><a class="sab" href="/cms-special/version"><span class="branding-desktop"><?= $lang["viewer"]["powered"] ?> FNS Neutron <?= str_replace("#", substr(md5(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")), 0, 2), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")) ?></span><span class="branding-mobile">Neutron <?= str_replace("#", substr(md5(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")), 0, 2), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")) ?></span></a><a href="/cms-special/admin" id="siteadmin-button"><img id="siteadmin-img" src="/resources/image/admin.svg"><?= $lang["viewer"]["manage"] ?></a></div>
    </div>
        <div id="banner" style='background-image: url("<?= $banner ?>");'>
        <img id="banner-logo" src="/resources/upload/siteicon.png"><span id="banner-name" <?php if ($blackBannerText) {echo("class=\"banner-black\"");} ?>><?php

        if (isset($MPCMSRendererPageMarkup)) {
            echo($MPCMSRendererPageMarkupDN);
        } else {
            echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $pagename . "/pagename"));
        }

        ?></span>
        </div>
        <div id="menubar"><span class="menubar-link menubar-mobile" id="menubar-link-navigation" onclick="pushbar.open('panel-navigation')"><img src="/resources/image/menu.svg" class="menubar-img"><span class="menubar-link-text"><?= $lang["viewer"]["menu"] ?></span></span>
        <?php
        rlgps("Menubar");
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/alwaysmenu")) {
            echo('<span class="menubar-link menubar-desktop" id="menubar-link-navigation" onclick="pushbar.open(\'panel-navigation\')"><img src="/resources/image/menu.svg" class="menubar-img"><span class="menubar-link-text">' . $lang["viewer"]["menu"] . '</span></span>');
        } else {
            $count = 0;
            echo('<a href="/" title="/" class="menulink-desktop">' . $lang["viewer"]["home"] . '</a>');
            $count = $count + 1;

            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-old.mtd")) {
                echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/pagelist-old.mtd"));
            } else {
                $pages = scandir($_SERVER['DOCUMENT_ROOT']);
                uasort($pages, 'asciiComp');
                foreach ($pages as $page) {
                    if ($page != ".." && $page != ".") {
                        if (is_dir($_SERVER['DOCUMENT_ROOT'] . "/" . $page)) {
                            if ($count < $pimb) {
                                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename")) {
                                    if (!in_array($page, $customSettings->hiddenPages)) {
                                        echo("<a href=\"/{$page}\" title=\"/{$page}\" class=\"menulink-desktop\">" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename") . "</a>");
                                        $count = $count + 1;
                                    }
                                }
                            }
                        }
                    }
                }
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures") && count(scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures")) > 2) {echo("<a href=\"/cms-special/galery\" title=\"/cms-special/galery\" class=\"menulink-desktop\">" . $lang["viewer"]["gallery"] . "</a>");$count = $count + 1;}
            }
            if ($count >= 4) {
                echo("<a onclick=\"pushbar.open('panel-navigation')\" title=\"" . $lang["viewer"]["menutitle"] . "\" class=\"menulink-desktop\">" . $lang["viewer"]["menudesktop"] . "</a>");
            }
        }

        ?>
        <?php

$widgets = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json"));
if (!empty($widgets->list)) {
    echo("<span class=\"menubar-link\" id=\"menubar-link-tools\" onclick=\"pushbar.open('panel-sidebar')\"><img src=\"/resources/image/tools.svg\" class=\"menubar-img\"><span class=\"menubar-link-text\">" . $lang["viewer"]["widgets"] . "</span></span>");
}

?></div><script src="/resources/js/sticky.js"></script>
    <div data-pushbar-id="panel-navigation" data-pushbar-direction="left">
        <div id="banner-menu" style='background-image: url("<?= $banner ?>");'>
            <img id="banner-menu-logo" src="/resources/upload/siteicon.png"><span id="banner-menu-name" <?php if ($blackBannerText) {echo("class=\"banner-black\"");} ?>><?php
            rlgps("Printing banner");
            $sitename = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename");

            if (strlen($sitename) < 15) {
                echo($sitename);
            } else {
                echo(substr($sitename, 0, 14) . "...");
            }

            ?></span>
        </div>
        <img src="/resources/image/close.svg" id="menubar-close" class="noeffects" onclick="pushbar.close()">
        <br>
        <a href="/" title="/" class="menu-link"><?= $lang["viewer"]["home"] ?></a>
        <?php
        rlgps("Navigation pane");
        $pages = scandir($_SERVER['DOCUMENT_ROOT']);
        uasort($pages, 'asciiComp');
        foreach ($pages as $page) {
            if ($page != ".." && $page != ".") {
                if (is_dir($_SERVER['DOCUMENT_ROOT'] . "/" . $page)) {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename")) {
                        if (!in_array($page, $customSettings->hiddenPages)) {
                            echo("<a href=\"/{$page}\" title=\"/{$page}\" class=\"menu-link\">" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename") . "</a>");
                        }
                    }
                }
            }
        }
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/enabled")) {echo("<a href=\"/cms-special/galery\" title=\"/cms-special/galery\" class=\"menu-link\">" . $lang["viewer"]["gallery"] . "</a>");}

        ?>
	</div>
	<div data-pushbar-id="panel-sidebar" id="sidebar" data-pushbar-direction="right">
        <img src="/resources/image/close.svg" id="sidebar-close" onclick="pushbar.close()">
        <span id="sidebar-title"><?= $lang["viewer"]["widgetspane"] ?></span>
        <span id="sidebar-separator"></span>
        <span id="sidebar-widgets">
        <?php

        if (isset($_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN']) && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != "." && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != ".." && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != "/") {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'])) {
                echo('<p><table class="message_info"><tbody><tr><td><img src="/resources/image/message_info.svg" class="message_img"></td><td style="width:100%;"><p>' . $lang["viewer"]["logout"][0] . '<a href="/cms-special/admin/logout" style="color:inherit;text-decoration:none;">' . $lang["viewer"]["logout"][1] . '</a>' . $lang["viewer"]["logout"][2] . '</p></td></tr></tbody></table></p>');
            }
        }

        ?>
            <?php
            rlgps("Loading widgets");
                $config = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json"));
                foreach ($config->list as $widget): ?>
                    <?php $data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/feature.json")); ?>
                    <?php
                    
                    if (isset($data->class) && is_string($data->class)) {
                        $class = $data->class;
                        new $class();
                    } else {
                        require $_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/source.php";
                    }
                    
                    ?>
                    <?php endforeach ?>
        </span>
	</div>
    <div id="page-placeholder">
        <div id="page-content">
        <?php
            if (!isset($MPCMSRendererPageMarkup)) {
                $html_string = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $pagename);
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
                <h3>' . $lang["viewer"]["toc"] . '</h3>
                <ul>
                '.$toc.'
                </ul>
                </div><hr>';

                if (false) {
                    echo($toc);
                }
            }

            ?>
            <?php

            if (isset($MPCMSRendererPageMarkup)) {
                echo($MPCMSRendererPageMarkup);
            } else {
                echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $pagename));
            }

            ?>
        </div>
        <div id="page-footer">
        <?php echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/footer")); ?>
        </div>
    </div>
</body>
</html>