<?php $pageConfig = [ "domName" => "Pages", "headerName" => "Gestionnaire de pages" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        Cliquez sur le nom d'une page pour la modifier, la renommer, ou la supprimer.
        <ul>
            <?php
            
            $pages = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/");
            $sizetotal = 0;
            foreach ($pages as $page) {
                if ($page != "." && $page != "..") {
                    $type = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagetypes/" . $page);
                        if ($type == "0") {
                            $typestr = "page classique";
                        }
                        if ($type == "1") {
                            $typestr = "page HTML";
                        }
                        $size = filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $page);
                        if ($size > 1024) {
                            if ($size > 1048576) {
                                $sizestr = round($size / 1048576, 2) . " Mio";
                            } else {
                                $sizestr = round($size / 1024, 2) . " Kio";
                            }
                        } else {
                            $sizestr = $size . " octets";
                        }
                        $sizetotal = $sizetotal + $size;
                        $sizestr = str_replace(".", ",", $sizestr);
                    if ($page == "index") {
                        echo("<li><a href='/cms-special/admin/pages/manage/?slug={$page}' class='sblink' title='Modifier/renommer/supprimer cette page'>Accueil</a> ({$page}), {$typestr}, {$sizestr}</li>");
                    } else {
                        echo("<li><a href='/cms-special/admin/pages/manage/?slug={$page}' class='sblink' title='Modifier/renommer/supprimer cette page'>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename") . "</a> ({$page}), {$typestr}, {$sizestr}</li>");
                    }
                }
            }
            if ($sizetotal > 1024) {
                if ($sizetotal > 1048576) {
                    if ($sizetotal > 1073741824) {
                        $sizestr = round($sizetotal / 1073741824, 2) . " gibioctets (Gio)";
                    } else {
                        $sizestr = round($sizetotal / 1048576, 2) . " mibioctets (Mio)";
                    }
                } else {
                    $sizestr = round($sizetotal / 1024, 2) . " kibioctets (Kio)";
                }
            } else {
                $sizestr = $size . " octets";
            }
            $sizestr = str_replace(".", ",", $sizestr);
            echo("<p><b>Espace disque total utilisé par votre site : {$sizestr}</b></p>");

            ?>
        </ul>
        <p><center><a href="/cms-special/admin/pages/add" class="button" title="Ajouter une nouvelle page à votre site">Créer une page</a></center></p>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>