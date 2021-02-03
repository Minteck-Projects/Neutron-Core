<?php $pageConfig = [ "domName" => "Nouvelle page - Pages", "headerName" => "Nouvelle page" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
            <p>
                <form name="settings">
                    <div class="nd_Field nd_Field_input nd_Field__centered" id="namebox">
                            <input id="name" name="name" type="text" placeholder="<?= $lang["admin-pages"]["pagename"] ?>" spellcheck="false" autocomplete="off">
                            <label for="name"><?= $lang["admin-pages"]["pagename"] ?></label>
                        </div><br>
                    <input style="display:none;" type="radio" id="type-visual" value="visual" onchange="switchEditor()" name="type" checked>
                    <input style="display:none;" type="radio" id="type-html" onchange="switchEditor()" value="html" name="type">
                    <div style="text-align: center;"><div id="ptype-visual" class="mdc-card mdc-card--outlined mdc-card--selected" onclick="document.getElementsByName('type')[0].value = 'visual';switchEditor();" style="width:256px;margin:10px;display:inline-block;">
                        <div class="mdc-card__primary-action" tabindex="0" style="padding:0;">
                            <div class="mdc-card-wrapper__text-section" style="padding-left:5px;padding-right:5px;">
                                <h2 style="margin-bottom:5px;" class="mdc-typography mdc-typography--headline6"><?= $lang["admin-pages"]["editors"][0] ?></h2>
                                <h3 style="margin-top:5px;" class="mdc-typography mdc-typography--subtitle2"><?= $lang["admin-pages"]["editordescs"][0] ?></h3>
                            </div>
                        </div>
                    </div>
                    <div id="ptype-html" class="mdc-card mdc-card--outlined" onclick="document.getElementsByName('type')[0].value = 'html';switchEditor();" style="width:256px;margin:10px;display:inline-block;">
                        <div class="mdc-card__primary-action" tabindex="0" style="padding:0;">
                            <div class="mdc-card-wrapper__text-section" style="padding-left:5px;padding-right:5px;">
                                <h2 style="margin-bottom:5px;" class="mdc-typography mdc-typography--headline6"><?= $lang["admin-pages"]["editors"][1] ?></h2>
                                <h3 style="margin-top:5px;" class="mdc-typography mdc-typography--subtitle2"><?= $lang["admin-pages"]["editordescs"][1] ?></h3>
                            </div>
                        </div>
                    </div></div>
                </form>
            </p>
            <div id="editing"><div id="editor-visual">
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

function switchEditor() {
    if (document.forms['settings'].type.value == "visual") {
        document.getElementById('editor-visual').classList.remove('hide')
        document.getElementById('editor-html').classList.add('hide')
        document.getElementById('ptype-html').classList.remove('mdc-card--selected');
        document.getElementById('ptype-visual').classList.add('mdc-card--selected');
    } else {
        document.getElementById('editor-visual').classList.add('hide')
        document.getElementById('editor-html').classList.remove('hide')
        document.getElementById('ptype-visual').classList.remove('mdc-card--selected');
        document.getElementById('ptype-html').classList.add('mdc-card--selected');
        loadAce()
    }
    document.body.focus();
}

document.forms['settings'].type.value = "visual"

</script>