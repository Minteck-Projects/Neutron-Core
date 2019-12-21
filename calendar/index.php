<?php

function dbtest($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/render.php";
$buffer = ""; // Initialiser un nouveau tampon vide

function buffer(string $value) {
    global $buffer;
    $buffer = $buffer . $value;
}

    $jsonraw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json");
    if (dbtest($jsonraw)) {
        $json = json_decode($jsonraw);
        $eventlist = [];
        $eventlistpassed = [];
        foreach ($json->events as $event) {
            if (isset($event->timestamp)) {
                (int)$currentDate = date("Ymd");
                if ($currentDate < $event->timestamp || $currentDate == $event->timestamp) {
                    array_push($eventlist, $event->timestamp);
                } else {
                    array_push($eventlistpassed, $event->timestamp);
                }
            }
        }
        sort($eventlist);
        sort($eventlistpassed);
        $pos = 1;
        $shown = 0;
        buffer("<h2>Événements à venir</h2>");
        foreach ($eventlist as $event) {
            if (1 == 2) {} else {
                foreach ($json->events as $el) {
                    if (isset($el->timestamp)) {
                        if ($el->timestamp == $event) {
                            (int)$currentDate = date("Ymd");
                            if ($currentDate < $el->timestamp) {
                                $shown = $shown + 1;
                                buffer("<h3>" . $el->datestr . "</h3><ul><li>" . $el->name . "</li>");
                                if ($el->description != "") {
                                    buffer("<li>" . $el->description . "</li>");
                                }
                                if (isset($el->link)) {
                                    if ($el->link != "") {
                                        buffer("<br><li><a target=\"_blank\" href=\"" . $el->link . "\" title=\"Ouvrir un site associé à cet événement dans un nouvel onglet\">En savoir plus (site externe)</a></li>");
                                    }
                                }
                                buffer("</ul>");
                                $pos = $pos + 1;
                            }
                            if ($currentDate == $el->timestamp) {
                                $shown = $shown + 1;
                                buffer("<h3>Aujourd'hui</h3><ul><li>" . $el->name . "</li>");
                                if ($el->description != "") {
                                    buffer("<li>" . $el->description . "</li>");
                                }
                                if (isset($el->link)) {
                                    if ($el->link != "") {
                                        buffer("<br><li><a target=\"_blank\" href=\"" . $el->link . "\" title=\"Ouvrir un site associé à cet événement dans un nouvel onglet\">En savoir plus (site externe)</a></li>");
                                    }
                                }
                                buffer("</ul>");
                                $pos = $pos + 1;
                            }
                            if ($currentDate > $el->timestamp) {
                                $shown = $shown + 1;
                                buffer("<h3>Événement passé (" . $el->datestr . ")</h3><ul><li>" . $el->name . "</li>");
                                if ($el->description != "") {
                                    buffer("<li>" . $el->description . "</li>");
                                }
                                if (isset($el->link)) {
                                    if ($el->link != "") {
                                        buffer("<br><li><a target=\"_blank\" href=\"" . $el->link . "\" title=\"Ouvrir un site associé à cet événement dans un nouvel onglet\">En savoir plus (site externe)</a></li>");
                                    }
                                }
                                buffer("</ul>");
                                $pos = $pos + 1;
                            }
                        }
                    }
                }
            }
        }
        if ($shown == "0") {
            buffer("</ul><center><i>Aucun événement à venir</i></center>");
        }
        buffer("<h2>Événements passés</h2>");
        $pos = 1;
        $shown = 0;
        foreach ($eventlistpassed as $event) {
            if (1 == 2) {} else {
                foreach ($json->events as $el) {
                    if (isset($el->timestamp)) {
                        if ($el->timestamp == $event) {
                            (int)$currentDate = date("Ymd");
                            if ($currentDate < $el->timestamp) {
                                $shown = $shown + 1;
                                buffer("<h3>" . $el->datestr . "</h3><ul><li>" . $el->name . "</li>");
                                if ($el->description != "") {
                                    buffer("<li>" . $el->description . "</li>");
                                }
                                if (isset($el->link)) {
                                    if ($el->link != "") {
                                        buffer("<br><li><a target=\"_blank\" href=\"" . $el->link . "\" title=\"Ouvrir un site associé à cet événement dans un nouvel onglet\">En savoir plus (site externe)</a></li>");
                                    }
                                }
                                buffer("</ul>");
                                $pos = $pos + 1;
                            }
                            if ($currentDate == $el->timestamp) {
                                $shown = $shown + 1;
                                buffer("<h3>Aujourd'hui</h3><ul><li>" . $el->name . "</li>");
                                if ($el->description != "") {
                                    buffer("<li>" . $el->description . "</li>");
                                }
                                if (isset($el->link)) {
                                    if ($el->link != "") {
                                        buffer("<br><li><a target=\"_blank\" href=\"" . $el->link . "\" title=\"Ouvrir un site associé à cet événement dans un nouvel onglet\">En savoir plus (site externe)</a></li>");
                                    }
                                }
                                buffer("</ul>");
                                $pos = $pos + 1;
                            }
                            if ($currentDate > $el->timestamp) {
                                $shown = $shown + 1;
                                buffer("<h3>" . $el->datestr . "</h3><ul><li>" . $el->name . "</li>");
                                if ($el->description != "") {
                                    buffer("<li>" . $el->description . "</li>");
                                }
                                if (isset($el->link)) {
                                    if ($el->link != "") {
                                        buffer("<br><li><a target=\"_blank\" href=\"" . $el->link . "\" title=\"Ouvrir un site associé à cet événement dans un nouvel onglet\">En savoir plus (site externe)</a></li>");
                                    }
                                }
                                buffer("</ul>");
                                $pos = $pos + 1;
                            }
                        }
                    }
                }
            }
        }
        if ($shown == "0") {
            buffer("</ul><center><i>Aucun événement passé</i></center>");
        }
    } else {
        buffer("<b>Base de données du calendrier corrompue</b>");
    }

renderSpecial($buffer, 'Calendrier');

?>