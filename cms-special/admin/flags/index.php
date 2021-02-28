<?php

function fflag($name, $title, $description) {
    echo('<div class="widget"><div id="header-' . $name . '" class="widget-header ');
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/flag_{$name}")) { echo("enabled"); } else { echo("disabled"); }
    echo("\"><table><tbody><tr><td><label class=\"switch\"><input name=\"{$name}\" type=\"checkbox\" onclick=\"updateWidgetStatus('{$name}')\" onchange=\"updateWidgetStatus('{$name}')\"");
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/flag_{$name}")) { echo(" checked"); }
    echo("><span class=\"slider round\"></span></label></td><td class=\"widget-header-info\"><b>{$title}</b></td></tr></tbody></table></div><p>{$description}</p></div>");
}

$pageConfig = [ "domName" => "Drapeaux", "headerName" => "Drapeaux" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <p><table class="message_info"><tbody><tr><td><img src="/resources/image/message_info.svg" class="message_img"></td><td style="width:100%;"><p><?= $lang["admin-flags"]["notice"] ?></p></td></tr></tbody></table></p>

<?php fflag("boundaries", "Show Layout Boundaries", "Shows a thin colored border around different DOM elements.") ?>
<?php fflag("trace", "Trace Rendering Process", "Shows technical info on the bottom of each page. May contain personal/confidential information!") ?>
<?php fflag("redesign", "Admin Panel Redesign", "Enables a new interface for the administration panel. Very work in progress!") ?>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function updateWidgetStatus(widget) {
    checkbox = document.getElementsByName(widget)[0]
    if (typeof checkbox == "undefined") {} else {
        if (checkbox.checked) {
            enabled = true;
            document.getElementById('header-' + widget).classList.remove('disabled');
            document.getElementById('header-' + widget).classList.add('enabled');
        } else {
            enabled = false;
            document.getElementById('header-' + widget).classList.remove('enabled');
            document.getElementById('header-' + widget).classList.add('disabled');
        }
        Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = true})

        var formData = new FormData();
        formData.append("element", widget);
        if (enabled) {
            url = "/api/admin/flag_enable.php";
        } else {
            url = "/api/admin/flag_disable.php";
        }
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: url,
            success: function (data) {
                if (data == "ok") {
                    setTimeout(() => {
                        location.reload();
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