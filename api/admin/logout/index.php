<?php

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {
        $tokens = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/tokens");
        foreach ($tokens as $token) {
            if ($token == "." || $token == "..") {} else {
                unlink($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $token);
            }
        }
    }
}
if (isset($_GET['mobile'])) {
    die("<script>location.href = '/cms-special/admin'</script>");
} else {
    die("<script>location.href = '/'</script>");
}