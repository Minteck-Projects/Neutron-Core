<?php $loadEditor = false;$pageConfig = [ "domName" => "Apparence", "headerName" => "Apparence" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <span id="appearance-error-box" class="hide"><div id="error"><span id="appearance-error"><?= $lang["admin-appearance"]["error"] ?></span></div></span>
        <div id="appearance-settings" style="text-align: center;">
            <?= $lang["admin-appearance"]["site"] ?> <input onchange="validateName()" onkeyup="validateName()" onkeydown="validateName()" type="text" id="name-field" placeholder="Nom du site" value="<?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename") ?>"><br>
            <p id="04-name-tip" class="tip-red"><?= $lang["admin-appearance"]["name"][0] ?></p>
            <input type="file" id="icon-file" class="hide">
            <p><img id="icon-img" src="/resources/image/config_file_replace.svg" onclick="Icon_UploadFile()" class="icon_button"><br><small><?= $lang["admin-appearance"]["icon"] ?></small></p>
            <input type="file" id="banner-file" class="hide">
            <p><img id="icon-img" src="/resources/image/config_file_replace.svg" onclick="Banner_UploadFile()" class="icon_button"><br><small><?= $lang["admin-appearance"]["banner"] ?></small></p>
            <p>
                <input type="checkbox" id="oldrenderer" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/oldRenderer")) {echo("checked");$oldr=true;} else {$oldr=false;} ?> onchange="toggleRender();"><label for="oldrenderer"><?= $lang["admin-appearance"]["old"] ?></label>
            </p>
            <p id="<?= $oldr ? "" : "onlyold" ?>" class="oldopts"><small id="oo-disclaimer" <?= $oldr ? "style=\"display:none;\"" : "" ?>><?= $lang["admin-appearance"]["oldopts"] ?></small><br><?= $lang["admin-appearance"]["pages"][0] ?>
                <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagesInMenuBar")) { $pimb = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagesInMenuBar") + 1 - 1; } else { $pimb = 4; } ?>
                <select id="showpages" <?= !$oldr ? "disabled" : "" ?>>
                    <option value="1"<?= $pimb == 1 ? " selected" : "" ?>>1</option>
                    <option value="2"<?= $pimb == 2 ? " selected" : "" ?>>2</option>
                    <option value="3"<?= $pimb == 3 ? " selected" : "" ?>>3</option>
                    <option value="4"<?= $pimb == 4 ? " selected" : "" ?>>4</option>
                    <option value="5"<?= $pimb == 5 ? " selected" : "" ?>>5</option>
                    <option value="6"<?= $pimb == 6 ? " selected" : "" ?>>6</option>
                    <option value="7"<?= $pimb == 7 ? " selected" : "" ?>>7</option>
                    <option value="8"<?= $pimb == 8 ? " selected" : "" ?>>8</option>
                    <option value="9"<?= $pimb == 9 ? " selected" : "" ?>>9</option>
                    <option value="10"<?= $pimb == 10 ? " selected" : "" ?>>10</option>
                </select>
            <?= $lang["admin-appearance"]["pages"][1] ?><br>
            <input type="checkbox" id="alwaysmenu" <?= !$oldr ? "disabled" : "" ?> <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/alwaysmenu")) {echo("checked");} ?>><label for="alwaysmenu"><?= $lang["admin-appearance"]["alwaysmenu"] ?></label></p>
            <br>
            <a onclick="submitData()" class="button"><?= $lang["admin-appearance"]["save"] ?></a>
        </div>
        <div style="text-align: center;"><div id="appearance-loader" class="hide"><img src="/resources/image/loader.svg" class="loader"></div></div>
        <h2><?= $lang["admin-appearance"]["footer"] ?></h2>
        <span id="footer-error-box" class="hide"><div id="error"><span id="footer-error"><?= $lang["admin-appearance"]["error"] ?></span></div></span>
        <div id="footer-settings"><div style="text-align: center;">
        <div style="text-align: center;"><?= $lang["admin-appearance"]["fdesc"] ?></div>
            <div name="content" id="fedit">
                <?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/footer") ?>
            </div><br>
            <a onclick="updateFooter()" class="button"><?= $lang["admin-appearance"]["publish"] ?></a>
            <script src="/resources/js/ckeditor5/ckeditor.js"></script><script src="/resources/js/ckeditor5/translations/<?= $langsel ?>.js"></script>
            <script>
        let editor;
        ClassicEditor
            .create( document.querySelector( '#fedit' ), {
                language: {
                    ui: '<?= $langsel ?>',
                    content: '<?= $langsel ?>'
                },
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'link', '|', 'mediaembed', 'blockquote', 'inserttable', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo'
                ]
            } )
            .then( newEditor => {
                editor = newEditor;
            } )
            .catch( error => {
                console.error( error );
            } );
    </script></div>
    <p><table class="message_info"><tbody><tr><td><img src="/resources/image/message_info.svg" class="message_img"></td><td style="width:100%;"><p><?= $lang["admin-appearance"]["fdisc"][0] ?></p><p><?= $lang["admin-appearance"]["fdisc"][1] ?></p></td></tr></tbody></table></p>
        </div>
        <div style="text-align: center;"><div id="footer-loader" class="hide"><img src="/resources/image/loader.svg" class="loader"></div></div>
        <h2><?= $lang["admin-appearance"]["password"] ?></h2>
        <span id="password-error-box" class="hide"><div id="error"><span id="password-error"><?= $lang["admin-appearance"]["error"] ?></span></div></span>
        <div id="password-settings" style="text-align: center;">
            <p><?= $lang["admin-appearance"]["oldpass"] ?> <input type="password" id="old-password" placeholder="<?= $lang["admin-appearance"]["secure"] ?>"></p>
            <p><?= $lang["admin-appearance"]["newpass"] ?> <input type="password" id="new-password" placeholder="<?= $lang["admin-appearance"]["secure"] ?>"></p>
            <p><?= $lang["admin-appearance"]["passrep"] ?> <input type="password" id="repeat-password" placeholder="<?= $lang["admin-appearance"]["secure"] ?>"></p>
            <a onclick="changePassword()" class="button"><?= $lang["admin-appearance"]["change"] ?></a>
        </div>
        <div style="text-align: center;"><div id="password-loader" class="hide"><img src="/resources/image/loader.svg" class="loader"></div></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function validateName() {
    document.getElementById('04-name-tip').classList.remove('tip-orange')
    document.getElementById('04-name-tip').classList.remove('tip-green')
    document.getElementById('04-name-tip').classList.remove('tip-red')
    document.getElementById('04-name-tip').innerHTML = "...";
    setTimeout(() => {
        name = document.getElementById('name-field').value
        if (name.trim() == "") {
            document.getElementById('04-name-tip').classList.add('tip-red')
            document.getElementById('04-name-tip').innerHTML = "<?= $lang["admin-appearance"]["name"][0] ?>";
            return;
        }
        if (name.includes("<") || name.includes(">") || name.includes("#") || name.includes("@") || name.includes("}") || name.includes("{") || name.includes("|")) {
            document.getElementById('04-name-tip').classList.add('tip-red')
            document.getElementById('04-name-tip').innerHTML = "<?= $lang["admin-appearance"]["name"][1] ?>";
            return;
        }
        if (name.length > 75) {
            document.getElementById('04-name-tip').classList.add('tip-red')
            document.getElementById('04-name-tip').innerHTML = "<?= $lang["admin-appearance"]["name"][2] ?>";
            return;
        }
        if (name.length < 4) {
            document.getElementById('04-name-tip').classList.add('tip-orange')
            document.getElementById('04-name-tip').innerHTML = "<?= $lang["admin-appearance"]["name"][3] ?>";
            return;
        }
        if (name.length > 30) {
            document.getElementById('04-name-tip').classList.add('tip-orange')
            document.getElementById('04-name-tip').innerHTML = "<?= $lang["admin-appearance"]["name"][4] ?>";
            return;
        }
        document.getElementById('04-name-tip').classList.add('tip-green')
        document.getElementById('04-name-tip').innerHTML = "<?= $lang["admin-appearance"]["name"][5] ?>";
        return;
    }, 100)
}

