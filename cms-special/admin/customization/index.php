<?php $pageConfig = [ "domName" => "Personnalisation", "headerName" => "Personnalisation" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <h3><?= $lang["admin-customization"]["theme"] ?></h3>
        <select id="theme" onchange="updateTheme()">
            <option value="auto" <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/theme")) == "auto") {echo("selected");} ?>><?= $lang["admin-customization"]["auto"] ?></option>
            <option value="light" <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/theme")) == "light") {echo("selected");} ?>><?= $lang["admin-customization"]["light"] ?></option>
            <option value="dark" <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/theme")) == "dark") {echo("selected");} ?>><?= $lang["admin-customization"]["dark"] ?></option>
        </select>
        <h3><?= $lang["admin-customization"]["color"] ?></h3>
        <select id="colors" onchange="updateColors()">
            <option value="blue" <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/color")) == "blue") {echo("selected");} ?>><?= $lang["admin-customization"]["colors"][0] ?></option>
            <option value="green" <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/color")) == "green") {echo("selected");} ?>><?= $lang["admin-customization"]["colors"][1] ?></option>
            <option value="red" <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/color")) == "red") {echo("selected");} ?>><?= $lang["admin-customization"]["colors"][2] ?></option>
            <option value="orange" <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/color")) == "orange") {echo("selected");} ?>><?= $lang["admin-customization"]["colors"][3] ?></option>
            <option value="purple" <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/color")) == "purple") {echo("selected");} ?>><?= $lang["admin-customization"]["colors"][4] ?></option>
            <option value="brown" <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/color")) == "brown") {echo("selected");} ?>><?= $lang["admin-customization"]["colors"][5] ?></option>
            <option value="white" <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/color")) == "white") {echo("selected");} ?>><?= $lang["admin-customization"]["colors"][6] ?></option>
        </select>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>
<script>

function updateColors() {
    document.getElementById('colors').disabled = true;
    var formData = new FormData();
    formData.append("color", document.getElementById('colors').value);
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

function updateTheme() {
    document.getElementById('theme').disabled = true;
    var formData = new FormData();
    formData.append("theme", document.getElementById('theme').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/customization_theme.php",
        success: function (data) {
            if (data == "ok") {
                console.log("Saved")
                setTimeout(() => {
                    document.getElementById('theme').disabled = false;
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