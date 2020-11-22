<?php $pageConfig = [ "domName" => "Configuration de l'extension - Extensions", "headerName" => "Configuration de l'extension" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <p><?= $lang["admin-plugins-contact"]["disclaimer"] ?></p>
        <div id="data">
        <?php
        
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-contact-data")) {
            $data = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-contact-data");
            $parts = explode('|', $data);
        }

        ?>
            <table>
                <tbody>
                    <tr>
                        <td><?= $lang["admin-plugins-contact"]["phone"] ?></td>
                        <td><input type="text" id="phone" placeholder="ex: +33 1 23 45 67 89" value="<?php if (isset($parts)) {echo($parts[0]);} ?>"></td>
                    </tr>
                    <tr>
                        <td><?= $lang["admin-plugins-contact"]["email"] ?></td>
                        <td><input type="text" id="email" placeholder="ex: contact@example.com" value="<?php if (isset($parts)) {echo($parts[1]);} ?>"></td>
                    </tr>
                    <tr>
                        <td><?= $lang["admin-plugins-contact"]["address"] ?></td>
                        <td><input type="text" id="address" placeholder="ex: 123 Rue du Test, Paris, France" value="<?php if (isset($parts)) {echo($parts[2]);} ?>"></td>
                    </tr>
                    <tr>
                        <td><?= $lang["admin-plugins-contact"]["people"] ?></td>
                        <td><input type="text" id="people" placeholder="ex: John Doe" value="<?php if (isset($parts)) {echo($parts[3]);} ?>"></td>
                    </tr>
                </tbody>
            </table>
            <p><div style="text-align: center;"><a class="button" onclick="saveChanges()" title="<?= $lang["admin-plugins"]["widgetconf"]->saveph ?>"><?= $lang["admin-plugins"]["widgetconf"]->save ?></a></div></p>
        </div>
        <div class="hide" id="loader" style="text-align: center;"><img src="/resources/image/loader.svg" class="loader">
        </div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function saveChanges() {
    document.getElementById('data').classList.add('hide')
    document.getElementById('loader').classList.remove('hide')
    var formData = new FormData();
    formData.append("phone", document.getElementById('phone').value);
    formData.append("email", document.getElementById('email').value);
    formData.append("address", document.getElementById('address').value);
    formData.append("people", document.getElementById('people').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/widget-contact-configure.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/widgets"
            } else {
                alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data);
                document.getElementById('data').classList.remove('hide')
                document.getElementById('loader').classList.add('hide')
            }
        },
        error: function (error) {
            alert("<?= $lang["admin-errors"]["errorprefix"] ?>");
            document.getElementById('data').classList.remove('hide')
            document.getElementById('loader').classList.add('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>