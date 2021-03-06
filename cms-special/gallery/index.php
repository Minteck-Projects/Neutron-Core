<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/api/engine-cyclic/render.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/api/lang/processor.php";
$buffer = ""; // Initialiser un nouveau tampon vide

function buffer(string $value) {
    global $buffer;
    $buffer = $buffer . $value;
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures") && count(scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures")) > 2) {
    $categories = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories");
    array_push($categories, "unclassed");
    foreach ($categories as $category) {
        if ($category != "." && $category != "..") {
            $shown = false;
            if ($category == "unclassed") {
                buffer("<h2>" . $lang["gallery"]["unclassed"] . "</h2>");
            } else {
                buffer("<h2>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories/" . $category) . "</h2>");
            }
            buffer(" style=\"text-align: center;\">");
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
                                buffer("<br><div class=\"photo_label\">" . explode("|", $praw)[2] . "</div>");
                            }
                            buffer("</div>");
                        } else {
                            buffer("<div class=\"photo\">");
                            buffer('<p><table class="message_error message_black"><tbody><tr><td><img src="/resources/image/message_error.svg" class="message_img"></td><td style="width:100%;">' . $lang["gallery"]["error"] . '</td></tr></tbody></table></p>');
                            buffer("</div>");
                        }
                    }
                }
            }
            if (!$shown) {
                buffer("<p><div style=\"text-align: center;\"><i>" . $lang["gallery"]["nothing"] . "</i></div></p>");
            }
            buffer("</center></div></center>");
        }
    }
} else {
    buffer("<div style=\"text-align: center;\"><i>" . $lang["gallery"]["disabled"][0] . "<b>" . $lang["gallery"]["disabled"][1] . "</b>" . $lang["gallery"]["disabled"][2] . "</i></div>");
}
buffer("<script>window.onload = () => {setTimeout(() => {Array.from(document.getElementsByClassName('photo_image')).forEach((el) => {el.classList.add('loaded')});}, 1000)}</script>");

renderSpecial($buffer, $lang["gallery"]["title"]);

?>