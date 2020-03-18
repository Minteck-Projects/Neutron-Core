<?php

include $_SERVER['DOCUMENT_ROOT'] . "/api/lang/processor.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/render.php";
$buffer = ""; // Initialiser un nouveau tampon vide

function buffer(string $value) {
    global $buffer;
    $buffer = $buffer . $value;
}

buffer("<p>" . $lang["version"]["workswith"] . "<b><a href=\"http://mpcms.rf.gd\" target=\"_blank\">Minteck Projects CMS</a> version " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version") . " \"" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/codename") . "\"</b>" . $lang["version"]["providedby"] . "<a href=\"https://minteck-projects.alwaysdata.net\" target=\"_blank\">Minteck Projects</a>" . $lang["version"]["description"] . "</p>");
buffer("<p>" . $lang["version"]["workswith"] . $lang["version"]["store"][0] . "<b>CMS Store version " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/store_version") . "</b>" . $lang["version"]["store"][1] . "</p>");
buffer("<p>" . $lang["version"]["freesoftware"][0] . "<a href=\"https://www.gnu.org/licenses/gpl-3.0.html\" target=\"_blank\">" . $lang["version"]["freesoftware"][1] . "</a>" . $lang["version"]["freesoftware"][2] . "<a href=\"https://www.gnu.org/licenses/gpl-3.0.html\" target=\"_blank\">" . $lang["version"]["freesoftware"][3] . "</a>" . $lang["version"]["freesoftware"][4] . "</p>");
buffer("<p>" . $lang["version"]["warranty"][0] . "<a href=\"https://www.gnu.org/licenses/gpl-3.0.html\" target=\"_blank\">" . $lang["version"]["warranty"][1] . "</a>" . $lang["version"]["warranty"][2] . "</p>");

buffer("<h2>" . $lang["version"]["resources"] . "</h2>");
buffer("<ul><li><a href=\"http://bugs.minteck-projects.rf.gd/set_project.php?project_id=1\" target=\"_blank\">" . $lang["version"]["support"] . "</a></li>");
buffer("<li><a href=\"http://bugs.minteck-projects.rf.gd/set_project.php?project_id=8\" target=\"_blank\">" . $lang["version"]["storesupport"] . "</a></li>");
buffer("<li><a href=\"https://minteck-projects.alwaysdata.net/prod/info/?el=mpcms\" target=\"_blank\">" . $lang["version"]["mprj"] . "</a></li>");
buffer("<li><a href=\"https://gitlab.com/minteck-projects/mpcms/changelog/issues\" target=\"_blank\">" . $lang["version"]["changelog"] . "</a></li></ul>");

buffer("<h2>" . $lang["version"]["plugins"] . "</h2>");
$exts = (array)json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json"))->list;
buffer("<ul>");
foreach ($exts as $ext) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $ext)) {
        buffer("<li><a target=\"_blank\" href=\"http://" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/store_public") . "/view/?id=" . $ext . "&idType=old\">" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $ext . "/name") . "</a></li>");
    }
}
buffer("</ul>");

buffer("<h2>" . $lang["version"]["stats"] . "</h2>");
buffer("<p><b>" . $lang["version"]["disclaimer"][0] . "</b>" . $lang["version"]["disclaimer"][1] . "</p>");
buffer("<ul>");
buffer("<li>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d")) . $lang["version"]["today"] . "</li>");
$thismonth = 0;
$days = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats");
foreach ($days as $day) {
    if ($day != "." && $day != "..") {
        if (substr($day, 0, 8) == date("Y-m-")) {
            $thismonth = $thismonth + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $day);
        }
    }
}
buffer("<li>" . $thismonth . $lang["version"]["month"] . "</li>");
$thisyear = 0;
$days = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats");
foreach ($days as $day) {
    if ($day != "." && $day != "..") {
        if (substr($day, 0, 5) == date("Y-")) {
            $thisyear = $thisyear + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $day);
        }
    }
}
buffer("<li>" . $thisyear . $lang["version"]["year"] . "</li>");
buffer("</ul>");
buffer("<p><b>" . $lang["version"]["disclaimer"][0] . "</b>" . $lang["version"]["disclaimer"][2] . "</p><p>" . $lang["version"]["antiddos"][0] . "<b>");
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_antiDdos")) {
    buffer($lang["version"]["antiddos"][1]);
} else {
    buffer($lang["version"]["antiddos"][2]);
}
buffer("</b>" . $lang["version"]["antiddos"][3]);
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_antiDdos")) {
    buffer($lang["version"]["antiddos"][4]);
} else {
    buffer($lang["version"]["antiddos"][5]);
}
buffer(".</p>");
if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/bannedIps")) {
    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList")) {
        buffer("<p><center><i>" . $lang["version"]["antiddos"][6] . "</i></center></p>");
    }
} else {
    buffer("<ul>");
    $iplist = count(scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList")) - 2;
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList")) {
        buffer("<li>" . $iplist . $lang["version"]["antiddos"][7] . "<sup><a class=\"hint\" title=\"" . $lang["version"]["antiddos"][8] . "\">[?]</a></sup></li>");
    }
    $banlist = count(scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/bannedIps")) - 2;
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/bannedIps")) {
        buffer("<li>" . $banlist . $lang["version"]["antiddos"][9] . "</li>");
    }
    buffer("</ul>");
}

renderSpecial($buffer, $lang["version"]["title"]);

?>