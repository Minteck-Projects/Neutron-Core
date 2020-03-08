<?php $pageConfig = [ "domName" => "Extensions", "headerName" => "Extensions" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <p><table class="message_info"><tbody><tr><td><img src="/resources/image/message_info.svg" class="message_img"></td><td style="width:100%;"><p><?= $lang["admin-plugins"]["disclaimer"] ?></p></td></tr></tbody></table></p>
        <?php

        $widgets = scandir($_SERVER['DOCUMENT_ROOT'] . "/widgets/");
        $json = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json"));
        foreach ($widgets as $widget) {
            if ($widget != "." && $widget != ".." && $widget != ".htaccess") {
                echo("<div class=\"widget\"><div id=\"header-{$widget}\" class=\"widget-header ");
                if (array_search($widget, $json->list) === false) {
                    echo("disabled");
                } else {
                    echo("enabled");
                }
                echo("\"><table><tbody><tr><td><label class=\"switch\"><input name=\"" . $widget . "\" type=\"checkbox\" onclick=\"updateWidgetStatus('" . $widget . "')\" onchange=\"updateWidgetStatus('" . $widget . "')\"");
                if (array_search($widget, $json->list) === false) {} else {
                    echo(" checked");
                }
                $size = filesize($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/name") + filesize($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/description") + filesize($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/author") + filesize($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/source.php");
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/config")) {
                    $size = $size + filesize($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/config");
                }
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/dependancies")) {
                    $deps = explode(':', file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/dependancies"));
                    foreach ($deps as $dep) {
                        $size = $size + filesize($_SERVER['DOCUMENT_ROOT'] . $dep);
                    }
                }
                $sizestr = $size . " " . $lang["sizes"]["bytes"];if ($size > 1024) {if ($size > 1048576) {if ($size > 1073741824) {$sizestr = round($size / 1073741824, 2) . " " . $lang["sizes"]["gib"];} else {$sizestr = round($size / 1048576, 2) . " " . $lang["sizes"]["mib"];}} else {$sizestr = round($size / 1024, 2) . " " . $lang["sizes"]["kib"];}} else {$sizestr = $size . " " . $lang["sizes"]["bytes"];}$sizestr = str_replace(".", ",", $sizestr);
                echo("><span class=\"slider round\"></span></label></td><td class=\"widget-header-info\"><b>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/name") . "</b><br>par <b>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/author") . "</b>");
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/cms-store")) {
                    echo(", " . $lang["admin-plugins"]["builtin"]);
                }
                echo("<i> (" . $sizestr . ")</i>");
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/config")) {
                    echo("<a href=\"" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/config") . "\" title=\"" . $lang["admin-plugins"]["config"] . "\" class=\"configure_ext\"><img src=\"/resources/image/ext-settings.svg\"></a>");
                }
                echo("<a href=\"http://" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/store_public") . "/view/?id=" . $widget . "&idType=old\" target=\"_blank\" title=\"" . $lang["admin-plugins"]["store"] . "\" class=\"store_ext\"><img src=\"/resources/image/ext-store.svg\"></a>");
                echo("<a onclick=\"window.open('/cms-special/admin/store/ext-remove/?id=" . $widget . "');\" title=\"" . $lang["admin-plugins"]["remove"] . "\" class=\"remove_ext\"><img src=\"/resources/image/ext-remove.svg\"></a>");
                echo("</td></tr></tbody></table></div><p>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/description") . "</p>");
                echo("</div>");
            }
        }

        ?>
        <p><center><b><?= $lang["admin-plugins"]["tip"][0] ?></b><?= $lang["admin-plugins"]["tip"][1] ?><b><a class="sblink" target="_blank" href="http://<?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/store_public") ?>">CMS Store</a></b><?= $lang["admin-plugins"]["tip"][2] ?></center></p>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function updateWidgetStatus(widget) {
    checkbox = document.getElementsByName(widget)[0]
    if (typeof checkbox == "undefined") {} else {
        if (checkbox.checked) {
            document.getElementById('header-' + widget).classList.remove('disabled');
            document.getElementById('header-' + widget).classList.add('enabled');
        } else {
            document.getElementById('header-' + widget).classList.remove('enabled');
            document.getElementById('header-' + widget).classList.add('disabled');
        }
        Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = true})

        var formData = new FormData();
        formData.append("element", widget);
        formData.append("value", checkbox.checked.toString());
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/widgets.php",
            success: function (data) {
                if (data == "ok") {
                    alert("<?= $lang["admin-plugins"]["saved"] ?>");
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