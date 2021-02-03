<?php

if (isset($_GET['slug'])) {
    $currentSlug = $_GET['slug'];
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $currentSlug)) {} else {
        header("Location: /cms-special/admin/pages");
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit();
    }
} else {
    header("Location: /cms-special/admin/pages");
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit();
}

?>
<?php $pageConfig = [ "domName" => "Pages", "headerName" => "Pages" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
<?php

if ($currentSlug == "index") {
    $currentName = "{$lang["admin-pages"]["home"]}";
    echo("<script>page = \"index\"</script>");
} else {
    $currentName = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $currentSlug . "/pagename");
    echo("<script>page = \"{$currentSlug}\"</script>");
}

?>
        <div id="confirm">
            <p><?= $lang["admin-pages"]["renamew"][0] . $currentName . $lang["admin-pages"]["renamew"][1] ?></p>
            <?php

            if ($currentSlug == "index") {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("<i>{$lang["admin-pages"]["renamew"][2]}</i></div></body></html>");
            }

            ?>
            <div class="nd_Field nd_Field_input nd_Field__centered nd_Field__disabled" id="onamebox">
                <input id="oldname" name="oldname" type="text" placeholder="<?= $lang["admin-pages"]["oname"] ?>" spellcheck="false" disabled autocomplete="off" value="<?= $currentName ?>">
                <label for="name"><?= $lang["admin-pages"]["oname"] ?></label>
            </div><div class="nd_Field nd_Field_input nd_Field__centered" id="nnamebox">
                <input id="newname" name="newname" type="text" placeholder="<?= $lang["admin-pages"]["nname"] ?>" spellcheck="false" autocomplete="off" value="<?= $currentName ?>">
                <label for="name"><?= $lang["admin-pages"]["nname"] ?></label>
            </div>
            <p><div style="text-align: center;">
                <a title="<?= $lang["admin-pages"]["renamel2"] ?>" onclick="renamePage();" class="mdc-button mdc-button--raised">
                    <div class="mdc-button__ripple"></div>
                    <i class="material-icons-outlined mdc-button__icon" aria-hidden="true">edit</i>
                    <span class="mdc-button__label"><?= $lang["admin-pages"]["rename2"] ?></span>
                </a>
            </div></p>
        </div>
        <div class="hide" id="loader" style="text-align: center;"><img src="/resources/image/loader.svg" class="loader">
        </div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function renamePage() {
    document.getElementById('confirm').classList.add('hide')
    document.getElementById('loader').classList.remove('hide')
    var formData = new FormData();
    formData.append("page", "<?= $currentSlug ?>");
    formData.append("newname", document.getElementById('newname').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/rename_page.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/pages";
            } else {
                alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data)
                document.getElementById('loader').classList.add('hide')
                document.getElementById('confirm').classList.remove('hide')
            }
        },
        error: function (error) {
            alert("<?= $lang["admin-errors"]["connerror"] ?>")
            document.getElementById('loader').classList.add('hide')
            document.getElementById('confirm').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>