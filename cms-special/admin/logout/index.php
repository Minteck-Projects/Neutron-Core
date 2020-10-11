<?php

if (isset($_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN']) && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != "." && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != ".." && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != "/") {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'])) {
        $tokens = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/tokens");
        foreach ($tokens as $token) {
            if ($token == "." || $token == "..") {} else {
                unlink($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $token);
            }
        }
    }
}
header("Location: /cms-special/admin/login");
die();