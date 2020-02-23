<?php $pageConfig = [ "domName" => "Tableau de bord", "headerName" => "Tableau de bord" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
                    <center>
                        <h2><?= $lang["admin-home"]["greeting"] ?></h2>
                        <p>
                            <ul>
                                <li><?= $lang["admin-home"]["visitors"] ?><b><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d")) ?><?= $lang["admin-home"]["visitorspost"][0] ?></b><?= $lang["admin-home"]["visitorspost"][1] ?><small>— <a href="/cms-special/admin/stats"><?= $lang["admin-home"]["more"] ?></a></small></li>
                                <li><?= $lang["admin-home"]["pages"] ?><b><?= count(scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages")) - 2 ?> <?= $lang["admin-home"]["pagespost"][0] ?></b><?= $lang["admin-home"]["pagespost"][1] ?><small>— <a href="/cms-special/admin/pages"><?= $lang["admin-home"]["more"] ?></a></small></li>
                            </ul>
                        </p>

                        <h3><?= $lang["admin-home"]["pagelisttitle"] ?></h3>
                        <ul>
                            <?php

                            foreach (scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages") as $page) {
                                if ($page != "." && $page != "..") {
                                    echo("<li>");
                                    if ($page == "index") {
                                        echo($lang["viewer"]["home"] . "<small> : <a target=\"_blank\" href=\"/\">{$lang["admin-home"]["pagelistview"]}</a> - <a href=\"/cms-special/admin/pages/manage/?slug=index\">{$lang["admin-home"]["pagelistmanage"]}</a></small>");
                                    } else {
                                        echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename") . "<small> : <a target=\"_blank\" href=\"/" . $page . "\">{$lang["admin-home"]["pagelistview"]}</a> - <a href=\"/cms-special/admin/pages/manage/?slug=" . $page . "\">{$lang["admin-home"]["pagelistmanage"]}</a></small>");
                                    }
                                    echo("</li>");
                                }
                            }

                            ?>
                            <p><small><a href="/cms-special/admin/pages"><?= $lang["admin-home"]["more"] ?></a></small></p>
                        </ul>
                        <h3><?= $lang["admin-home"]["pluginlist"] ?></h3>
                        <ul>
                        <?php

                            foreach (scandir($_SERVER['DOCUMENT_ROOT'] . "/widgets") as $ext) {
                                if ($ext != "." && $ext != ".." && $ext != ".htaccess") {
                                    echo("<li>");
                                    echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $ext . "/name"));
                                    echo("</li>");
                                }
                            }

                            ?>
                            <p><small><a href="/cms-special/admin/plugins"><?= $lang["admin-home"]["more"] ?></a></small></p>
                        </ul>
                        <h3><?= $lang["admin-home"]["continue"] ?></h3>
                        <p><?= $lang["admin-home"]["continuemsg"][0] ?><i class="material-icons" style="vertical-align:middle;">menu</i><?= $lang["admin-home"]["continuemsg"][1] ?></p>
                    </center>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>
