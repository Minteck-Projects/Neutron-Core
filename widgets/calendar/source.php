<?php

function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

?>

<div id="widget-space">
    <ul>
    <?php

    $jsonraw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json");
    if (isJson($jsonraw)) {
        $json = json_decode($jsonraw);
        $eventlist = [];
        foreach ($json->events as $event) {
            if (isset($event->timestamp)) {
                array_push($eventlist, $event->timestamp);
            }
        }
        sort($eventlist);
        $pos = 1;
        $shown = 0;
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/calendar_events")) {
            $calevn = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/calendar_events");
        } else {
            $calevn = "3";
        }
        foreach ($eventlist as $event) {
            if ($pos == ($calevn + 1)) {} else {
                foreach ($json->events as $el) {
                    if (isset($el->timestamp)) {
                        if ($el->timestamp == $event) {
                            (int)$currentDate = date("Ymd");
                            if ($currentDate < $el->timestamp) {
                                $shown = $shown + 1;
                                echo("<li><b>" . $el->datestr . "</b> : " . $el->name . "</li><i>" . $el->description . "</i>");
                                $pos = $pos + 1;
                            }
                            if ($currentDate == $el->timestamp) {
                                $shown = $shown + 1;
                                echo("<li><b>Aujourd'hui</b> : " . $el->name . "</li><i>" . $el->description . "</i>");
                                $pos = $pos + 1;
                            }
                        }
                    }
                }
            }
        }
        if ($shown == "0") {
            echo("</ul><center><i>Aucun événement à venir</i></center>");
        }
    } else {
        echo("<b>Base de données du calendrier corrompue</b>");
    }

    ?>
    </ul>
    <small><a href="/cms-special/calendar">Tout voir...</a></small>
</div>