function Icon_UploadFile() {
    $("#icon-file").trigger('click');
}

function Banner_UploadFile() {
    $("#banner-file").trigger('click');
}

function toggleRender() {
    if (!document.getElementById('oldrenderer').checked) {
        document.getElementsByClassName('oldopts')[0].id = "onlyold";
        $('#oo-disclaimer').show(200);
        document.getElementById('showpages').disabled = true;
        document.getElementById('alwaysmenu').disabled = true;
    } else {
        document.getElementsByClassName('oldopts')[0].id = "";
        $('#oo-disclaimer').hide(200);
        document.getElementById('showpages').disabled = false;
        document.getElementById('alwaysmenu').disabled = false;
    }
}

function submitData() {
    document.getElementById('appearance-loader').classList.remove('hide')
    document.getElementById('appearance-settings').classList.add('hide')
    var formData = new FormData();
    if (document.getElementById('icon-file').value.trim() != "") {
        formData.append("icon", document.getElementById('icon-file').files[0], document.getElementById('icon-file').files[0].name);
    }
    if (document.getElementById('banner-file').value.trim() != "") {
        formData.append("banner", document.getElementById('banner-file').files[0], document.getElementById('banner-file').files[0].name);
    }
    formData.append("sitename", document.getElementById('name-field').value);
    formData.append("alwaysmenu", document.getElementById('alwaysmenu').checked.toString());
    formData.append("oldrenderer", document.getElementById('oldrenderer').checked.toString());
    formData.append("showpages", document.getElementById('showpages').value);
    document.getElementById('appearance-error-box').classList.add("hide")
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/appearance.php",
        success: function (data) {
            if (data == "ok") {
                reloadPage()
            } else {
                document.getElementById('appearance-error').innerHTML = data
                document.getElementById('appearance-error-box').classList.remove("hide")
                document.getElementById('appearance-loader').classList.add('hide')
                document.getElementById('appearance-settings').classList.remove('hide')
            }
        },
        error: function (error) {
            document.getElementById('password-error').innerHTML = "<?= $lang["admin-errors"]["connerror"] ?>"
            document.getElementById('password-error-box').classList.remove("hide")
            document.getElementById('password-loader').classList.add('hide')
            document.getElementById('password-settings').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function changePassword() {
    document.getElementById('password-loader').classList.remove('hide')
    document.getElementById('password-settings').classList.add('hide')
    var formData = new FormData();
    formData.append("oldpass", document.getElementById('old-password').value);
    formData.append("newpass", document.getElementById('new-password').value);
    formData.append("newpassr", document.getElementById('repeat-password').value);
    document.getElementById('password-error-box').classList.add("hide")
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/password.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin";
            } else {
                document.getElementById('password-error').innerHTML = data
                document.getElementById('password-error-box').classList.remove("hide")
                document.getElementById('password-loader').classList.add('hide')
                document.getElementById('password-settings').classList.remove('hide')
            }
        },
        error: function (error) {
            document.getElementById('password-error').innerHTML = "<?= $lang["admin-errors"]["connerror"] ?>"
            document.getElementById('password-error-box').classList.remove("hide")
            document.getElementById('password-loader').classList.add('hide')
            document.getElementById('password-settings').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function updateFooter() {
    document.getElementById('footer-loader').classList.remove('hide')
    document.getElementById('footer-settings').classList.add('hide')
    var formData = new FormData();
    formData.append("footer", editor.getData());
    document.getElementById('footer-error-box').classList.add("hide")
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/footer.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/appearance";
            } else {
                document.getElementById('footer-error').innerHTML = data
                document.getElementById('footer-error-box').classList.remove("hide")
                document.getElementById('footer-loader').classList.add('hide')
                document.getElementById('footer-settings').classList.remove('hide')
            }
        },
        error: function (error) {
            document.getElementById('footer-error').innerHTML = "<?= $lang["admin-errors"]["connerror"] ?>"
            document.getElementById('footer-error-box').classList.remove("hide")
            document.getElementById('footer-loader').classList.add('hide')
            document.getElementById('footer-settings').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

validateName()

document.getElementById('banner-file').value = ""
document.getElementById('icon-file').value = ""

</script>