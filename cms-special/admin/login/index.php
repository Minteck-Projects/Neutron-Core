<?php

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

if (isset($_GET['pr'])) {
    if (isset($_GET['pa'])) {
        $callback = $_GET['pr'] . $_GET['pa'];
    } else {
        $callback = $_GET['pr'];
    }
} else {
    $callback = "/cms-special/admin/home";
}

?>

<?php ob_start();echo("<!--\n\n" . str_replace('%year%', date('Y'), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/license")) . "\n\n-->") ?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    $ready = true;
} else {
    $ready = false;
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/headers/preprocessor.php";

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
    <link rel="stylesheet" href="/resources/css/alerts.css">
    <link rel="stylesheet" href="/resources/css/codename.css">
    <link rel="stylesheet" href="/resources/css/ajax.css">
    <link href="<?= $_MD_INCLUDES ?>/material-components-web.min.css" rel="stylesheet">
    <script src="<?= $_MD_INCLUDES ?>/material-components-web.min.js"></script>
    <link rel="stylesheet" href="<?= $_MDI_PATH ?>">
    <?php
        if (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/theme") == "dark") {
            echo('<link rel="stylesheet" href="/cms-special/admin/$resources/index-dark.css">');
        } elseif (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/theme") == "auto") {
            echo('<link rel="stylesheet" href="/cms-special/admin/$resources/index-auto.css">');
        } else {
            echo('<link rel="stylesheet" href="/cms-special/admin/$resources/index.css">');
        }
    ?>
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
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/headers/documenthead.php"; ?>
    <script>

        window.onerror = () => {
            location.href = "/cms-special/admin/login-old";
        }

    </script>
</head>
<body id="login">
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/headers/documentbody.php"; ?>
    <div id="loader" style="display:none;z-index:99;">
        <svg class="spinner" width="48px" height="48px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
            <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
        </svg>
    </div>
    <div id="admin">
        <main class="main-content" id="main-content">
            <img src="/resources/image/login.jpg" id="login-image">
            <div class="content">
                <div class="inner">
                    <img src="/resources/upload/siteicon.png" style="border-radius:100%;" class="intro-element">
                    <h2><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"); ?></h2>

                    <div id="loginwith">
                        <button class="mdc-button mdc-button--raised" id="loginwith-password" onclick="disableAuthKey();">
                            <div class="mdc-button__ripple"></div>
                            <i class="material-icons-outlined mdc-button__icon" aria-hidden="true">vpn_key</i>
                            <span class="mdc-button__label"><?= $lang["admin-login"]["modes"][0] ?></span>
                        </button>
                        <button class="mdc-button mdc-button--outlined" id="loginwith-authkey" <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/authkey")) { echo("disabled"); } else { echo('onclick="enableAuthKey();"'); } ?>>
                            <div class="mdc-button__ripple"></div>
                            <i class="material-icons-outlined mdc-button__icon" aria-hidden="true">fingerprint</i>
                            <span class="mdc-button__label"><?= $lang["admin-login"]["modes"][1] ?></span>
                        </button>
                    </div>
                    <script>useAuthKey = false;</script>

                    <div id="login-password">
                        <div class="nd_Field fallback nd_Field_input" id="searchbox">
                            <input id="password-box" type="password" placeholder="<?= $lang["admin-login"]["password"] ?>" spellcheck="false" autocomplete="off">
	                    </div>
                    </div>

                    <div id="login-authkey" style="display:none;">
                        <div class="nd_Field fallback nd_Field_input" id="searchbox">
                            <input id="authkey-box" type="password" placeholder="<?= $lang["admin-login"]["key"] ?>" spellcheck="false" autocomplete="off">
	                    </div>
                    </div>

                    <button class="mdc-button mdc-button--raised" id="loginwith-password" onclick="loginConfirm();">
                        <div class="mdc-button__ripple"></div>
                        <span class="mdc-button__label"><?= $lang["admin-login"]["confirm"] ?></span>
                    </button>

                    <p>
                        <small id="links">
                            <a onclick="window.parent.location.href = '/';" class="sblink">
                                <?= $lang["admin-login"]["back"] ?>
                            </a>
                            &nbsp;
                            <a onclick="window.open('<?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/api/bugs') ?>');" target="_blank" class="sblink">
                                <?= $lang["admin-login"]["report"] ?>
                            </a>
                            &nbsp;
                            <a onclick="window.open('<?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/api/public') ?>');" class="sblink">
                                <?= $lang["admin-login"]["branding"] ?>
                            </a>
                        </small>
                    </p>
                </div>
            </div>
        </main>
    </div>
</body>

<script>
    function alert(message) {
        alert_full(message);
    }

    function enableAuthKey() {
        useAuthKey = true;
        document.getElementById('loginwith-authkey').classList.remove('mdc-button--outlined');
        document.getElementById('loginwith-authkey').classList.add('mdc-button--raised');
        document.getElementById('loginwith-password').classList.remove('mdc-button--raised');
        document.getElementById('loginwith-password').classList.add('mdc-button--outlined');
        document.getElementById('login-password').style.display = "none";
        document.getElementById('login-authkey').style.display = "";
        document.getElementById('password-box').value = "";
        document.getElementById('authkey-box').value = "";
        document.getElementById('authkey-box').focus();
    }

    function disableAuthKey() {
        useAuthKey = false;
        document.getElementById('loginwith-authkey').classList.add('mdc-button--outlined');
        document.getElementById('loginwith-authkey').classList.remove('mdc-button--raised');
        document.getElementById('loginwith-password').classList.add('mdc-button--raised');
        document.getElementById('loginwith-password').classList.remove('mdc-button--outlined');
        document.getElementById('login-password').style.display = "";
        document.getElementById('login-authkey').style.display = "none";
        document.getElementById('password-box').value = "";
        document.getElementById('authkey-box').value = "";
        document.getElementById('password-box').focus();
    }

    function loginConfirm() {
        $("#loader").fadeIn(200);
        var formData = new FormData();
        if (useAuthKey) {
            formData.append("password", document.getElementById('authkey-box').value);
            formData.append("authkey", "1");
        } else {
            formData.append("password", document.getElementById('password-box').value);
        }
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/login.php",
            success: function (data) {
                $("#loader").fadeOut(200);
                if (data == "ok") {
                    location.href = "<?= $callback ?>";
                } else {
                    alert(data)
                }
            },
            error: function (error) {
                $("#loader").fadeOut(200);
                alert("Erreur de communication")
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
    }
</script>
</html>