<?php $pageConfig = [ "domName" => "Pages", "headerName" => "Gestionnaire de pages" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>

        <?= $lang["admin-pages"]["description"] ?>
        <ul>
            <?php
            
            $pages = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/");
            $sizetotal = 0;
            foreach ($pages as $page) {
                if ($page != "." && $page != "..") {
                    $type = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagetypes/" . $page);
                        if ($type == "0") {
                            $typestr = $lang["admin-pages"]["classic"];
                        }
                        if ($type == "1") {
                            $typestr = $lang["admin-pages"]["html"];
                        }
                        $size = filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $page);
                        if ($size > 1024) {
                            if ($size > 1048576) {
                                $sizestr = round($size / 1048576, 2) . " " . $lang["sizes"]["mib"];
                            } else {
                                $sizestr = round($size / 1024, 2) . " " . $lang["sizes"]["kib"];
                            }
                        } else {
                            $sizestr = $size . " " . $lang["sizes"]["bytes"];
                        }
                        $sizetotal = $sizetotal + $size;
                        $sizestr = str_replace(".", ",", $sizestr);
                    if ($page == "index") {
                        echo("<li><a href='/cms-special/admin/pages/manage/?slug={$page}' class='sblink' title='{$lang['admin-pages']['lore']}'>{$lang['admin-pages']['home']}</a> ({$page}), {$typestr}, {$sizestr}</li>");
                    } else {
                        echo("<li><a href='/cms-special/admin/pages/manage/?slug={$page}' class='sblink' title='{$lang['admin-pages']['lore']}'>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename") . "</a> ({$page}), {$typestr}, {$sizestr}</li>");
                    }
                }
            }
            if ($sizetotal > 1024) {
                if ($sizetotal > 1048576) {
                    if ($sizetotal > 1073741824) {
                        $sizestr = round($sizetotal / 1073741824, 2) . " {$lang['sizes']['gibibytes']} ({$lang['sizes']['gib']})";
                    } else {
                        $sizestr = round($sizetotal / 1048576, 2) . " {$lang['sizes']['mebibytes']} ({$lang['sizes']['mib']})";
                    }
                } else {
                    $sizestr = round($sizetotal / 1024, 2) . " {$lang['sizes']['kibibytes']} ({$lang['sizes']['kib']})";
                }
            } else {
                $sizestr = $size . " {$lang['sizes']['bytes']}";
            }
            $sizestr = str_replace(".", ",", $sizestr);
            echo("<p><b>{$lang['admin-pages']['summary']} {$sizestr}</b></p>");

            ?>
        </ul>
        <p><center><a href="/cms-special/admin/pages/add" class="button" title="<?= $lang["admin-pages"]["alore"] ?>"><?= $lang["admin-pages"]["create"] ?></a></center></p>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>