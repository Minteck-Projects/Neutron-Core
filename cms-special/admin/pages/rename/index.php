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
<?php $pageConfig = [ "domName" => "Renommage de " . $currentName . " - Pages", "headerName" => "Renommage de " . $currentName ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <div id="confirm">
            <p>Vous allez renommer la page "<?= $currentName ?>". Tout lien pointant vers l'ancien nom de cette page reverra une page d'erreur...</p>
            <?php

            if ($currentSlug == "index") {
                die("<i>Vous ne pouvez pas renommer la page d'accueil de votre site</i></div></body></html>");
            }

            ?>
                <!-- <li>Ancien nom : <input id="oldname" placeholder="Erreur" value="<?= $currentName ?>" disabled></li>
                <li>Nouveau nom : <input id="newname" placeholder="Erreur" value="<?= $currentName ?>"></li> -->
            <table>
                <tbody>
                    <tr>
                        <td>Ancien nom : </td>
                        <td><input id="oldname" type="text" placeholder="Erreur" value="<?= $currentName ?>" disabled></td>
                    </tr>
                    <tr>
                        <td>Nouveau nom : </td>
                        <td><input id="newname" type="text" placeholder="Erreur" value="<?= $currentName ?>"></td>
                    </tr>
                </tbody>
            </table>
            <p><center><a class="button" onclick="renamePage()" title="Renommer la page">Renommer</a></center></p>
        </div>
        <div class="hide" id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function renamePage() {
    document.getElementById('confirm').classList.add('hide')
    document.getElementById('loader').classList.remove('hide')
    var formData = new FormData();
    formData.append("page", "<?= $currentSlug ?>");
    formData.append("newname", document.getElementById('newname').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/rename_page.php",
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