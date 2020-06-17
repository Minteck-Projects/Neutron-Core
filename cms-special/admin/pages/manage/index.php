<?php

if (isset($_GET['slug'])) {
    $currentSlug = $_GET['slug'];
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $currentSlug)) {} else {
        die("<script>location.href = '/cms-special/admin/pages';</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/pages';</script>");
}

if ($currentSlug == "index") {
    $currentName = "Accueil";
    echo("<script>page = \"Accueil\"</script>");
} else {
    $currentName = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $currentSlug . "/pagename");
    echo("<script>page = \"{$currentSlug}\"</script>");
}

?>
<?php $pageConfig = [ "domName" => $currentName . " - Pages", "headerName" => $currentName ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <?php
            
            if ($currentSlug == "index") {
                echo('<p><table class="message_info"><tbody><tr><td><img src="/resources/image/message_info.svg" class="message_img"></td><td style="width:100%;"><p>Il s\'agit d\'une page fournie avec Minteck Projects CMS, et de la page d\'accueil de votre site. Pour des raisons de logique, vous ne pouvez pas la renommer ni la supprimer.</p><p>Si vous souhaitez la masquer du menu, ajouter <code>"index"</code> à la liste <code>PagesMasquées</code> dans les paramètres avancés de votre site.</p></td></tr></tbody></table></p>');
            }
            
            ?>
        Actions disponibles pour cette page :
        <ul>
            <li><a class="sblink" href="/cms-special/admin/pages/edit/?slug=<?= $currentSlug ?>" title="Modifier le contenu de la page sélectionnée">Modifier <?php if ($currentSlug == "index") {echo("en utilisant l'éditeur visuel");} ?></a></li>
            <?php
            
            if ($currentSlug != "index") {
                echo('<li><a class="sblink" href="/cms-special/admin/pages/rename/?slug=' . $currentSlug . '" title="Renommer et modifier l\'URL de cette page">Renommer</a></li>');
                echo('<li><a class="sblink" href="/cms-special/admin/pages/delete/?slug=' . $currentSlug . '" title="Supprimer définitivement la page sélectionnée">Supprimer</a></li>');
            } else {
                echo('<li><a class="sblink" href="/cms-special/admin/pages/edit/?slug=' . $currentSlug . '&forcehtml" title="Modifier le contenu de la page sélectionnée">Modifier en utilisant l\'éditeur HTML</a></li>');
            }
            
            ?>
        </ul>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>