<?php $pageConfig = [ "domName" => "Langue et région", "headerName" => "Langue et région" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
<center><select id="langselect">
    <?php

    $langs = scandir($_SERVER['DOCUMENT_ROOT'] . "/resources/i18n");
    foreach ($langs as $language) {
        if ($language != "." && $language != ".." && $language != ".htaccess") {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/i18n/" . $language . "/\$metadata.json")) {
                echo("<option value=\"" . $language . "\">");
                echo(json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/i18n/" . $language . "/\$metadata.json"))->localized_name . " — " . json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/i18n/" . $language . "/\$metadata.json"))->name);
                echo("</option>");
            }
        }
    }

    ?>
</select>
</p>
<input id="langselect-confirm" type="button" value="OK" onclick="changeLanguage()"></center>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function changeLanguage() {
    document.getElementById('langselect').disabled = true;
    document.getElementById('langselect-confirm').disabled = true;
    var formData = new FormData();
    formData.append("lang", document.getElementById('langselect').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/instant_language_change.php",
        success: function (data) {
            if (data == "ok") {
                document.getElementById('langselect').disabled = false;
                document.getElementById('langselect-confirm').disabled = false;
                ajaxPageReload();
            } else {
                alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data);
                document.getElementById('langselect').disabled = false;
                document.getElementById('langselect-confirm').disabled = false;
            }
        },
        error: function (error) {
            alert("<?= $lang["admin-errors"]["connerror"] ?>\n\n<?= $lang["admin-errors"]["housekeeping"][1] ?>")
            document.getElementById('langselect').disabled = false;
            document.getElementById('langselect-confirm').disabled = false;
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>