<?php $pageConfig = [ "domName" => "Personnalisation", "headerName" => "Personnalisation" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <!-- <blockquote>Les modifications apportées ne s'appliqueront qu'après le <a onclick="reloadPage()" class="sblink" title="Recharger la page">rechargement de la page</a>.</blockquote> -->
        <!-- <p><table class="message_info"><tbody><tr><td><img src="/resources/image/message_info.svg" class="message_img"></td><td style="width:100%;"><p><?= $lang["admin-customization"]["disclaimer"][0] ?> <a onclick="reloadPage()" class="sblink" title="Recharger la page"><?= $lang["admin-customization"]["disclaimer"][1] ?></a>.</p><p><?= $lang["admin-customization"]["disclaimer"][2] ?> (<b><a title="Control" class="indication">⌃</a>+<a title="Shift" class="indication">⇧</a>+R</b> <?= $lang["admin-customization"]["disclaimer"][3] ?> <b><a title="Command/Super" class="indication">⌘</a>+<a title="Shift" class="indication">⇧</a>+R</b> <?= $lang["admin-customization"]["disclaimer"][4] ?>)</p></td></tr></tbody></table></p> -->
        <h3><?= $lang["admin-customization"]["icons"] ?></h3>
        <select id="icons" onchange="updateIcons()" disabled>
            <option value="default" <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/suru-enabled")) {echo("selected");} ?>>Minteck Projects CMS</option>
            <option value="suru" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/suru-enabled")) {echo("selected");} ?>>Suru</option>
            <option value="classic" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/classic-enabled")) {echo("selected");} ?>>Classic</option>
        </select> <i class="material-icons" style="vertical-align:middle;">error</i> <?= $lang["admin-customization"]["deprecated"] ?>
        <h3><?= $lang["admin-customization"]["font"] ?></h3>
        <select id="font" onchange="updateFont()">
            <option value="default" <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ubuntufont-enabled") && !file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ubuntulfont-enabled")) {echo("selected");} ?>>Product Sans</option>
            <option value="ubuntu" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ubuntufont-enabled")) {echo("selected");} ?>>Ubuntu</option>
            <option value="ubuntul" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/ubuntulfont-enabled")) {echo("selected");} ?>>Ubuntu Thin</option>
        </select>  <i class="material-icons" style="vertical-align:middle;">info</i> <?= $lang["admin-customization"]["noapply"] ?>
        <h3><?= $lang["admin-customization"]["color"] ?></h3>
        <select id="colors" onchange="updateColors()">
            <option value="default" <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/darktheme-enabled")) {echo("selected");} ?>>Heaven</option>
            <option value="dark" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/darktheme-enabled")) {echo("selected");} ?>>Shadows</option>
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
                console.log("Saved")
                setTimeout(() => {
                    document.getElementById('icons').disabled = false;
                    ajaxPageReload();
                }, 500)
            } else {
                alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data);
            }
        },
        error: function (error) {
            alert("<?= $lang["admin-errors"]["connerror"] ?>");
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
                console.log("Saved")
                setTimeout(() => {
                    document.getElementById('colors').disabled = false;
                    ajaxPageReload();
                }, 500)
            } else {
                alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data);
            }
        },
        error: function (error) {
            alert("<?= $lang["admin-errors"]["connerror"] ?>");
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
                console.log("Saved")
                setTimeout(() => {
                    document.getElementById('font').disabled = false;
                    ajaxPageReload();
                }, 500)
            } else {
                alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data);
            }
        },
        error: function (error) {
            alert("<?= $lang["admin-errors"]["connerror"] ?>");
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>