<?php $pageConfig = [ "domName" => "CMS Store", "headerName" => "CMS Store" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
    <p><table class="message_info"><tbody><tr><td><img src="/resources/image/message_info.svg" class="message_img"></td><td style="width:100%;"><p>Le CMS Store intégré sera retiré de Minteck projects CMS lors de la version 3.0 LTS pour être entièrement remplacé par le site officiel du CMS Store. Si vous ne mettez pas à jour lors de la sortie de la version 3.0 LTS, vous ne pourrez plus utiliser le CMS Store.</p></td></tr></tbody></table></p>
        <?php
        
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store")) {
            echo("<br><br><center><img src=\"/resources/image/storeloader.svg\" width=\"48px\" height=\"48px\" style=\"filter:brightness(50%);\"><br><span id=\"loadmsg\">Construction de la base de données...</span></center><br><br>");
        } else {
            if (isJson(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store/packages.json"))) {
                echo("<p><a href=\"/cms-special/admin/store/dbupdate\" class=\"sblink\">Regénérer la base de données</a></p><p>Cliquez sur le nom d'une extension pour en savoir plus, l'installer/la désinstaller/la mettre à jour, voir les permissions, et plus</p><table cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;border-collapse: separate;border-spacing: 0px;\"><tbody style=\"width:100%;\"><tr><td class=\"storelist\"><center><b>Paquet</b></center></td><td class=\"storelist\"><center><b>Nom</b></center></td><td class=\"storelist\"><center><b>Développeur</b></center></td><td class=\"storelist\"><center><b>Langage de programmation</b></center></td></tr>");
                $db = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store/packages.json"));
                foreach ($db as $package) {
                    $packagename = array_search($package, (array)$db);
                    echo("<tr><td class=\"storelist\"><center><code>" . $packagename . "</code></center></td><td class=\"storelist\"><center><a class=\"sblink\" href=\"/cms-special/admin/store/package/?id=" . $packagename . "\">" . $package->name . "</a></center></td><td class=\"storelist\"><center>" . $package->author . "</center></td><td class=\"storelist\"><center>" . $package->language . "</center></td></tr>");
                }
            } else {
                echo('<p><table class="message_warning"><tbody><tr><td><img src="/resources/image/message_warning.svg" class="message_img"></td><td style="width:100%;"><p>La base de données des paquets du CMS Store est corrompue, vous devez donc <a href="/cms-special/admin/store/dbupdate" class="sblink">la regénérer en cliquant ici</a>, auquel cas elle n\'est pas exploitable par Minteck Projects CMS.</p><p>Cette corruption peut se produire si vous tentez de mettre à jour la base de données lorsque le serveur n\'a pas accès à Internet, ou que vous la modifiez vous-même.</p></td></tr></tbody></table></p>');
            }
            echo("</tbody></table>");
            echo("<p><center><i><b>CMS Store</b> version " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/store_version") . "</i></center></p>");
        }

        ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

window.onload = () => {
    if (<?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store")) { echo("true"); } else { echo("false"); } ?>) {} else {
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/store_setup.php",
            success: function (data) {
                if (data == "ok") {
                    document.getElementById('loadmsg').innerHTML = "Terminé"
                    location.reload()
                } else {
                    document.getElementById('loadmsg').innerHTML = "Une erreur s'est produite : " + data;
                }
            },
            error: function (error) {
                document.getElementById('loadmsg').innerHTML = "Erreur de communication";
                window.onbeforeunload = undefined;
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
}

</script>