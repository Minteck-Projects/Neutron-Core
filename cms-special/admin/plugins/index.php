<?php

$pageConfig = [ "domName" => "Extensions", "headerName" => "Extensions" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <p><table class="message_info"><tbody><tr><td><img src="/resources/image/message_info.svg" class="message_img"></td><td style="width:100%;"><p><?= $lang["admin-plugins"]["newnotice"] ?></p></td></tr></tbody></table></p>
        <?php

        $widgets = scandir($_SERVER['DOCUMENT_ROOT'] . "/widgets/");
        $json = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json"));
        foreach ($widgets as $widget) {
            if ($widget != "." && $widget != ".." && $widget != ".htaccess") {
                $config = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/feature.json"));
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
                echo("><span class=\"slider round\"></span></label></td><td class=\"widget-header-info\"><b>" . getName($config) . "</b>");
                if (isset($config->config)) {
                    echo("<a href=\"" . $config->config . "\" title=\"" . $lang["admin-plugins"]["config"] . "\" class=\"configure_ext\"><img src=\"/resources/image/ext-settings.svg\"></a>");
                }
                echo("</td></tr></tbody></table></div><p>" . getDescription($config) . "</p>");
                echo("</div>");
            }
        }

        ?>
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