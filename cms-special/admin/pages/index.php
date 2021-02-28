<?php if(!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/flag_redesign")){header("Location: /cms-special/admin/pages.old");require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit();};$pageConfig = [ "domName" => "Pages", "headerName" => "Gestionnaire de pages" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>

        <div class="admin-pages-list">
            <?php
            
            $pages = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/");
            $sizetotal = 0;
            foreach ($pages as $page) {
                if ($page != "." && $page != "..") {
                    $type = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagetypes/" . $page);
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
                    if ($page == "index"): ?>
<!--                        echo("<li><a href='/cms-special/admin/pages/manage/?slug={$page}' class='sblink' title='{$lang['admin-pages']['lore']}'>{$lang['admin-pages']['home']}</a> ({$page}), {$typestr}, {$sizestr}</li>");-->
                        <div class="mdc-card mdc-card--outlined" style="width:256px;margin:10px;display:inline-block;">
                            <div class="mdc-card-wrapper__text-section" style="padding-left:5px;padding-right:5px;">
                                <h2 style="margin-bottom:5px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;" class="mdc-typography mdc-typography--headline6"><?= $lang["admin-pages"]["home"] ?></h2>
                                <h3 style="margin-top:5px;" class="mdc-typography mdc-typography--subtitle2"><?php $text = strip_tags(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $page));if (strlen($text)>100){echo(substr($text,0,100) . " …");}else{echo($text);} ?></h3>
                            </div><br><br>
                            <div class="mdc-card__actions mdc-card__actions-pages-list">
                                <a href="/cms-special/admin/pages/edit/?slug=<?= $page ?>" title="<?= $lang["admin-pages"]["editl"] ?>" class="mdc-button mdc-card__action mdc-card__action--button">
                                    <div class="mdc-button__ripple"></div>
                                    <span class="mdc-button__label"><?= $lang["admin-pages"]["edit"] ?></span>
                                </a>
                                <a href="/cms-special/admin/pages/edit/?slug=<?= $page ?>&forcehtml" class="material-icons mdc-icon-button mdc-card__action mdc-card__action--icon mdi-icbtn-card" title="<?= $lang["admin-pages"]["editcode"] ?>">code</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="mdc-card mdc-card--outlined" style="width:256px;margin:10px;display:inline-block;">
                            <div class="mdc-card-wrapper__text-section" style="padding-left:5px;padding-right:5px;">
                                <h2 style="margin-bottom:5px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;" class="mdc-typography mdc-typography--headline6"><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename") ?></h2>
                                <h3 style="margin-top:5px;" class="mdc-typography mdc-typography--subtitle2"><?php $text = strip_tags(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $page));if (strlen($text)>100){echo(substr($text,0,100) . " …");}else{echo($text);} ?></h3>
                            </div><br><br>
                            <div class="mdc-card__actions mdc-card__actions-pages-list">
                                <a href="/cms-special/admin/pages/edit/?slug=<?= $page ?>" title="<?= $lang["admin-pages"]["editl"] ?>" class="mdc-button mdc-card__action mdc-card__action--button">
                                    <div class="mdc-button__ripple"></div>
                                    <span class="mdc-button__label"><?= $lang["admin-pages"]["edit"] ?></span>
                                </a>
                                <a href="/cms-special/admin/pages/rename/?slug=<?= $page ?>" class="material-icons mdc-icon-button mdc-card__action mdc-card__action--icon mdi-icbtn-card" title="<?= $lang["admin-pages"]["renamel"] ?>">create</a>
                                <a href="/cms-special/admin/pages/delete/?slug=<?= $page ?>" class="material-icons mdc-icon-button mdc-card__action mdc-card__action--icon mdi-icbtn-card" title="<?= $lang["admin-pages"]["deletel"] ?>">delete</a>
                            </div>
                        </div>
                    <?php endif;
                }
            }
            ?>
        </div>
        <p><div style="text-align: center;">
                <a title="<?= $lang["admin-pages"]["alore"] ?>" href="/cms-special/admin/pages/add" class="mdc-button mdc-button--outlined">
                    <div class="mdc-button__ripple"></div>
                    <i class="material-icons-outlined mdc-button__icon" aria-hidden="true">add</i>
                    <span class="mdc-button__label"><?= $lang["admin-pages"]["create"] ?></span>
                </a>
        </div></p>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>