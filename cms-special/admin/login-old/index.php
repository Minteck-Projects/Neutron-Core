<?php

$invalid = false;

if (isset($_POST['authkey'])) {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("UNSUPPORTED");
} else {
    if (isset($_POST['password'])) {
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
            $tokens = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/tokens");
            foreach ($tokens as $atoken) {
                if ($atoken == "." || $atoken == "..") {} else {
                    unlink($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $atoken);
                }
            }
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $token, "");
            header("Set-Cookie: _FNS_NEUTRON_ADMIN_TOKEN={$token}; Path=/; Http-Only; SameSite=Strict");
            header("Location: " . $callback);
            return;
        } else {
            $invalid = true;
        }
    }
}

if (isset($_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN']) && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != "." && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != ".." && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != "/") {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'])) {
        if (isset($_GET['pr'])) {
            if (isset($_GET['pa'])) {
                $callback = $_GET['pr'] . $_GET['pa'];
            } else {
                $callback = $_GET['pr'];
            }
        } else {
            $callback = "/cms-special/admin/home";
        }
        header("Location: " . $callback);
    }
}

?>

<?php ob_start();echo("<!--\n\n" . str_replace('%year%', date('Y'), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/license")) . "\n\n-->") ?>
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
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/header.php"; ?>
    <title><?php

    if ($ready) {
        echo($lang["login"]["login"] . " - " . $lang["login"]["title"] .  " - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
    } else {
        echo("Neutron");
    }

    ?></title>
    <?php
        if (!$ready) {
            require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("<script>location.href = '/cms-special/setup';</script></head>");
        }
    ?>
</head>
<body id="login">
    <div class="centered">
        <img src="/resources/upload/siteicon.png" style="border-radius:100%;" class="intro-element">
        <h2 style="margin-bottom:0;"><?= $lang["login"]["title"] ?></h2>
        <p><small><?= str_replace("}", "</a>", str_replace("{", "<a class=\"clink\" href=\"/cms-special/admin/login\">", $lang["login"]["redirect"])); ?></small></p>
        <p><?php
        
        if (isset($_GET['authkey'])) {
            echo('<small>' . $lang["login"]["uauth"] . '<br><a href="." class="clink">' . $lang['login']['pass'] . '</a></small>');
        } else {
            echo('<small>' . $lang["login"]["upass"] . '<br><a href="./?authkey" class="clink">' . $lang['login']['auth'] . '</a></small>');
        }
        
        ?></p>
        <?php if ($invalid) {echo('<div id="error">' . $lang["login"]["invalid"] . '</div>');} ?>

        <?php if (!isset($_GET['authkey'])): ?>
            <form action="./<?php if (isset($_GET['pr'])) {echo("?pr=" . $_GET['pr']);if (isset($_GET['pa'])) {echo("&pa=" . urlencode($_GET['pa']));}} ?>" method="post">
                <input name="password" type="password" placeholder="<?= isset($_GET['authkey']) ? $lang["login"]["authph"] : $lang["login"]["password"] ?>"><br><br>
                <input type="submit" class="button" href="/" value="<?= $lang["login"]["login"] ?>">
            </form><br>
        <?php else: ?>
            <form action="#" method="post">
                <input name="authkey" type="password" placeholder="<?= isset($_GET['authkey']) ? $lang["login"]["authph"] : $lang["login"]["password"] ?>" disabled><br><br>
                <small><?= $lang["login"]["nokey"][0] . " <a class=\"clink\" href=\"/cms-special/admin/login\">" . $lang["login"]["nokey"][1] . "</a> " . $lang["login"]["nokey"][2] ?></small>
            </form><br>
        <?php endif ?>
    </div>
</body>
</html>