<?php $pageConfig = [ "domName" => "Personnalisation", "headerName" => "Personnalisation" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <!-- <blockquote>Les modifications apportées ne s'appliqueront qu'après le <a onclick="location.reload()" class="sblink" title="Recharger la page">rechargement de la page</a>.</blockquote> -->
        <p><table class="message_info"><tbody><tr><td><img src="/resources/image/message_info.svg" class="message_img"></td><td style="width:100%;"><p>Les modifications apportées ne s'appliqueront qu'après le <a onclick="location.reload()" class="sblink" title="Recharger la page">rechargement de la page</a>.</p><p>Si les changements ne s'appliquent pas, essayez de purger le cache (<b><a title="Contrôle" class="indication">⌃</a>+<a title="Majuscule" class="indication">⇧</a>+R</b> sur Windows ou Linux, ou <b><a title="Commande, Super" class="indication">⌘</a>+<a title="Majuscule" class="indication">⇧</a>+R</b> sur Mac)</p></td></tr></tbody></table></p>
        <h3>Pack d'îcones</h3>
        <select id="icons" onchange="updateIcons()">
            <option value="default" <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/suru-enabled")) {echo("selected");} ?>>Minteck Projects CMS</option>
            <option value="suru" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/suru-enabled")) {echo("selected");} ?>>Suru</option>
            <option value="classic" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/classic-enabled")) {echo("selected");} ?>>Classique</option>
        </select>
        <h3>Police de caractères</h3>
        <select id="font" onchange="updateFont()">
            <option value="default" <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ubuntufont-enabled") && !file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ubuntulfont-enabled")) {echo("selected");} ?>>Google Sans</option>
            <option value="ubuntu" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ubuntufont-enabled")) {echo("selected");} ?>>Ubuntu</option>
            <option value="ubuntul" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ubuntulfont-enabled")) {echo("selected");} ?>>Ubuntu Thin</option>
        </select>
        <h3>Couleurs</h3>
        <select id="colors" onchange="updateColors()">
            <option value="default" <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/darktheme-enabled")) {echo("selected");} ?>>Clair</option>
            <option value="dark" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/darktheme-enabled")) {echo("selected");} ?>>Sombre</option>
        </select>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>
<script>

function updateIcons() {
    document.getElementById('icons').disabled = true;
    var formData = new FormData();
    formData.append("theme", document.getElementById('icons').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/customization_icons.php",
        success: function (data) {
            if (data == "ok") {
                console.log("Sauvegardé avec succès")
                setTimeout(() => {
                    document.getElementById('icons').disabled = false;
                }, 500)
            } else {
                alert("Erreur : " + data);
            }
        },
        error: function (error) {
            alert("Erreur de communication");
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function updateColors() {
    document.getElementById('colors').disabled = true;
    var formData = new FormData();
    formData.append("theme", document.getElementById('colors').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/customization_colors.php",
        success: function (data) {
            if (data == "ok") {
                console.log("Sauvegardé avec succès")
                setTimeout(() => {
                    document.getElementById('colors').disabled = false;
                }, 500)
            } else {
                alert("Erreur : " + data);
            }
        },
        error: function (error) {
            alert("Erreur de communication");
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function updateFont() {
    document.getElementById('font').disabled = true;
    var formData = new FormData();
    formData.append("theme", document.getElementById('font').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/customization_font.php",
        success: function (data) {
            if (data == "ok") {
                console.log("Sauvegardé avec succès")
                setTimeout(() => {
                    document.getElementById('font').disabled = false;
                }, 500)
            } else {
                alert("Erreur : " + data);
            }
        },
        error: function (error) {
            alert("Erreur de communication");
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>