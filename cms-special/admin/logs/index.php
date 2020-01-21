<?php $pageConfig = [ "domName" => "Historique d'activité", "headerName" => "Historique d'activité" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <div id="logs">
            <?php
            
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
                $file = file($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log");
                for ($i = max(0, count($file)-100); $i < count($file); $i++) {
                    echo $file[$i] . "<br>";
                }
            } else {
                echo("Aucun événement n'a encore été enregistré<br><br>Cela semble étrange, vérifiez les droits d'accès de votre serveur et la configuration de PHP");
            }
            
            ?>
            </div>
        <h3>Mémoire tampon hexadécimale</h3>
        <p><table class="message_info"><tbody><tr><td><img src="/resources/image/message_info.svg" class="message_img"></td><td style="width:100%;"><p>Ces informations peuvent vous servir si vous voulez analyser le contenu de la mémoire à accès séquentiel (RAM) ou au cas où le fichier journal est corrompu.</p></td></tr></tbody></table></p>
        <div id="logs">
            <?php

            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
                $file = file($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log");
                for ($i = max(0, count($file)-6); $i < count($file); $i++) {
                    foreach(str_split($file[$i]) as $letter) {
                        echo(strToHex($letter) . " ");
                    }
                }
            } else {
                echo("null");
            }
            
            ?>
        </div><br><br>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>