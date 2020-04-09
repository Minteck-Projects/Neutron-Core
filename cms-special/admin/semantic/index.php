<?php $pageConfig = [ "domName" => "CMS Sémantique", "headerName" => "CMS Sémantique" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <h3><?= $lang["admin-semantic"]["categories"]->appearance ?></h3>
        <input type="checkbox" name="001" onchange="updateKey('001', 'toc')" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_toc")) {echo("checked");} ?>><label for="001"><?= $lang["admin-semantic"]["toc"] ?></label><br>
        <h3><?= $lang["admin-semantic"]["categories"]->security ?></h3>
        <input type="checkbox" name="003" onchange="updateKey('003', 'antiDdos')" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_antiDdos")) {echo("checked");} ?>><label for="003"><?= $lang["admin-semantic"]["ddos"] ?></label><br>
        <h3><?= $lang["admin-semantic"]["categories"]->opti ?></h3>
        <input type="checkbox" name="006" onchange="updateKey('006', 'resourcesPreload')" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_resourcesPreload")) {echo("checked");} ?>><label for="006"><?= $lang["admin-semantic"]["preload"] ?></label><br>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function updateKey(name, title) {
    checkbox = document.getElementsByName(name)[0]
    if (typeof checkbox == "undefined") {} else {
        Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = true})

        var formData = new FormData();
        formData.append("setting", title);
        formData.append("value", checkbox.checked.toString());
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/semantic_update.php",
            success: function (data) {
                if (data == "ok") {
                    console.log("Saved")
                    setTimeout(() => {
                        Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
                    }, 500)
                } else {
                    alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data);
                }
            },
            error: function (error) {
                alert("<?= $lang["admin-errors"]["connerror"] ?>");
                window.onbeforeunload = undefined;
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });

    }
}

</script>