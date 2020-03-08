<?php

$invalid = false;

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {

    } else {
        if (isset($_GET['id'])) {
            die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/store/ext-install/&pa=?id=" . $_GET['id'] . "'</script>");
        } else {
            die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/store/ext-install&pa='</script>");
        }
    }
} else {
    if (isset($_GET['id'])) {
        die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/store/ext-install/&pa=?id=" . $_GET['id'] . "'</script>");
    } else {
        die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/store/ext-install&pa='</script>");
    }
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

<?php ob_start();echo("<!--\n\n" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/license") . "\n\n-->") ?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    $ready = true;
} else {
    $ready = false;
}

?>
<?php

if (isset($_GET['id'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store")) {
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
} else {
    die("<script>location.href = '/cms-special/admin/store';</script>");
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
        echo("Installation de {$name} - CMS Store - Administration du site - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
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
        <?php

        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store")) {
            die("<script>location.href = \"/cms-special/admin/store/ext-init\"</script></div></body></html>");
        }

        ?>
        <?php

        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . array_search($package, (array)$db))) {
            echo("<br><br><center><img src=\"/resources/image/storeloader.svg\" width=\"48px\" height=\"48px\" style=\"filter:brightness(50%);\"><br><span id=\"loadmsg\">Installation de l'extension...</span></center><br><br>");
            $install = true;
        } else {
            echo("<center><br><br>L'extension est déjà installée<br><br><a onclick=\"window.close()\" class=\"sblink\">Retour</a></center>");
            $install = false;
        }

        ?>
    </div>
</body>

<script>

window.onload = () => {
    if (<?php if($install === true){echo("true");}else{echo("false");}; ?>) {
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/install_plugin.php?id=<?= array_search($package, (array)$db) ?>",
            success: function (data) {
                if (data == "ok") {
                    document.getElementById('loadmsg').innerHTML = "Terminé"
                    window.close()
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

</html>
