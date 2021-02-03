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
            <div style="text-align:center;">
                <p><?= $lang["admin-pages"]["deletec"][0] . $currentName . $lang["admin-pages"]["deletec"][1] ?></p>
                <?php

                if ($currentSlug == "index") {
                    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("<i>{$lang["admin-pages"]["deletec"][2]}</i></div></body></html>");
                }

                ?>
                <!--<ul>
                    <li><a onclick="deletePage()" class="sblink" title="<?= $lang["admin-pages"]["deleteyl"] ?>"><?= $lang["admin-pages"]["deletey"] ?></a></li>
                    <li><a onclick="location.href='/cms-special/admin/pages/manage/?slug=<?= $currentSlug ?>'" class="sblink" title="<?= $lang["admin-pages"]["deletenl"] ?>"><?= $lang["admin-pages"]["deleten"] ?></a></li>
                </ul>-->
                <a title="<?= $lang["admin-pages"]["deletenl"] ?>" onclick="location.href='/cms-special/admin/pages';" class="mdc-button mdc-button--raised">
                    <div class="mdc-button__ripple"></div>
                    <span class="mdc-button__label"><?= $lang["admin-pages"]["deleten"] ?></span>
                </a>
                <a title="<?= $lang["admin-pages"]["deleteyl"] ?>" onclick="deletePage();" class="mdc-button mdc-button--outlined">
                    <div class="mdc-button__ripple"></div>
                    <span class="mdc-button__label"><?= $lang["admin-pages"]["deletey"] ?></span>
                </a>
            </div>
        </div>
        <div class="hide" id="loader" style="text-align: center;"><img src="/resources/image/loader.svg" class="loader">
        </div>
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