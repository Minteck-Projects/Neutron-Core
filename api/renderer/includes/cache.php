<?php

// Create cache dir
if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache")) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache");
}

function cacheCheck(string $page) {
    // If something goes wrong, use cache anyway
    $cache = true;

    // Get a list of enabled widgets
    $widgets = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json"));
    if (json_last_error() != JSON_ERROR_NONE) { // If data is corrupted, silently think there are no widgets
        $list = [];
        rlgps("Warning: Widget information is corrupted");
    } else {
        $list = $widgets->list;
    }

    // Check if there is (at least) one widget that disables cache
    foreach ($list as $widget) {
        $data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/$widget/feature.json"));
        if (json_last_error() == JSON_ERROR_NONE) {
            if (isset($data->cache)) {
                if (is_bool($data->cache)) {
                    $cache = $data->cache;
                    if ($data->cache == false) {
                        rlgps("Widget \"$widget\" prevents the use of cache");
                    }
                }
            }
        } else {
            rlgps("Warning: Metadata for the widget \"$widget\" is corrupted");
        }
    }
    
    // Check if an update has been installed
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/last_version")) {
        if (file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/last_version") == file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")) {} else {
            $cache = false;
            require $_SERVER['DOCUMENT_ROOT'] . "/api/admin/cache_content_reset.php";
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/last_version", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version"));
        }
    } else {
        $cache = false;
        require $_SERVER['DOCUMENT_ROOT'] . "/api/admin/cache_content_reset.php";
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/last_version", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version"));
    }

    // Is there any widget that disables cache?
    if ($cache) { // no
        // Does the cached version exists?
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/page-" . $page)) { // yes
            header("X-FNS-NeutronCache: yes");
            echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/cache/page-" . $page)); // So let's output it
            require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/debug.php";debugDump(); // And debug if needed
            return true;
        } else { // no
            header("X-FNS-NeutronCache: no");
            return false; // Let the renderer render the page
        }
    } else { // yes
        header("X-FNS-NeutronCache: no");
        return false; // Let the renderer render the page
    }

    return false;
}