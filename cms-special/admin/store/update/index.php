<?php

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store")) {
    die("<script>location.href = '/cms-special/admin/store';</script>");
}

if (isset($_GET['id'])) {
    $foundone = false;
    $db = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store/packages.json"));
    foreach ($db as $package) {
        if (array_search($package, (array)$db) == $_GET['id']) {
            $pf = $package;
            $name = $package->name;
            $foundone = true;
        }
    }
    if ($foundone) {
        $package = $pf;
    } else {
        $package = null;
    }
    if (!$foundone) {
        die("<script>location.href = '/cms-special/admin/store';</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/store';</script>");
}

?>
<?php $pageConfig = [ "domName" => "Mise à jour - {$name} - CMS Store", "headerName" => "Mettre à jour {$name}" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <?php
        
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store")) {
            die("<script>location.href = \"/cms-special/admin/store\"</script></div></body></html>");
        }

        ?>
        <?php

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db))) {
            echo("<br><br><center><img src=\"/resources/image/storeloader.svg\" width=\"48px\" height=\"48px\" style=\"filter:brightness(50%);\"><br><span id=\"loadmsg\">Mise à jour de l'extension...</span></center><br><br>");
            $install = true;
        } else {
            echo("<center><br><br>L'extension n'est pas installée<br><br><a onclick=\"history.back()\" class=\"sblink\">Retour</a></center>");
        }

        ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

window.onload = () => {
    if (<?php if($install === true){echo("true");}else{echo("false");}; ?>) {
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/update_plugin.php?id=<?= array_search($package, (array)$db) ?>",
            success: function (data) {
                if (data == "ok") {
                    document.getElementById('loadmsg').innerHTML = "Terminé"
                    location.href = "/cms-special/admin/store/package/?id=<?= array_search($package, (array)$db) ?>"
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