<?php

if (isset($_POST['password'])) {
    if (isset($_POST['authkey'])) { // Use authentication key
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/authkey")) {
            if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/authkey")) == $_POST['password']) {
                $token = str_ireplace("/", "-", password_hash(password_hash(rand(0, 999999) + rand(0, 999999) + rand(0, 999999) + rand(0, 999999) + rand(0, 999999), PASSWORD_BCRYPT, ['cost' => 12,]), PASSWORD_BCRYPT, ['cost' => 12,]));
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens")) {
                    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/tokens");
                }
                $tokens = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/tokens");
                foreach ($tokens as $deltoken) {
                    if ($deltoken == "." || $deltoken == "..") {} else {
                        unlink($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $deltoken);
                    }
                }
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $token, "");
                header("Set-Cookie: _MPCMS_ADMIN_TOKEN={$token}; Path=/; Http-Only; SameSite=Strict");
                die("ok");
                return;
            } else {
                die("Clé privée incorrecte");
            }
        } else {
            die("Pas de clé privée");
        }
    } else { // Use regular password
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
            header("Set-Cookie: _MPCMS_ADMIN_TOKEN={$token}; Path=/; Http-Only; SameSite=Strict");
            die("ok");
            return;
        } else {
            die("Mot de passe incorrect");
        }
    }
} else {
    die("Pas de mot de passe spécifié");
}