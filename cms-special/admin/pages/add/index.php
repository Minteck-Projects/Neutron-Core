<?php $pageConfig = [ "domName" => "Nouvelle page - Pages", "headerName" => "Nouvelle page" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
            <p>
                <form name="settings">
                    <div style="text-align: center;"><input id="name" type="text" placeholder="<?= $lang["admin-pages"]["pagename"] ?>"></div><br>
                    <input type="radio" id="type-visual" value="visual" onchange="switchEditor()" name="type" checked>
                    <label for="type-visual"><?= $lang["admin-pages"]["classic2"] ?></label><br>
                    <input type="radio" id="type" onchange="switchEditor()" value="html" name="type">
                    <label for="type-html"><?= $lang["admin-pages"]["html2"][0] ?> <i><?= $lang["admin-pages"]["html2"][1] ?></i></label>
                </form>
            </p>
            <div id="editing"><?= $lang["admin-pages"]["content"] ?><div id="editor-visual">
                <?php
                require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/VisualEditor$2.php";
                ?></div>
                <div id="editor-html" class="hide">
                    <p><table class="message_warning"><tbody><tr><td><img src="/resources/image/message_warning.svg" class="message_img"></td><td style="width:100%;"><p><?= $lang["admin-pages"]["htmlw"][0] ?></p><p><?= $lang["admin-pages"]["htmlw"][1] ?></p></td></tr></tbody></table></p>
                    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/CodeEditor$2.php" ?>
                </div>
            </div>
    <div class="hide" id="loader" style="text-align: center;"><img src="/resources/image/loader.svg" class="loader"></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>
    window.onbeforeunload = function (e) {
    e = e || window.event;

    // For IE and Firefox prior to version 4
    if (e) {
        e.returnValue = "<?= $lang["admin-pages"]["quitwarn"] ?>";
    }

        // For Safari
        return "<?= $lang["admin-pages"]["quitwarn"] ?>";
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
                alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data)
                Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
                document.getElementById('loader').classList.add('hide')
                document.getElementById('editing').classList.remove('hide')
            }
        },
        error: function (error) {
            alert("<?= $lang["admin-errors"]["connerror"] ?>")
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
                alert("<?= $lang["admin-pages"]["saved"] ?>");
                Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
                document.getElementById('loader').classList.add('hide')
                document.getElementById('editing').classList.remove('hide')
            } else {
                alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data)
                Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
                document.getElementById('loader').classList.add('hide')
                document.getElementById('editing').classList.remove('hide')
            }
        },
        error: function (error) {
            alert("<?= $lang["admin-errors"]["connerror"] ?>")
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