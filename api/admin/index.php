<?php

// Token validation
//
if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {
        // Token is valid
    }
}

?>

<?php

$invalid = false;

if (isset($_POST['password'])) {
    // var_dump($_GET);
    // echo("<br>");
    // var_dump($_POST);
    // die();
    if (isset($_GET['pr'])) {
        if (isset($_GET['pa'])) {
            $callback = $_GET['pr'] . $_GET['pa'];
        } else {
            $callback = $_GET['pr'];
        }
    } else {
        $callback = "/cms-special/admin/home";
    }
    if (password_verify($_POST['password'], file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/password"))) {
        $token = str_ireplace("/", "-", password_hash(password_hash(rand(0, 999999) + rand(0, 999999) + rand(0, 999999) + rand(0, 999999) + rand(0, 999999), PASSWORD_BCRYPT, ['cost' => 12,]), PASSWORD_BCRYPT, ['cost' => 12,]));
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens")) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/tokens");
        }
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $token, "");
        header("Set-Cookie: ADMIN_TOKEN={$token}; Path=/; Http-Only; SameSite=Strict");
        die("<script>location.href = '" . $callback . "';</script>");
        return;
    } else {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/adminkey")) {
            if (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/adminkey") == $_POST['password']) {
                $token = str_ireplace("/", "-", password_hash(password_hash(rand(0, 999999) + rand(0, 999999) + rand(0, 999999) + rand(0, 999999) + rand(0, 999999), PASSWORD_BCRYPT, ['cost' => 12,]), PASSWORD_BCRYPT, ['cost' => 12,]));
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens")) {
                    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/tokens");
                }
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $token, "");
                header("Set-Cookie: ADMIN_TOKEN={$token}; Path=/; Http-Only; SameSite=Strict");
                die("<script>location.href = ''" . $callback . "';</script>");
                return;
            } else {
                $invalid = true;
            }
        } else {
            $invalid = true;
        }
    }
}

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {
        if (isset($_GET['pr'])) {
            if (isset($_GET['pa'])) {
                $callback = $_GET['pr'] . $_GET['pa'];
            } else {
                $callback = $_GET['pr'];
            }
        } else {
            $callback = "/cms-special/admin/home";
        }
        die("<script>location.href = '" . $callback . "';</script>");
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
        echo("Connexion - Administration du site - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
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
<body id="login">
    <div class="centered">
        <span class="intro"><img src="/resources/image/admin_appearance.png" class="blk1 intro-element"> - <img src="/resources/image/admin_housekeeping.png" class="blk2 intro-element"> - <img src="/resources/image/admin_pages.png" class="blk3 intro-element"> - <img src="/resources/image/admin_updates.png" class="blk4 intro-element"> - <img src="/resources/image/admin_plugins.png" class="blk5 intro-element"></span>
        <h2>Administration du site</h2>
        <?php if ($invalid) {echo('<div id="error">Le mot de passe est incorrect</div>');} ?>
        <form action="./<?php if (isset($_GET['pr'])) {echo("?pr=" . $_GET['pr']);if (isset($_GET['pa'])) {echo("&pa=" . urlencode($_GET['pa']));}} ?>" method="post">
            <input name="password" type="password" placeholder="Mot de passe"><br><br>
            <input type="submit" class="button" href="/" value="Connexion">
        </form><br>
        <center><div id="loginnotice" style="margin:0% 30%;"><b>Note :</b><p>Vous pouvez aussi vous connecter en utilisant la clé d'administration de votre site. Elle est située dans le fichier <code>/data/adminkey</code> et permet à l'administrateur réseau de se connecter, quel que soit le mot de passe du webmaster.</p><p>Par défaut, le fichier n'existe pas. Il vous suffit de le créer</p></div></center>
    </div>
</body>
</html>