<?php $pageConfig = [ "domName" => "Tableau de bord", "headerName" => "Tableau de bord" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
                    <center>
                        <h2>Bienvenue sur votre site !</h2>
                        <p>
                            <ul>
                                <li>Votre site à reçu <b><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d")) ?> visiteurs</b> aujourd'hui <small>— <a href="/cms-special/admin/stats">Voir plus...</a></small></li>
                                <li>Votre site dispose de <b><?= count(scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages")) - 2 ?> page(s)</b> disponibles <small>— <a href="/cms-special/admin/pages">Voir plus...</a></small></li>
                            </ul>
                        </p>

                        <h3>Pages</h3>
                        <ul>
                            <?php
                            
                            foreach (scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages") as $page) {
                                if ($page != "." && $page != "..") {
                                    echo("<li>");
                                    if ($page == "index") {
                                        echo("Accueil<small> : <a target=\"_blank\" href=\"/\">lire</a> - <a href=\"/cms-special/admin/pages/manage/?slug=index\">gérer</a></small>");
                                    } else {
                                        echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename") . "<small> : <a target=\"_blank\" href=\"/" . $page . "\">lire</a> - <a href=\"/cms-special/admin/pages/manage/?slug=" . $page . "\">gérer</a></small>");
                                    }
                                    echo("</li>");
                                }
                            }
                            
                            ?>
                            <p><small><a href="/cms-special/admin/pages">Voir plus...</a></small></p>
                        </ul>
                        <h3>Extensions</h3>
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
                            <p><small><a href="/cms-special/admin/plugins">Voir plus...</a></small></p>
                        </ul>
                        <h3>Continuez</h3>
                        <p>Pour continuer, choisissez une option dans le menu à gauche (appuyez sur le bouton <i class="material-icons" style="vertical-align:middle;">menu</i> pour l'afficher) pour accéder à un paramètre.</p>
                    </center>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>