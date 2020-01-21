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
<?php $pageConfig = [ "domName" => "Suppression de " . $currentName . " - Pages", "headerName" => "Suppression de " . $currentName ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <div id="confirm">
            <p>Voulez-vous vraiment supprimer la page "<?= $currentName ?>" ? Cette action est irréversible et tout lien menant vers cette page renverra à une page     d'erreur...</p>
            <?php

            if ($currentSlug == "index") {
                die("<i>Vous ne pouvez pas supprimer la page d'accueil de votre site</i></div></body></html>");
            }

            ?>
            <ul>
                <li><a onclick="deletePage()" class="sblink" title="Supprimer la page sélectionnée">Oui</a></li>
                <li><a onclick="location.href='/cms-special/admin/pages/manage/?slug=<?= $currentSlug ?>'" class="sblink" title="Annuler la suppresion de la page sélectionnée">Non</a></li>
            </ul>
        </div>
        <div class="hide" id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function deletePage() {
    document.getElementById('confirm').classList.add('hide')
    document.getElementById('loader').classList.remove('hide')
    var formData = new FormData();
    formData.append("page", "<?= $currentSlug ?>");
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/delete_page.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/pages"
            } else {
                alert("Erreur : " + data);
                document.getElementById('confirm').classList.remove('hide')
                document.getElementById('loader').classList.add('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication");
            document.getElementById('confirm').classList.remove('hide')
            document.getElementById('loader').classList.add('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>