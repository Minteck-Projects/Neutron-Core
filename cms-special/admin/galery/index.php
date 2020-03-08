<?php $pageConfig = [ "domName" => "Galerie de photos", "headerName" => "Galerie de photos" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
<?php

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery")) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery");
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories");
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures");
}

?>
        <h3><?= $lang["admin-gallery"]["general"]->title ?></h3>
        <ul>
            <li><?php

            $count = 0;
            $dirs = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories");
            foreach ($dirs as $el) {
                if ($el == "." || $el == "..") {} else {
                    $count = $count + 1;
                }
            }
            if ($count != 0) {
                echo($count);
            } else {
                echo($lang["admin-gallery"]["none"]);
            }

            ?> <?= $lang["admin-gallery"]["lists"]->categories ?><?php if ($count > 1) {echo("s");} ?> - <?php

            $count = 0;
            $dirs = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures");
            foreach ($dirs as $el) {
                if ($el == "." || $el == "..") {} else {
                    $count = $count + 1;
                }
            }
            if ($count != 0) {
                echo($count);
            } else {
                echo($lang["admin-gallery"]["none"]);
            }

            ?> <?= $lang["admin-gallery"]["lists"]->picture ?><?php if ($count > 1) {echo("s");} ?></li>
            <li><a class="sblink" href="/cms-special/admin/galery/addcategory">Créer une nouvelle catégorie</a></li>
        </ul>
        <h3><?= $lang["admin-gallery"]["categories"]->title ?></h3>
        <i><?= $lang["admin-gallery"]["categories"]->edit ?></i>
        <ul>
            <?php

            $dirs = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories");
            foreach ($dirs as $el) {
                if ($el == "." || $el == "..") {} else {
                    echo("<li>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories/" . $el) . ", <a class=\"sblink\" onclick=\"deleteCategory('{$el}')\">" . $lang["admin-gallery"]["categories"]->delete . "</a></li>");
                }
            }

            ?>
        </ul>
        <h3><?= $lang["admin-gallery"]["pictures"]->title ?></h3>
        <ul>
        <?php

        $count = 0;
        $dirs = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures");
        foreach ($dirs as $el) {
            if ($el == "." || $el == "..") {} else {
                $count = $count + 1;
            }
        }
        if ($count == 0) {
            echo("<i>" . $lang["admin-gallery"]["pictures"]->none . "</i><p><a class=\"sblink\" href=\"/cms-special/admin/galery/publish\">" . $lang["admin-gallery"]["pictures"]->add . "</a></p>");
        } else {
            foreach ($dirs as $el) {
                if ($el == "." || $el == "..") {} else {
                    if (isset(explode('|', file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $el))[2])) {
                        echo("<li><i>" . explode('|', file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $el))[2] . "</i>, ");
                    } else {
                        echo("<li><code>" . $el ."</code>, ");
                    }
                    if (explode('|', file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $el))[1] == "unclassed") {
                        echo("Non classé");
                    } else {
                        echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories/" . explode('|', file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $el))[1]));
                    }
                    echo(", <a onclick=\"labelPicture('$el')\" class=\"sblink\">Étiquetter</a> - <a href=\"" . explode('|', file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $el))[0] . "\" class=\"sblink\" download>" . $lang["admin-gallery"]["pictures"]->download . "</a> - <a onclick=\"confirmDelete('$el')\" class=\"sblink\">" . $lang["admin-gallery"]["pictures"]->delete . "</a></li>");
                }
            }
            echo("<b><a class=\"sblink\" href=\"/cms-special/admin/galery/publish\">" . $lang["admin-gallery"]["pictures"]->add . "</a></b>");
        }

        ?>
        </ul>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function confirmDelete(id) {
    if (confirm("<?= $lang["admin-gallery"]["delete"]->title[0] ?>\n<?= $lang["admin-gallery"]["delete"]->title[1] ?>")) {
        $('#settings').fadeOut(200)
        document.title = "<?= $lang["admin-gallery"]["delete"]->removing ?>"
        var formData = new FormData();
        formData.append("id", id);
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/galery_delete_image.php",
            success: function (data) {
                if (data == "ok") {
                    reloadPage()
                } else {
                    alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data)
                    reloadPage()
                }
            },
            error: function (error) {
                alert("<?= $lang["admin-errors"]["connerror"] ?>")
                reloadPage()
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
    }
}

function deleteCategory(id) {
    if (confirm('<?= $lang["admin-gallery"]["delete"]->category ?>')) {
        $('#settings').fadeOut(200)
        document.title = "<?= $lang["admin-gallery"]["delete"]->catrm ?>"
        var formData = new FormData();
        formData.append("id", id);
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/galery_delete_category.php",
            success: function (data) {
                if (data == "ok") {
                    reloadPage()
                } else {
                    alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data, true)
                }
            },
            error: function (error) {
                alert("<?= $lang["admin-errors"]["connerror"] ?>", true)
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
    }
}

function labelPicture(id) {
    text = prompt("<?= $lang["admin-gallery"]["label"] ?>")
    if (typeof text == "string") {
        $('#settings').fadeOut(200)
        document.title = "<?= $lang["admin-gallery"]["labelling"] ?>"
        var formData = new FormData();
        formData.append("id", id);
        formData.append("label", text);
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/galery_label_picture.php",
            success: function (data) {
                if (data == "ok") {
                    reloadPage()
                } else {
                    alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data, true)
                }
            },
            error: function (error) {
                alert("<?= $lang["admin-errors"]["connerror"] ?>", true)
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
    }
}

function changeState() {
    document.getElementById('state').disabled = true;
    var formData = new FormData();
    if (document.getElementById('state').checked) {
        formData.append("state", "1");
    } else {
        formData.append("state", "0");
    }
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/galery_toggle_state.php",
        success: function (data) {
            if (data == "ok") {
                document.getElementById('state').disabled = false;
            } else {
                alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data)
                document.getElementById('state').disabled = false;
            }
        },
        error: function (error) {
            alert("<?= $lang["admin-errors"]["connerror"] ?>")
            document.getElementById('state').disabled = false;
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>
