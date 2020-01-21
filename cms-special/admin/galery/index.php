<?php $pageConfig = [ "domName" => "Galerie de photos", "headerName" => "Galerie de photos" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
<?php

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery")) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery");
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories");
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures");
}

?>
        <h3>Catégories</h3>
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
                echo("Aucune");
            }

            ?> catégorie<?php if ($count > 1) {echo("s");} ?> - <?php
            
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
                echo("Aucune");
            }

            ?> photo<?php if ($count > 1) {echo("s");} ?></li>
            <li><a class="sblink" href="/cms-special/admin/galery/addcategory">Créer une nouvelle catégorie</a></li>
        </ul>
        <h3>Catégories</h3>
        <i>Pour modifier une catégorie, supprimez-la et recréez la.</i>
        <ul>
            <?php
            
            $dirs = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories");
            foreach ($dirs as $el) {
                if ($el == "." || $el == "..") {} else {
                    echo("<li>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories/" . $el) . ", <a class=\"sblink\" onclick=\"deleteCategory('{$el}')\">Supprimer</a></li>");
                }
            }

            ?>
        </ul>
        <h3>Photos</h3>
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
            echo("<i>Aucune photo n'a été ajoutée à la galerie de photos.</i><p><a class=\"sblink\" href=\"/cms-special/admin/galery/publish\">Publier une nouvelle photo</a></p>");
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
                    echo(", <a onclick=\"labelPicture('$el')\" class=\"sblink\">Étiquetter</a> - <a href=\"" . explode('|', file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $el))[0] . "\" class=\"sblink\" download>Télécharger</a> - <a onclick=\"confirmDelete('$el')\" class=\"sblink\">Supprimer</a></li>");
                }
            }
            echo("<b><a class=\"sblink\" href=\"/cms-special/admin/galery/publish\">Publier une nouvelle photo</a></b>");
        }

        ?>
        </ul>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function confirmDelete(id) {
    if (confirm('Vous allez supprimer cette image et la dépublier du site.\nCette action est irréversible et l\'image ne pourra pas être récupérée...')) {
        $('#settings').fadeOut(200)
        document.title = "Suppression de l'image..."
        var formData = new FormData();
        formData.append("id", id);
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/galery_delete_image.php",
            success: function (data) {
                if (data == "ok") {
                    location.reload()
                } else {
                    alert("Erreur : " + data)
                    location.reload()
                }
            },
            error: function (error) {
                alert("Erreur de communication")
                location.reload()
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
    }
}

function deleteCategory(id) {
    if (confirm('Vous allez supprimer cette catégorie, cette action est irréversible. Toutes les images dans cette catégorie seront déclassées.')) {
        $('#settings').fadeOut(200)
        document.title = "Suppression de la catégorie..."
        var formData = new FormData();
        formData.append("id", id);
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/galery_delete_category.php",
            success: function (data) {
                if (data == "ok") {
                    location.reload()
                } else {
                    alert("Erreur : " + data, true)
                }
            },
            error: function (error) {
                alert("Erreur de communication", true)
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
    }
}

function labelPicture(id) {
    text = prompt("Entrez la nouvelle étiquette pour cette image")
    if (typeof text == "string") {
        $('#settings').fadeOut(200)
        document.title = "Étiquetage de l'image..."
        var formData = new FormData();
        formData.append("id", id);
        formData.append("label", text);
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/galery_label_picture.php",
            success: function (data) {
                if (data == "ok") {
                    location.reload()
                } else {
                    alert("Erreur : " + data, true)
                }
            },
            error: function (error) {
                alert("Erreur de communication", true)
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
                alert("Erreur : " + data)
                document.getElementById('state').disabled = false;
            }
        },
        error: function (error) {
            alert("Erreur de communication")
            document.getElementById('state').disabled = false;
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>