<?php

$invalid = false;

function startsWith ($string, $startString) 
{ 
    $len = strlen($startString); 
    return (substr($string, 0, $len) === $startString); 
}

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
    <?php $banner = "/resources/image/codename.jpg";if (getAvgLuminance($_SERVER['DOCUMENT_ROOT'] . "/resources/image/codename.jpg") > 50) {$blackBannerText = true;} else {$blackBannerText = false;}function getAvgLuminance($filename, $num_samples=30) {$img = imagecreatefromjpeg($filename);$width = imagesx($img);$height = imagesy($img);$x_step = intval($width/$num_samples);$y_step = intval($height/$num_samples);$total_lum = 0;$sample_no = 1;for ($x=0; $x<$width; $x+=$x_step) {for ($y=0; $y<$height; $y+=$y_step) {$rgb = imagecolorat($img, $x, $y);$r = ($rgb >> 16) & 0xFF;$g = ($rgb >> 8) & 0xFF;$b = $rgb & 0xFF;$lum = ($r+$r+$b+$g+$g+$g)/6;$total_lum += $lum;$sample_no++;}}$avg_lum  = $total_lum / $sample_no;return ($avg_lum / 255) * 100;}function getData(string $dir, $ignoreUploadDir = false) {global $size;$dircontent = scandir($dir);foreach ($dircontent as $direl) {if (($ignoreUploadDir && ($direl == "/upload" || $dir . "/" . $direl == $_SERVER['DOCUMENT_ROOT'] . "/resources/upload")) || $direl == ".git") {} else {if ($direl == "." || $direl == "..") {} else {if (is_link($dir . "/" . $direl)) {} else {if (is_dir($dir . "/" . $direl)) {getData($dir . "/" . $direl);} else {$size = $size + filesize($dir . "/" . $direl);}}}}}}getData($_SERVER['DOCUMENT_ROOT']);$sizestr = $size . " octets";if ($size > 1024) {if ($size > 1048576) {if ($size > 1073741824) {$sizestr = round($size / 1073741824, 2) . " Gio";} else {$sizestr = round($size / 1048576, 2) . " Mio";}} else {$sizestr = round($size / 1024, 2) . " Kio";}} else {$sizestr = $size . " octets";}$sizestr = str_replace(".", ",", $sizestr); ?>
    <div id="banner" style='background-image: url("<?= $banner ?>");'>
        <center><table style="width:100%;"><tr><td style="width:50%;"><img style="float:right;" id="banner-logo" src="/resources/upload/siteicon.png"><td><td><span style="float:left;" id="adminb" <?php if ($blackBannerText) {echo("class=\"banner-black\"");} ?>><span id="banner-name" <?php if ($blackBannerText) {echo("class=\"banner-black\"");} ?>><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename") ?><br></span><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version") ?> <?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/codename") ?> • <?= $sizestr ?></span></td></tr></table></center>
    </div><div id="navigation"><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/stats" class="sblink">Statistiques</a></div>
        <h2>Statistiques de votre site</h2>
        <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
        <h3>Visites du site ce mois</h3>
        <div id="visits" class="chart--container"></div>
        <script>
      let chartConfig = {
  type: 'pie',
  plot: {
    tooltip: {
      text: '%npv%',
      padding: '5 10',
      fontSize: '18px'
    },
    valueBox: {
      text: '%t\n%npv%',
      placement: 'out'
    },
    borderWidth: '1px'
  },
  plotarea: {
    margin: '20 0 0 0'
  },
  source: {
    text: 'Certaines informations peuvent être inexactes',
    fontColor: '#8e99a9',
    fontFamily: 'Open Sans',
    textAlign: 'left'
  },
  series: [
    // {
    //   text: 'IE and Edge',
    //   values: [2],
    // },
    // {
    //   text: 'Chrome',
    //   values: [2],
    // },
    // {
    //   text: 'Firefox',
    //   values: [2],
    // },
    // {
    //   text: 'Safari',
    //   values: [2],
    // },
<?php

$dates = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats");
foreach ($dates as $date) {
    if ($date != "." && $date != "..") {
        if (startsWith($date, date("Y-m-"))) {
            $newdate = str_replace(date("Y-m-"), "", $date);
            $newdatestr = $newdate . date("/m/Y");
            echo("{\ntext: '" . $newdatestr . "',\nvalues: [" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $date) . "],\n},");
        }
    }
}

?>
  ]
};

