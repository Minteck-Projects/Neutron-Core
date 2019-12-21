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
                        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $ppath)) {
                            buffer("<div class=\"photo\">");
                            buffer("<a href=\"/cms-special/galery/preview/?url=" . $ppath . "&return=/cms-special/galery\"><img class=\"photo_image\" src=\"" . $ppath . "\" /></a>");
                            if (isset(explode("|", $praw)[2])) {
                                buffer("<br><span class=\"photo_label\">" . explode("|", $praw)[2] . "</span>");
                            }
                            buffer("</div>");
                        } else {
                            buffer("<div class=\"photo\">");
                            buffer('<p><table class="message_error message_black"><tbody><tr><td><img src="/resources/image/message_error.svg" class="message_img"></td><td style="width:100%;">Photo introuvable ou supprimée incorrectement, merci de contacter l\'administrateur du site</td></tr></tbody></table></p>');
                            buffer("</div>");
                        }
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
buffer("<script>window.onload = () => {setTimeout(() => {Array.from(document.getElementsByClassName('photo_image')).forEach((el) => {el.classList.add('loaded')});}, 1000)}</script>");

renderSpecial($buffer, 'Galerie de photos');

?>