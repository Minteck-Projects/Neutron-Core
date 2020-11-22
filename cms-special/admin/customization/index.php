<?php $pageConfig = [ "domName" => "Personnalisation", "headerName" => "Personnalisation" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
<div class="hidden">
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
</div>

<h3><?= $lang["admin-customization"]["theme"] ?></h3>
<div class="mdc-card mdc-card--outlined <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/theme")) == "auto") {echo("mdc-card--selected");} ?>" onclick="document.getElementById('theme').value = 'auto';updateTheme();" style="width:256px;margin:10px;display:inline-block;">
    <div class="mdc-card__primary-action" tabindex="0" style="padding:0;">
        <div class="mdc-card__media mdc-card__media--16-9" style="background-image: url('/resources/image/demos/theme-auto.jpg');"></div>
        <div class="mdc-card-wrapper__text-section" style="padding-left:5px;padding-right:5px;">
            <h2 style="margin-bottom:5px;" class="mdc-typography mdc-typography--headline6"><?= $lang["admin-customization"]["auto2"] ?></h2>
            <h3 style="margin-top:5px;" class="mdc-typography mdc-typography--subtitle2"><?= $lang["admin-customization"]["descriptions"][0] ?></h3>
        </div>
    </div>
</div>
<div class="mdc-card mdc-card--outlined <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/theme")) == "dark") {echo("mdc-card--selected");} ?>" onclick="document.getElementById('theme').value = 'dark';updateTheme();" style="width:256px;margin:10px;display:inline-block;">
    <div class="mdc-card__primary-action" tabindex="0" style="padding:0;">
        <div class="mdc-card__media mdc-card__media--16-9" style="background-image: url('/resources/image/demos/theme-dark.jpg');"></div>
        <div class="mdc-card-wrapper__text-section" style="padding-left:5px;padding-right:5px;">
            <h2 style="margin-bottom:5px;" class="mdc-typography mdc-typography--headline6"><?= $lang["admin-customization"]["dark"] ?></h2>
            <h3 style="margin-top:5px;" class="mdc-typography mdc-typography--subtitle2"><?= $lang["admin-customization"]["descriptions"][1] ?></h3>
        </div>
    </div>
</div>
<div class="mdc-card mdc-card--outlined <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/theme")) == "light") {echo("mdc-card--selected");} ?>" onclick="document.getElementById('theme').value = 'light';updateTheme();" style="width:256px;margin:10px;display:inline-block;">
    <div class="mdc-card__primary-action" tabindex="0" style="padding:0;">
        <div class="mdc-card__media mdc-card__media--16-9" style="background-image: url('/resources/image/demos/theme-light.jpg');"></div>
        <div class="mdc-card-wrapper__text-section" style="padding-left:5px;padding-right:5px;">
            <h2 style="margin-bottom:5px;" class="mdc-typography mdc-typography--headline6"><?= $lang["admin-customization"]["light"] ?></h2>
            <h3 style="margin-top:5px;" class="mdc-typography mdc-typography--subtitle2"><?= $lang["admin-customization"]["descriptions"][2] ?></h3>
        </div>
    </div>
</div>

