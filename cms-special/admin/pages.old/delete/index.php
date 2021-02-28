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
            <p><?= $lang["admin-pages-old"]["deletec"][0] . $currentName . $lang["admin-pages-old"]["deletec"][1] ?></p>
            <?php

            if ($currentSlug == "index") {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("<i>{$lang["admin-pages-old"]["deletec"][2]}</i></div></body></html>");
            }

            ?>
            <ul>
                <li><a onclick="deletePage()" class="sblink" title="<?= $lang["admin-pages-old"]["deleteyl"] ?>"><?= $lang["admin-pages-old"]["deletey"] ?>></a></li>
                <li><a onclick="location.href='/cms-special/admin/pages.old/manage/?slug=<?= $currentSlug ?>'" class="sblink" title="<?= $lang["admin-pages-old"]["deletenl"] ?>"><?= $lang["admin-pages-old"]["deleten"] ?></a></li>
            </ul>
        </div>
        <div class="hide" id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function deletePage() {
    document.getElementById('confirm').classList.add('hide')
    document.getElementById('loader').classList.remove('hide')
    var formData = new FormData();
    formData.append("page", "<?= $currentSlug ?>");
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/delete_page.php",
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
