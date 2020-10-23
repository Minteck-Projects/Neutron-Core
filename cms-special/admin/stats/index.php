<?php $pageConfig = [ "domName" => "Statistiques", "headerName" => "Statistiques" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
<?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats")) { echo("<h2>" . $lang["admin-stats"]["new"] . "</h2><p>" . $lang["admin-stats"]["notice"] . "</p>"); } ?>
<?php

function gystat($year, $month, $showYear = false) {
    global $lang;

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/newstats/" . $year . "/" . $month)) {

        $files = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/newstats/" . $year . "/" . $month);
        $cmonth = 0;
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                $count = count(explode("\n", trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/newstats/" . $year . "/" . $month . "/" . $file))));
                if ($count > 0) {
                    $cmonth = $cmonth + $count;
                }
            }
        }

        if ($cmonth > 0) {
            if ($cmonth > 1) {
                if ($showYear) {
                    echo("<tr><td><b>{$lang["admin-stats"]["months"][$month - 1]} {$year}{$lang["admin-stats"]["separator"]}</b></td><td> {$cmonth}</td><td> {$lang["admin-stats"]["visits2"]}</td></tr>");
                } else {
                    echo("<tr><td><b>{$lang["admin-stats"]["months"][$month - 1]}{$lang["admin-stats"]["separator"]}</b></td><td> {$cmonth}</td><td> {$lang["admin-stats"]["visits2"]}</td></tr>");
                }
            } else {
                if ($showYear) {
                    echo("<tr><td><b>{$lang["admin-stats"]["months"][$month - 1]} {$year}{$lang["admin-stats"]["separator"]}</b></td><td> {$cmonth}</td><td> {$lang["admin-stats"]["visit1"]}</td></tr>");
                } else {
                    echo("<tr><td><b>{$lang["admin-stats"]["months"][$month - 1]}{$lang["admin-stats"]["separator"]}</b></td><td> {$cmonth}</td><td> {$lang["admin-stats"]["visit1"]}</td></tr>");
                }
            }
        }
    }
}

?>
<h3><?= $lang["admin-stats"]["thisMonth"]?></h3>
<table>
    <tbody>
        <?php
        
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/newstats/" . date('Y') . "/" . date('m'))) {
            $mtxt = $lang["admin-stats"]["monthslc"][date('m') - 1];

            $files = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/newstats/" . date('Y') . "/" . date('m'));
            foreach ($files as $file) {
                if ($file != "." && $file != "..") {
                    $count = count(explode("\n", trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/newstats/" . date('Y') . "/" . date('m') . "/" . $file))));
                    if ($count > 0) {
                        $day = (int)trim($file);
                        if ($count > 1) {
                            echo("<tr><td><b>{$day} {$mtxt}{$lang["admin-stats"]["separator"]}</b></td><td> {$count}</td><td> {$lang["admin-stats"]["visits2"]}</td></tr>");
                        } else {
                            echo("<tr><td><b>{$day} {$mtxt}{$lang["admin-stats"]["separator"]}</b></td><td> {$count}</td><td> {$lang["admin-stats"]["visit1"]}</td></tr>");
                        }
                    }
                }
            }
        }

        ?>
    </tbody>
</table>

<h3><?= $lang["admin-stats"]["year"]?></h3>
<table>
    <tbody>
        <?php
        
        gystat(date('Y'), "1", false);
        gystat(date('Y'), "2", false);
        gystat(date('Y'), "3", false);
        gystat(date('Y'), "4", false);
        gystat(date('Y'), "5", false);
        gystat(date('Y'), "6", false);
        gystat(date('Y'), "7", false);
        gystat(date('Y'), "8", false);
        gystat(date('Y'), "9", false);
        gystat(date('Y'), "10", false);
        gystat(date('Y'), "11", false);
        gystat(date('Y'), "12", false);

        ?>
    </tbody>
</table>

<h3><?= $lang["admin-stats"]["last2"]?><?= date('Y') - 1 ?></h3>
<table>
    <tbody>
        <?php
        
        gystat(date('Y') - 1, "1", true);
        gystat(date('Y') - 1, "2", true);
        gystat(date('Y') - 1, "3", true);
        gystat(date('Y') - 1, "4", true);
        gystat(date('Y') - 1, "5", true);
        gystat(date('Y') - 1, "6", true);
        gystat(date('Y') - 1, "7", true);
        gystat(date('Y') - 1, "8", true);
        gystat(date('Y') - 1, "9", true);
        gystat(date('Y') - 1, "10", true);
        gystat(date('Y') - 1, "11", true);
        gystat(date('Y') - 1, "12", true);

        ?>
    </tbody>
</table>

<?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats")): ?> 
<hr style="border-top:none;">
<h2><?= $lang["admin-stats"]["old"] ?></h2>
<p><?= $lang["admin-stats"]["notice"] ?></p>
        <h3><?= $lang["admin-stats"]["thisMonth"]?></h3>
<table><tbody><?php

$dates = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats");
foreach ($dates as $date) {
    if ($date != "." && $date != "..") {
        if (startsWith($date, date("Y-m-"))) {
            $newdate = str_replace(date("Y-m-"), "", $date);
            $newdatestr = $newdate . date("/m/Y");
            echo("<tr><td><b>{$newdatestr}{$lang["admin-stats"]["separator"]}</b></td><td>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $date) . "</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
        }
    }
}

?>
</tbody></table>
        <h3><?= $lang["admin-stats"]["year"] ?></h3>
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

                echo("<tr><td><b>{$lang["admin-stats"]["months"][0]}{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['01']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][1]}{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['02']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][2]}{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['03']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][3]}{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['04']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][4]}{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['05']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][5]}{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['06']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][6]}{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['07']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][7]}{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['08']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][8]}{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['09']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][9]}{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['10']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][10]}{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['11']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][11]}{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['12']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                ?>
            </tbody>
        </table>
        <h3><?= $lang["admin-stats"]["last"] ?></h3>
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

                echo("<tr><td><b>{$lang["admin-stats"]["months"][0]} " . ((int)date("Y") - 1) . "{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['01']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][1]} " . ((int)date("Y") - 1) . "{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['02']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][2]} " . ((int)date("Y") - 1) . "{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['03']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][3]} " . ((int)date("Y") - 1) . "{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['04']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][4]} " . ((int)date("Y") - 1) . "{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['05']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][5]} " . ((int)date("Y") - 1) . "{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['06']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][6]} " . ((int)date("Y") - 1) . "{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['07']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][7]} " . ((int)date("Y") - 1) . "{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['08']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][8]} " . ((int)date("Y") - 1) . "{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['09']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][9]} " . ((int)date("Y") - 1) . "{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['10']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][10]} " . ((int)date("Y") - 1) . "{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['11']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                echo("<tr><td><b>{$lang["admin-stats"]["months"][11]} " . ((int)date("Y") - 1) . "{$lang["admin-stats"]["separator"]}</b></td><td>{$visits['12']}</td><td> {$lang["admin-stats"]["visits"]}</td></tr>");
                ?>
            </tbody>
        </table>
        <?php endif; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>