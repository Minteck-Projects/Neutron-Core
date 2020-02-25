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
    echo("<script>page = \"index\"</script>");
} else {
    $currentName = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $currentSlug . "/pagename");
    echo("<script>page = \"{$currentSlug}\"</script>");
}

?>
<?php $pageConfig = [ "domName" => "Modification de " . $currentName . " - Pages", "headerName" => "Modification de " . $currentName ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
            <div id="editing">Modifier le contenu de cette page :
                <?php

                $type = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagetypes/" . $currentSlug);
                if (isset($_GET['forcehtml'])) {
                    $type = "1";
                }
                if ($type == "0") {
                    require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/VisualEditor.php";
                }
                if ($type == "1") {
                    echo('<p><table class="message_warning"><tbody><tr><td><img src="/resources/image/message_warning.svg" class="message_img"></td><td style="width:100%;"><p>L\'éditeur HTML est réservé à des utilisateurs expérimentés souhaitant plus de libérté de personnalisation</p><p>Pour l\'utiliser correctement, vous devez avoir des compétences en développement Web. Sinon, nous vous conseillons plutôt d\'utiliser l\'éditeur visuel</p></td></tr></tbody></table></p>');
                    require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/CodeEditor.php";
                }

                ?>
            </div>
    <div class="hide" id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>
    window.onbeforeunload = function (e) {
    e = e || window.event;

    // For IE and Firefox prior to version 4
    if (e) {
        e.returnValue = "En quittant cette page, vous perdrez les modifications non enregistrées sur cette page.";
    }

        // For Safari
        return "En quittant cette page, vous perdrez les modifications non enregistrées sur cette page.";
    };
</script>

<script>

function updatePage() {
    document.getElementById('loader').classList.remove('hide')
    document.getElementById('editing').classList.add('hide')
    var formData = new FormData();
    formData.append("title", "<?= $currentSlug ?>");
    formData.append("content", editor.getData());
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/edit_page.php",
        success: function (data) {
            if (data == "ok") {
                window.onbeforeunload = undefined;
                location.href = "/cms-special/admin/pages";
            } else {
                alert("Erreur : " + data)
                document.getElementById('loader').classList.add('hide')
                document.getElementById('editing').classList.remove('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication")
            document.getElementById('loader').classList.add('hide')
            document.getElementById('editing').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function updatePageNoBack() {
    document.getElementById('loader').classList.remove('hide')
    document.getElementById('editing').classList.add('hide')
    var formData = new FormData();
    formData.append("title", "<?= $currentSlug ?>");
    formData.append("content", editor.getData());
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/edit_page.php",
        success: function (data) {
            if (data == "ok") {
                alert("La page a bien été sauvegardée");
                document.getElementById('loader').classList.add('hide')
                document.getElementById('editing').classList.remove('hide')
            } else {
                alert("Erreur : " + data)
                document.getElementById('loader').classList.add('hide')
                document.getElementById('editing').classList.remove('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication")
            document.getElementById('loader').classList.add('hide')
            document.getElementById('editing').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function updatePageHTMLNoBack() {
    document.getElementById('loader').classList.remove('hide')
    document.getElementById('editing').classList.add('hide')
    var formData = new FormData();
    formData.append("title", "<?= $currentSlug ?>");
    formData.append("content", ace.edit("editor").getValue());
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/edit_page.php",
        success: function (data) {
            if (data == "ok") {
                alert("La page a bien été sauvegardée");
                document.getElementById('loader').classList.add('hide')
                document.getElementById('editing').classList.remove('hide')
            } else {
                alert("Erreur : " + data)
                document.getElementById('loader').classList.add('hide')
                document.getElementById('editing').classList.remove('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication")
            document.getElementById('loader').classList.add('hide')
            document.getElementById('editing').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function updatePageHTML() {
    document.getElementById('loader').classList.remove('hide')
    document.getElementById('editing').classList.add('hide')
    var formData = new FormData();
    formData.append("title", "<?= $currentSlug ?>");
    formData.append("content", ace.edit("editor").getValue());
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/edit_page.php",
        success: function (data) {
            if (data == "ok") {
                window.onbeforeunload = undefined;
                location.href = "/cms-special/admin/pages";
            } else {
                alert("Erreur : " + data)
                document.getElementById('loader').classList.add('hide')
                document.getElementById('editing').classList.remove('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication")
            document.getElementById('loader').classList.add('hide')
            document.getElementById('editing').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>