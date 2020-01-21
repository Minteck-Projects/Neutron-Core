<?php

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/lang")) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/lang", "fr");
}

$langsel = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/lang");
$lang = [];

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/i18n/" . $langsel)) {
    $langprops = scandir($_SERVER['DOCUMENT_ROOT'] . "/resources/i18n/" . $langsel);
    foreach ($langprops as $langprop) {
        if ($langprop != "." && $langprop != "..") {
            $langpieces = explode("/", implode("/", explode("\\", $langprop)));
            $langitemsel = explode(".", $langpieces[count($langpieces) - 1]);
            $langitem = $langitemsel[count($langitemsel) - 1];
            if ($langitemsel[count($langitemsel) - 1] != "json") {
                die("Unable to load language file: " . implode(".", $langitemsel) . " is not in a valid format. Language files must be JSON.");
            } else {
                json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/i18n/" . $langsel . "/" . $langprop));
                if (json_last_error() == JSON_ERROR_NONE) {
                    $lang[$langitemsel[count($langitemsel) - 2]] = (array)json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/i18n/" . $langsel . "/" . $langprop));
                } else {
                    die("Unable to load language file: " . implode(".", $langitemsel) . " isn't a valid JSON file. Please check for syntax errors and retry.");
                }
            }
        }
    }
} else {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/i18n/fr")) {
        echo("Unable to load language files: unable to find selected language files, loading fallback files");
        $langprops = scandir($_SERVER['DOCUMENT_ROOT'] . "/resources/i18n/fr");
        foreach ($langprops as $langprop) {
            if ($langprop != "." && $langprop != "..") {
                $langpieces = explode("/", implode("/", explode("\\", $langprop)));
                $langitemsel = explode(".", $langpieces[count($langpieces) - 1]);
                $langitem = $langitemsel[count($langitemsel) - 1];
                if ($langitemsel[count($langitemsel) - 1] != "json") {
                    die("Unable to load language file: " . implode(".", $langitemsel) . " is not in a valid format. Language files must be JSON.");
                } else {
                    json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/i18n/fr/" . $langprop));
                    if (json_last_error() == JSON_ERROR_NONE) {
                        $lang[$langitemsel[count($langitemsel) - 2]] = (array)json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/i18n/fr/" . $langprop));
                    } else {
                        die("Unable to load language file: " . implode(".", $langitemsel) . " isn't a valid JSON file. Please check for syntax errors and retry.");
                    }
                }
            }
        }
    } else {
        die("Unable to load language files: unable to find selected language files, and unable to find fallback language files");
    }
}

if (isset($_GET['verboseLang'])) {
    var_dump($lang);
}