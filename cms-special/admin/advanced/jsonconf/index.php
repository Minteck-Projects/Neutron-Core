<?php $pageConfig = [ "domName" => "Préférences de développement - Options avancées", "headerName" => "Préférences de développement" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
    <p><table class="message_warning"><tbody><tr><td><img src="/resources/image/message_warning.svg" class="message_img"></td><td style="width:100%;"><p><?= $lang["admin-advanced-dev"]["warning"] ?></p><p><?= $lang["admin-advanced-dev"]["remove"][0] ?> <code>/data/webcontent/customSettings.json</code>. <?= $lang["admin-advanced-dev"]["remove"][1] ?></p></td></tr></tbody></table></p>
    <div id="editing">
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/CodeEditor$3.php" ?>
    </div>
    <div class="hide" id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>
    window.onbeforeunload = function (e) {
    e = e || window.event;

    // For IE and Firefox prior to version 4
    if (e) {
        e.returnValue = "En quittant cette page, vous perdrez les modifications non enregistrées sur cette page.";
    }

        // For Safari
        return "En quittant cette page, vous perdrez les modifications non enregistrées sur cette page.";
    };
</script>

<script>

function pushSettings() {
    Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = true})
    document.getElementById('loader').classList.remove('hide')
    document.getElementById('editing').classList.add('hide')
    var formData = new FormData();
    formData.append("content", ace.edit("editor").getValue());
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/save_advanced.php",
        success: function (data) {
            if (data == "ok") {
                window.onbeforeunload = undefined;
                location.href = "/cms-special/admin/home";
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

</script>