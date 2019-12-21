<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/render.php";
$buffer = ""; // Initialiser un nouveau tampon vide

function buffer(string $value) {
    global $buffer;
    $buffer = $buffer . $value;
}

buffer("<p>Ce site fonctionne en utilisant <b><a href=\"http://mpcms.rf.gd\" target=\"_blank\">Minteck Projects CMS</a> version " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version") . "</b>, un logiciel fourni par <a href=\"https://minteck-projects.alwaysdata.net\" target=\"_blank\">Minteck Projects</a> pour créer des sites Web facilement et rapidement, et sans même avoir une quelconque connaissance en développement Web ou en gestion de sites Web. Si ce site se termine en .mpcms.rf.gd, il s'agit d'un site partenaire Minteck Projects.</p>");
buffer("<p>Ce site fonctionne en utilisant le <b>CMS Store version " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/store_version") . "</b>, une fonctionnalité de Minteck Projects CMS permettant d'y intégrer des extensions provenant d'éditeurs tiers qui peuvent être téléchargées depuis Internet</p>");
buffer("<p>Ce logiciel est un logiciel libre ; vous pouvez le redistribuer et/ou le modifier sous les termes de la <a href=\"https://www.gnu.org/licenses/gpl-3.0.fr.html\" target=\"_blank\">licence publique générale GNU comme publiée par la Free Software Foundation</a>, soit la <a href=\"https://www.gnu.org/licenses/gpl-3.0.fr.html\" target=\"_blank\">version 3</a> de la Licence, soit (selon votre choix) n'importe quelle version supérieure.</p>");
buffer("<p>Ce logiciel est distribué dans l'espoir qui sera utile, mais SANS AUCUNE GARANTIE ; même pas la garantie implicite de VALEUR MARCHANDE ou d'APTITUDE À UNE UTILISATION SPÉCIFIQUE. Consultez la <a href=\"https://www.gnu.org/licenses/gpl-3.0.fr.html\" target=\"_blank\">licence publique générale GNU</a> pour plus de détails.</p>");

buffer("<h2>Ressources importantes</h2>");
buffer("<ul><li><a href=\"https://gitlab.com/minteck-projects/mpcms/code-base/issues\" target=\"_blank\">Support technique du logiciel/Suggestions de fonctionnalités</a></li>");
buffer("<li><a href=\"https://gitlab.com/minteck-projects/mpcms/plugins/issues\" target=\"_blank\">Support technique du magasin d'extensions</a></li>");
buffer("<li><a href=\"https://minteck-projects.alwaysdata.net/prod/info/?el=mpcms\" target=\"_blank\">Voir sur le site de Minteck Projects</a></li>");
buffer("<li><a href=\"https://gitlab.com/minteck-projects/mpcms/changelog/issues\" target=\"_blank\">Demander un changement dans les notes de mise à jour</a></li></ul>");

buffer("<h2>Extensions activées</h2>");
$exts = (array)json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json"))->list;
buffer("<ul>");
foreach ($exts as $ext) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $ext)) {
        buffer("<li><a href=\"#\">" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $ext . "/name") . "</a></li>");
    }
}
buffer("</ul>");

buffer("<h2>Statistiques de ce site</h2>");
buffer("<p><b>Ces statistiques sont à prendre avec des pincettes</b>, car l'administrateur du site Web peut les avoir faussées en modifiant le fichier, et cela compte plusieurs fois les visites des différentes pages par un même utilisateur.</p>");
buffer("<ul>");
buffer("<li>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d")) . " visite(s) aujourd'hui</li>");
$thismonth = 0;
$days = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats");
foreach ($days as $day) {
    if ($day != "." && $day != "..") {
        if (substr($day, 0, 8) == date("Y-m-")) {
            $thismonth = $thismonth + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $day);
        }
    }
}
buffer("<li>" . $thismonth . " visite(s) ce mois-ci</li>");
$thisyear = 0;
$days = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats");
foreach ($days as $day) {
    if ($day != "." && $day != "..") {
        if (substr($day, 0, 5) == date("Y-")) {
            $thisyear = $thisyear + (int)file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . $day);
        }
    }
}
buffer("<li>" . $thisyear . " visite(s) cette année</li>");
buffer("</ul>");
buffer("<p><b>Ces statistiques sont à prendre avec des pincettes</b>, car elles peuvent ne plus être à jour si l'administrateur du site a désactivé l'option de CMS Sémantique.</p><p>La protection anti-DDOS est actuellement <b>");
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_antiDdos")) {
    buffer("activée");
} else {
    buffer("désactivée");
}
buffer("</b> sur ce site, ");
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_antiDdos")) {
    buffer("les informations sont à jour");
} else {
    buffer("les informations peuvent ne plus être à jour");
}
buffer(".</p>");
if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/bannedIps")) {
    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList")) {
        buffer("<p><center><i>La protection anti-DDOS n'a jamais été activée sur ce site, aucun contenu ne peut être affiché ici.</i></center></p>");
    }
}

buffer("<ul>");
$iplist = count(scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList")) - 2;
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ipbList")) {
    buffer("<li>" . $iplist . " visiteur(s) uniques enregistrés sur ce site <sup><a class=\"hint\" title=\"Les visites uniques sont enregistrées en utilisant la valeur du chiffrement de l'adresse IP. Toutefois, une adresse IP peut avoir appartenue à plusieurs personnes, même si cela est rare...\">[?]</a></sup></li>");
}
$banlist = count(scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/bannedIps")) - 2;
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/bannedIps")) {
    buffer("<li>" . $banlist . " bannissement(s) de visiteurs enregistrés sur ce site</li>");
}
buffer("</ul>");

renderSpecial($buffer, 'Version du logiciel');

?>