zingchart.render({
  id: 'visits',
  data: chartConfig
});
    </script>
    <div id="afterchart">
        <h3>Visites totales cette année</h3>
        <table>
            <tbody>
                <?php

                $visits = [];
                $visits['01'] = 0;
                $visits['02'] = 0;
                $visits['03'] = 0;
                $visits['04'] = 0;
                $visits['05'] = 0;
                $visits['06'] = 0;
                $visits['07'] = 0;
                $visits['08'] = 0;
                $visits['09'] = 0;
                $visits['10'] = 0;
                $visits['11'] = 0;
                $visits['12'] = 0;
                $lists = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats");
                foreach ($lists as $list) {
                    if (startsWith($list, date("Y") . "-01")) {
                        $visits['01'] = $visits['01'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, date("Y") . "-02")) {
                        $visits['02'] = $visits['02'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, date("Y") . "-03")) {
                        $visits['03'] = $visits['03'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, date("Y") . "-04")) {
                        $visits['04'] = $visits['04'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, date("Y") . "-05")) {
                        $visits['05'] = $visits['05'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, date("Y") . "-06")) {
                        $visits['06'] = $visits['06'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, date("Y") . "-07")) {
                        $visits['07'] = $visits['07'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, date("Y") . "-08")) {
                        $visits['08'] = $visits['08'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, date("Y") . "-09")) {
                        $visits['09'] = $visits['09'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, date("Y") . "-10")) {
                        $visits['10'] = $visits['10'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, date("Y") . "-11")) {
                        $visits['11'] = $visits['11'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, date("Y") . "-12")) {
                        $visits['12'] = $visits['12'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                }
                
                echo("<tr><td><b>Janvier :</b></td><td>{$visits['01']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Février :</b></td><td>{$visits['02']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Mars :</b></td><td>{$visits['03']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Avril :</b></td><td>{$visits['04']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Mai :</b></td><td>{$visits['05']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Juin :</b></td><td>{$visits['06']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Juillet :</b></td><td>{$visits['07']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Août :</b></td><td>{$visits['08']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Septembre :</b></td><td>{$visits['09']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Octobre :</b></td><td>{$visits['10']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Novembre :</b></td><td>{$visits['11']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Décembre :</b></td><td>{$visits['12']}</td><td> visites</td></tr>");
                ?>
            </tbody>
        </table>
        <h3>Visites totales l'année dernière</h3>
        <table>
            <tbody>
                <?php

                $visits = [];
                $visits['01'] = 0;
                $visits['02'] = 0;
                $visits['03'] = 0;
                $visits['04'] = 0;
                $visits['05'] = 0;
                $visits['06'] = 0;
                $visits['07'] = 0;
                $visits['08'] = 0;
                $visits['09'] = 0;
                $visits['10'] = 0;
                $visits['11'] = 0;
                $visits['12'] = 0;
                $lists = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats");
                foreach ($lists as $list) {
                    if (startsWith($list, ((int)date("Y") - 1) . "-01")) {
                        $visits['01'] = $visits['01'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, ((int)date("Y") - 1) . "-02")) {
                        $visits['02'] = $visits['02'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, ((int)date("Y") - 1) . "-03")) {
                        $visits['03'] = $visits['03'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, ((int)date("Y") - 1) . "-04")) {
                        $visits['04'] = $visits['04'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, ((int)date("Y") - 1) . "-05")) {
                        $visits['05'] = $visits['05'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, ((int)date("Y") - 1) . "-06")) {
                        $visits['06'] = $visits['06'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, ((int)date("Y") - 1) . "-07")) {
                        $visits['07'] = $visits['07'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, ((int)date("Y") - 1) . "-08")) {
                        $visits['08'] = $visits['08'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, ((int)date("Y") - 1) . "-09")) {
                        $visits['09'] = $visits['09'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, ((int)date("Y") - 1) . "-10")) {
                        $visits['10'] = $visits['10'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, ((int)date("Y") - 1) . "-11")) {
                        $visits['11'] = $visits['11'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                    if (startsWith($list, ((int)date("Y") - 1) . "-12")) {
                        $visits['12'] = $visits['12'] + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $list);
                    }
                }
                
                echo("<tr><td><b>Janvier " . ((int)date("Y") - 1) . " :</b></td><td>{$visits['01']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Février " . ((int)date("Y") - 1) . " :</b></td><td>{$visits['02']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Mars " . ((int)date("Y") - 1) . " :</b></td><td>{$visits['03']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Avril " . ((int)date("Y") - 1) . " :</b></td><td>{$visits['04']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Mai " . ((int)date("Y") - 1) . " :</b></td><td>{$visits['05']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Juin " . ((int)date("Y") - 1) . " :</b></td><td>{$visits['06']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Juillet " . ((int)date("Y") - 1) . " :</b></td><td>{$visits['07']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Août " . ((int)date("Y") - 1) . " :</b></td><td>{$visits['08']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Septembre " . ((int)date("Y") - 1) . " :</b></td><td>{$visits['09']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Octobre " . ((int)date("Y") - 1) . " :</b></td><td>{$visits['10']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Novembre " . ((int)date("Y") - 1) . " :</b></td><td>{$visits['11']}</td><td> visites</td></tr>");
                echo("<tr><td><b>Décembre " . ((int)date("Y") - 1) . " :</b></td><td>{$visits['12']}</td><td> visites</td></tr>");
                ?>
            </tbody>
        </table>
    </div>
    </div>
</body>
</html>