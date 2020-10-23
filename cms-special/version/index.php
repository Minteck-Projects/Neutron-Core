<?php

require $_SERVER['DOCUMENT_ROOT'] . "/api/lang/processor.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/render.php";
$buffer = ""; // Initialiser un nouveau tampon vide

function buffer(string $value) {
    global $buffer;
    $buffer = $buffer . $value;
}

buffer("<p>" . $lang["version"]["workswith"] . "<b><a href=\"" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/public") . "\" target=\"_blank\">FNS Neutron</a> version " . str_replace("#", substr(md5(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")), 0, 2), file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version")) . " \"" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/codename") . "\"</b>" . $lang["version"]["renderer"][0] . "<b>" . $_RENDERER . $lang["version"]["renderer"][1] . $_VERSION . "</b>" . $lang["version"]["providedby"] . "<a href=\"https://minteck-projects.alwaysdata.net\" target=\"_blank\">Minteck Projects</a>" . $lang["version"]["description"] . "</p>");
buffer("<p>" . $lang["version"]["freesoftware"][0] . "<a href=\"https://www.gnu.org/licenses/gpl-3.0.html\" target=\"_blank\">" . $lang["version"]["freesoftware"][1] . "</a>" . $lang["version"]["freesoftware"][2] . "<a href=\"https://www.gnu.org/licenses/gpl-3.0.html\" target=\"_blank\">" . $lang["version"]["freesoftware"][3] . "</a>" . $lang["version"]["freesoftware"][4] . "</p>");
buffer("<p>" . $lang["version"]["warranty"][0] . "<a href=\"https://www.gnu.org/licenses/gpl-3.0.html\" target=\"_blank\">" . $lang["version"]["warranty"][1] . "</a>" . $lang["version"]["warranty"][2] . "</p>");

buffer("<h2>" . $lang["version"]["resources"] . "</h2>");
buffer("<ul><li><a href=\"" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/bugs") . "/set_project.php?project_id=1\" target=\"_blank\">" . $lang["version"]["support"] . "</a></li>");
// buffer("<li><a href=\"" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/bugs") . "/set_project.php?project_id=8\" target=\"_blank\">" . $lang["version"]["storesupport"] . "</a></li>");
buffer("<li><a href=\"https://minteck-projects.alwaysdata.net/prod/info/?el=mpcms\" target=\"_blank\">" . $lang["version"]["mprj"] . "</a></li>");
buffer("<li><a href=\"https://gitlab.com/minteck-projects/mpcms/changelog/issues\" target=\"_blank\">" . $lang["version"]["changelog"] . "</a></li></ul>");

renderSpecial($buffer, $lang["version"]["title"]);

?>