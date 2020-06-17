<?php $pageConfig = [ "domName" => "Nouvelle page - Pages", "headerName" => "Nouvelle page" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
            <p>
                <form name="settings">
                    <center><input id="name" type="text" placeholder="Nom de la page"></center><br>
                    <input type="radio" id="type-visual" value="visual" onchange="switchEditor()" name="type" checked>
                    <label for="type-visual">Classique</label><br>
                    <input type="radio" id="type" onchange="switchEditor()" value="html" name="type">
                    <label for="type-html">HTML <i>(avancé)</i></label>
                </form>
            </p>
            <div id="editing">Ajouter du contenu à votre page :<div id="editor-visual">
                <?php
                require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/VisualEditor$2.php";
                ?></div>
                <div id="editor-html" class="hide">
                    <p><table class="message_warning"><tbody><tr><td><img src="/resources/image/message_warning.svg" class="message_img"></td><td style="width:100%;"><p>L'éditeur HTML est réservé à des utilisateurs expérimentés souhaitant plus de libérté de personnalisation</p><p>Pour l'utiliser correctement, vous devez avoir des compétences en développement Web. Sinon, nous vous conseillons plutôt d'utiliser l'éditeur visuel</p></td></tr></tbody></table></p>
                    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/CodeEditor$2.php" ?>
                </div>
            </div>
    <div class="hide" id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

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

function createPageVisual() {
    Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = true})
    document.getElementById('loader').classList.remove('hide')
    document.getElementById('editing').classList.add('hide')
    var formData = new FormData();
    formData.append("title", document.getElementById('name').value);
    formData.append("type", "0");
    formData.append("content", editor.getData());
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/create_page.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/pages";
            } else {
                alert("Erreur : " + data)
                Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
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

function createPageVisualNoBack() {
    Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = true})
    document.getElementById('loader').classList.remove('hide')
    document.getElementById('editing').classList.add('hide')
    var formData = new FormData();
    formData.append("title", document.getElementById('name').value);
    formData.append("type", "0");
    formData.append("content", editor.getData());
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/create_page.php",
        success: function (data) {
            if (data == "ok") {
                alert("La page a bien été sauvegardée");
                Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
                document.getElementById('loader').classList.add('hide')
                document.getElementById('editing').classList.remove('hide')
            } else {
                alert("Erreur : " + data)
                Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
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

function createPageHTML() {
    Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = true})
    document.getElementById('loader').classList.remove('hide')
    document.getElementById('editing').classList.add('hide')
    var formData = new FormData();
    formData.append("title", document.getElementById('name').value);
    formData.append("type", "1");
    formData.append("content", ace.edit("editor").getValue());
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/create_page.php",
        success: function (data) {
            if (data == "ok") {
                window.onbeforeunload = undefined;
                location.href = "/cms-special/admin/pages";
            } else {
                alert("Erreur : " + data)
                Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
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

function createPageHTMLNoBack() {
    Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = true})
    document.getElementById('loader').classList.remove('hide')
    document.getElementById('editing').classList.add('hide')
    var formData = new FormData();
    formData.append("title", document.getElementById('name').value);
    formData.append("type", "1");
    formData.append("content", ace.edit("editor").getValue());
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/create_page.php",
        success: function (data) {
            if (data == "ok") {
                alert("La page a bien été sauvegardée");
                Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
                document.getElementById('loader').classList.add('hide')
                document.getElementById('editing').classList.remove('hide')
            } else {
                alert("Erreur : " + data)
                Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
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

function switchEditor() {
    if (document.forms['settings'].type.value == "visual") {
        document.getElementById('editor-visual').classList.remove('hide')
        document.getElementById('editor-html').classList.add('hide')
    } else {
        document.getElementById('editor-visual').classList.add('hide')
        document.getElementById('editor-html').classList.remove('hide')
        loadAce()
    }
}

document.forms['settings'].type.value = "visual"

</script>