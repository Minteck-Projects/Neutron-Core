<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/render.php";
$buffer = ""; // Initialiser un nouveau tampon vide

function buffer(string $value) {
    global $buffer;
    $buffer = $buffer . $value;
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/enabled")) {
    $categories = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories");
    array_push($categories, "unclassed");
    foreach ($categories as $category) {
        if ($category != "." && $category != "..") {
            $shown = false;
            if ($category == "unclassed") {
                buffer("<h2>Non classé</h2>");
            } else {
                buffer("<h2>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories/" . $category) . "</h2>");
            }
            buffer("<center><div id=\"galery_thumbnails\"><center>");
            $photos = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures");
            foreach ($photos as $photo) {
                if ($photo == "." || $photo == "..") {} else {
                    $praw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $photo);
                    $pcat = explode("|", $praw)[1];
                    $ppath = explode("|", $praw)[0];
                    if ($pcat == $category) {
                        $shown = true;
                        buffer("<div class=\"photo\">");
                        buffer("<a href=\"/cms-special/galery/preview/?url=" . $ppath . "\"><img class=\"photo_image\" src=\"" . $ppath . "\" /></a>");
                        buffer("</div>");
                    }
                }
            }
            if (!$shown) {
                buffer("<p><center><i>Aucun photo dans cette catégorie</i></center></p>");
            }
            buffer("</center></div></center>");
        }
    }
} else {
    buffer("<center><i>La <b>galerie de photos</b> n'est pas activée sur ce site</i></center>");
}

renderSpecial($buffer, 'Galerie de photos');

?>