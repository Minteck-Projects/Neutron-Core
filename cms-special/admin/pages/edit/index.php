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
            <div id="editing">
                <?php

                if ($currentSlug == "index") {
                    $currentName = "{$lang["admin-pages"]["home"]}";
                    echo("<script>page = \"index\"</script>");
                } else {
                    $currentName = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $currentSlug . "/pagename");
                    echo("<script>page = \"{$currentSlug}\"</script>");
                }

                $type = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagetypes/" . $currentSlug);
                if (isset($_GET['forcehtml'])) {
                    $type = "1";
                }
                if ($type == "0") {
                    require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/VisualEditor.php";
                }
                if ($type == "1"):
                
                ?>
                <p><table class="message_warning"><tbody><tr><td><img src="/resources/image/message_warning.svg" class="message_img"></td><td style="width:100%;"><p><?= $lang["admin-pages"]["htmlw"][0] ?></p><p><?= $lang["admin-pages"]["htmlw"][1] ?></p></td></tr></tbody></table></p>
                <?php

                require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/CodeEditor.php";
                endif;

                ?>
            </div>
    <div class="hide" id="loader" style="text-align: center;"><img src="/resources/image/loader.svg" class="loader"></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>
    window.onbeforeunload = function (e) {
    e = e || window.event;

    // For IE and Firefox prior to version 4
    if (e) {
        e.returnValue = "<?= $lang["admin-pages"]["quitwarn"] ?>";
    }

        // For Safari
        return "<?= $lang["admin-pages"]["quitwarn"] ?>";
    };
</script>

<script>

function updatePage() {
    document.getElementById('loader').classList.remove('hide')
    document.getElementById('editing').classList.add('hide')
    var formData = new FormData();
    formData.append("title", "<?= $currentSlug ?>");
    formData.append("content", editor.getData());
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/edit_page.php",
        success: function (data) {
            if (data == "ok") {
                window.onbeforeunload = null;
                location.href = "/cms-special/admin/pages";
            } else {
                alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data)
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

function updatePageNoBack() {
    document.getElementById('loader').classList.remove('hide')
    document.getElementById('editing').classList.add('hide')
    var formData = new FormData();
    formData.append("title", "<?= $currentSlug ?>");
    formData.append("content", editor.getData());
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/edit_page.php",
        success: function (data) {
            if (data == "ok") {
                alert("<?= $lang["admin-pages"]["saved"] ?>");
                document.getElementById('loader').classList.add('hide')
                document.getElementById('editing').classList.remove('hide')
            } else {
                alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data)
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

function updatePageHTMLNoBack() {
    document.getElementById('loader').classList.remove('hide')
    document.getElementById('editing').classList.add('hide')
    var formData = new FormData();
    formData.append("title", "<?= $currentSlug ?>");
    formData.append("content", ace.edit("editor").getValue());
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/edit_page.php",
        success: function (data) {
            if (data == "ok") {
                alert("<?= $lang["admin-pages"]["saved"] ?>");
                document.getElementById('loader').classList.add('hide')
                document.getElementById('editing').classList.remove('hide')
            } else {
                alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data)
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

function updatePageHTML() {
    document.getElementById('loader').classList.remove('hide')
    document.getElementById('editing').classList.add('hide')
    var formData = new FormData();
    formData.append("title", "<?= $currentSlug ?>");
    formData.append("content", ace.edit("editor").getValue());
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/edit_page.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/pages";
            } else {
                alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data)
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