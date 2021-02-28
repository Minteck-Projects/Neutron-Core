<?php

if (isset($_GET['slug'])) {
    $currentSlug = $_GET['slug'];
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $currentSlug)) {} else {
        header("Location: /cms-special/admin/pages.old");
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit();
    }
} else {
    header("Location: /cms-special/admin/pages.old");
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit();
}

?>
<?php $pageConfig = [ "domName" => "Pages", "headerName" => "Pages" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
<?php

if ($currentSlug == "index") {
    $currentName = "{$lang["admin-pages-old"]["home"]}";
    echo("<script>page = \"index\"</script>");
} else {
    $currentName = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $currentSlug . "/pagename");
    echo("<script>page = \"{$currentSlug}\"</script>");
}

?>
        <div id="confirm">
            <p><?= $lang["admin-pages-old"]["renamew"][0] . $currentName . $lang["admin-pages-old"]["renamew"][1] ?></p>
            <?php

            if ($currentSlug == "index") {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("<i>{$lang["admin-pages-old"]["renamew"][2]}</i></div></body></html>");
            }

            ?>
            <table>
                <tbody>
                    <tr>
                        <td><?= $lang["admin-pages-old"]["oname"] ?> </td>
                        <td><input id="oldname" type="text" placeholder="<?= $lang["admin-pages-old"]["onamep"] ?>" value="<?= $currentName ?>" disabled></td>
                    </tr>
                    <tr>
                        <td><?= $lang["admin-pages-old"]["nname"] ?> </td>
                        <td><input id="newname" type="text" placeholder="<?= $lang["admin-pages-old"]["nnamep"] ?>" value="<?= $currentName ?>"></td>
                    </tr>
                </tbody>
            </table>
            <p><center><a class="button" onclick="renamePage()" title="<?= $lang["admin-pages-old"]["renamel2"] ?>"><?= $lang["admin-pages-old"]["rename2"] ?></a></center></p>
        </div>
        <div class="hide" id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
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
                location.href = "/cms-special/admin/pages.old";
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