<h3><?= $lang["admin-customization"]["color"] ?></h3>
<div class="mdc-card mdc-card--outlined <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/color")) == "blue") {echo("mdc-card--selected");} ?>" onclick="document.getElementById('colors').value = 'blue';updateColors();" style="width:256px;margin:10px;display:inline-block;">
    <div class="mdc-card__primary-action" tabindex="0" style="padding:0;">
        <div class="mdc-card-wrapper__text-section" style="padding-left:5px;padding-right:5px;">
            <table>
                <tbody>
                    <tr>
                        <td><div style="background-image: url('/resources/image/demos/color-blue.jpg');width: 73px;height: 73px;background-size: cover;margin-left: -10px;margin-top: -10px;margin-bottom: -10px;"></div></td>
                        <td><h2 style="margin-bottom:5px;margin-top: 5px;margin-left: 10px;" class="mdc-typography mdc-typography--headline6"><?= $lang["admin-customization"]["colors2"][0] ?></h2></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mdc-card mdc-card--outlined <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/color")) == "green") {echo("mdc-card--selected");} ?>" onclick="document.getElementById('colors').value = 'green';updateColors();" style="width:256px;margin:10px;display:inline-block;">
    <div class="mdc-card__primary-action" tabindex="0" style="padding:0;">
        <div class="mdc-card-wrapper__text-section" style="padding-left:5px;padding-right:5px;">
            <table>
                <tbody>
                    <tr>
                        <td><div style="background-image: url('/resources/image/demos/color-green.jpg');width: 73px;height: 73px;background-size: cover;margin-left: -10px;margin-top: -10px;margin-bottom: -10px;"></div></td>
                        <td><h2 style="margin-bottom:5px;margin-top: 5px;margin-left: 10px;" class="mdc-typography mdc-typography--headline6"><?= $lang["admin-customization"]["colors2"][1] ?></h2></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mdc-card mdc-card--outlined <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/color")) == "red") {echo("mdc-card--selected");} ?>" onclick="document.getElementById('colors').value = 'red';updateColors();" style="width:256px;margin:10px;display:inline-block;">
    <div class="mdc-card__primary-action" tabindex="0" style="padding:0;">
        <div class="mdc-card-wrapper__text-section" style="padding-left:5px;padding-right:5px;">
            <table>
                <tbody>
                <tr>
                    <td><div style="background-image: url('/resources/image/demos/color-red.jpg');width: 73px;height: 73px;background-size: cover;margin-left: -10px;margin-top: -10px;margin-bottom: -10px;"></div></td>
                    <td><h2 style="margin-bottom:5px;margin-top: 5px;margin-left: 10px;" class="mdc-typography mdc-typography--headline6"><?= $lang["admin-customization"]["colors2"][2] ?></h2></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mdc-card mdc-card--outlined <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/color")) == "orange") {echo("mdc-card--selected");} ?>" onclick="document.getElementById('colors').value = 'orange';updateColors();" style="width:256px;margin:10px;display:inline-block;">
    <div class="mdc-card__primary-action" tabindex="0" style="padding:0;">
        <div class="mdc-card-wrapper__text-section" style="padding-left:5px;padding-right:5px;">
            <table>
                <tbody>
                <tr>
                    <td><div style="background-image: url('/resources/image/demos/color-orange.jpg');width: 73px;height: 73px;background-size: cover;margin-left: -10px;margin-top: -10px;margin-bottom: -10px;"></div></td>
                    <td><h2 style="margin-bottom:5px;margin-top: 5px;margin-left: 10px;" class="mdc-typography mdc-typography--headline6"><?= $lang["admin-customization"]["colors2"][3] ?></h2></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mdc-card mdc-card--outlined <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/color")) == "purple") {echo("mdc-card--selected");} ?>" onclick="document.getElementById('colors').value = 'purple';updateColors();" style="width:256px;margin:10px;display:inline-block;">
    <div class="mdc-card__primary-action" tabindex="0" style="padding:0;">
        <div class="mdc-card-wrapper__text-section" style="padding-left:5px;padding-right:5px;">
            <table>
                <tbody>
                <tr>
                    <td><div style="background-image: url('/resources/image/demos/color-purple.jpg');width: 73px;height: 73px;background-size: cover;margin-left: -10px;margin-top: -10px;margin-bottom: -10px;"></div></td>
                    <td><h2 style="margin-bottom:5px;margin-top: 5px;margin-left: 10px;" class="mdc-typography mdc-typography--headline6"><?= $lang["admin-customization"]["colors2"][4] ?></h2></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mdc-card mdc-card--outlined <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/color")) == "brown") {echo("mdc-card--selected");} ?>" onclick="document.getElementById('colors').value = 'brown';updateColors();" style="width:256px;margin:10px;display:inline-block;">
    <div class="mdc-card__primary-action" tabindex="0" style="padding:0;">
        <div class="mdc-card-wrapper__text-section" style="padding-left:5px;padding-right:5px;">
            <table>
                <tbody>
                <tr>
                    <td><div style="background-image: url('/resources/image/demos/color-brown.jpg');width: 73px;height: 73px;background-size: cover;margin-left: -10px;margin-top: -10px;margin-bottom: -10px;"></div></td>
                    <td><h2 style="margin-bottom:5px;margin-top: 5px;margin-left: 10px;" class="mdc-typography mdc-typography--headline6"><?= $lang["admin-customization"]["colors2"][5] ?></h2></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mdc-card mdc-card--outlined <?php if (trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/color")) == "white") {echo("mdc-card--selected");} ?>" onclick="document.getElementById('colors').value = 'white';updateColors();" style="width:256px;margin:10px;display:inline-block;">
    <div class="mdc-card__primary-action" tabindex="0" style="padding:0;">
        <div class="mdc-card-wrapper__text-section" style="padding-left:5px;padding-right:5px;">
            <table>
                <tbody>
                <tr>
                    <td><div style="background-image: url('/resources/image/demos/color-white.jpg');width: 73px;height: 73px;background-size: cover;margin-left: -10px;margin-top: -10px;margin-bottom: -10px;"></div></td>
                    <td><h2 style="margin-bottom:5px;margin-top: 5px;margin-left: 10px;" class="mdc-typography mdc-typography--headline6"><?= $lang["admin-customization"]["colors2"][6] ?></h2></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>
<script>

function updateColors() {
    $('body').fadeOut(200);
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
    $('body').fadeOut(200);
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