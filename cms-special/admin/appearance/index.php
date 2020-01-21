<?php $loadEditor = false;$pageConfig = [ "domName" => "Apparence", "headerName" => "Apparence" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <span id="appearance-error-box" class="hide"><div id="error"><span id="appearance-error">Erreur inconnue</span></div></span>
        <div id="appearance-settings"><center>
            Nom du site : <input onchange="validateName()" onkeyup="validateName()" onkeydown="validateName()" type="text" id="name-field" placeholder="Nom du site" value="<?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename") ?>"><br><p id="04-name-tip" class="tip-red">Le nom ne peut pas être vide</p>
            <input type="file" id="icon-file" class="hide">
            <p><img id="icon-img" src="/resources/image/config_file_replace.svg" onclick="Icon_UploadFile()" class="icon_button"><br><small>Modifier l'îcone</small></p>
            <input type="file" id="banner-file" class="hide">
            <p><img id="icon-img" src="/resources/image/config_file_replace.svg" onclick="Banner_UploadFile()" class="icon_button"><br><small>Modifier la bannière</small></p>
            <p><input type="checkbox" id="alwaysmenu" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/alwaysmenu")) {echo("checked");} ?>><label for="alwaysmenu">Afficher le lanceur même sur l'interface de bureau</label></p><br>
            <a onclick="submitData()" class="button">Sauvegarder</a>
        </center></div>
        <center><div id="appearance-loader" class="hide"><img src="/resources/image/loader.svg" class="loader"></div></center>
        <h2>Modifier le pied de page</h2>
        <span id="footer-error-box" class="hide"><div id="error"><span id="footer-error">Erreur inconnue</span></div></span>
        <div id="footer-settings"><center>
        <center>Ce pied de page s'affiche sur toutes les pages de votre site</center>
            <div name="content" id="fedit">
                <?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/footer") ?>
            </div><br>
            <a onclick="updateFooter()" class="button">Publier</a>
            <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/balloon/ckeditor.js"></script><script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/balloon/translations/fr.js"></script>
            <script>
        let editor;
        BalloonEditor
            .create( document.querySelector( '#fedit' ), {
                language: {
                    ui: 'fr',
                    content: 'fr'
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
    </script></center>
    <p><table class="message_info"><tbody><tr><td><img src="/resources/image/message_info.svg" class="message_img"></td><td style="width:100%;"><p>Ce que vous voyez n'est pas forcément à ce que vous aurez.</p><p>Le pied de page peut apparaître différement sur votre site final, selon votre configuration et votre navigateur. Le formattage de base apparaîtra tout de même exactement comme ci-dessus sur votre site.</p></td></tr></tbody></table></p>
        </div>
        <center><div id="footer-loader" class="hide"><img src="/resources/image/loader.svg" class="loader"></div></center>
        <h2>Modifier le mot de passe</h2>
        <span id="password-error-box" class="hide"><div id="error"><span id="password-error">Erreur inconnue</span></div></span>
        <div id="password-settings"><center>
            <p>Ancien mot de passe : <input type="password" id="old-password" placeholder="Ancien mot de passe"></p>
            <p>Nouveau mot de passe : <input type="password" id="new-password" placeholder="Nouveau mot de passe"></p>
            <p>Répétez le mot de passe : <input type="password" id="repeat-password" placeholder="Répétez le mot de passe"></p>
            <a onclick="changePassword()" class="button">Changer le mot de passe</a>
        </center></div>
        <center><div id="password-loader" class="hide"><img src="/resources/image/loader.svg" class="loader"></div></center>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

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
            document.getElementById('04-name-tip').innerHTML = "Le nom ne peut pas être vide";
            return;
        }
        if (name.includes("<") || name.includes(">") || name.includes("#") || name.includes("@") || name.includes("}") || name.includes("{") || name.includes("|")) {
            document.getElementById('04-name-tip').classList.add('tip-red')
            document.getElementById('04-name-tip').innerHTML = "Le nom contient des charactères invalides";
            return;
        }
        if (name.length > 75) {
            document.getElementById('04-name-tip').classList.add('tip-red')
            document.getElementById('04-name-tip').innerHTML = "Le nom est trop long";
            return;
        }
        if (name.length < 4) {
            document.getElementById('04-name-tip').classList.add('tip-orange')
            document.getElementById('04-name-tip').innerHTML = "Nom plus long recommandé";
            return;
        }
        if (name.length > 30) {
            document.getElementById('04-name-tip').classList.add('tip-orange')
            document.getElementById('04-name-tip').innerHTML = "Nom plus court recommandé";
            return;
        }
        document.getElementById('04-name-tip').classList.add('tip-green')
        document.getElementById('04-name-tip').innerHTML = "Ce nom semble parfait";
        return;
    }, 100)
}

function Icon_UploadFile() {
    $("#icon-file").trigger('click');
}

function Banner_UploadFile() {
    $("#banner-file").trigger('click');
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
    document.getElementById('appearance-error-box').classList.add("hide")
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/appearance.php",
        success: function (data) {
            if (data == "ok") {
                location.reload()
            } else {
                document.getElementById('appearance-error').innerHTML = data
                document.getElementById('appearance-error-box').classList.remove("hide")
                document.getElementById('appearance-loader').classList.add('hide')
                document.getElementById('appearance-settings').classList.remove('hide')
            }
        },
        error: function (error) {
            document.getElementById('password-error').innerHTML = "Erreur de communication"
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
            document.getElementById('password-error').innerHTML = "Erreur de communication"
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
            document.getElementById('footer-error').innerHTML = "Erreur de communication"
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