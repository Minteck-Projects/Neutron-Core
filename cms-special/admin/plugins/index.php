<?php $pageConfig = [ "domName" => "Extensions", "headerName" => "Extensions" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <p><table class="message_info"><tbody><tr><td><img src="/resources/image/message_info.svg" class="message_img"></td><td style="width:100%;"><p>Minteck Projects CMS dispose du support d'extensions, qui vous permettent de modifier les fonctionnalités et/ou le comportement du logiciel, ou d'afficher des widgets supplémentaires dans la barre des widgets (sortes d'informations enrichies qui sont affichés à la suite)</p></td></tr></tbody></table></p>
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
                $sizestr = $size . " octets";if ($size > 1024) {if ($size > 1048576) {if ($size > 1073741824) {$sizestr = round($size / 1073741824, 2) . " Gio";} else {$sizestr = round($size / 1048576, 2) . " Mio";}} else {$sizestr = round($size / 1024, 2) . " Kio";}} else {$sizestr = $size . " octets";}$sizestr = str_replace(".", ",", $sizestr);
                echo("><span class=\"slider round\"></span></label></td><td class=\"widget-header-info\"><b>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/name") . "</b><br>par <b>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/author") . "</b>");
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/cms-store")) {
                    echo(", extension préinstallée");
                }
                echo("<i> (" . $sizestr . ")</i>");
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/config")) {
                    echo("<a href=\"" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/config") . "\" title=\"Modifier les paramètres de cette extension\" class=\"configure_ext\"><img src=\"/resources/image/ext-settings.svg\"></a>");
                }
                echo("<a href=\"" . "/cms-special/admin/store/package/?id=" . $widget . "\" title=\"Voir cette extension sur le CMS Store\" class=\"store_ext\"><img src=\"/resources/image/ext-store.svg\"></a>");
                echo("</td></tr></tbody></table></div><p>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/description") . "</p>");
                echo("</div>");
            }
        }
        
        ?>
        <p><center><b>Conseil :</b> Vous pouvez installer de nouvelles extensions depuis le <b><a class="sblink" href="/cms-special/admin/store">CMS Store</a></b>, une bibliothèque de toutes les extensions pour Minteck Projects CMS</center></p>
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
                    alert("Modifications sauvegardées avec succès");
                    setTimeout(() => {
                        Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
                    }, 500)
                } else {
                    alert("Erreur : " + data);
                }
            },
            error: function (error) {
                alert("Erreur de communication");
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