<?php

$invalid = false;

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {

    } else {
        die("<script>location.href = '/cms-special/admin'</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin'</script>");
}

if (isset($_POST['password'])) {
    if (password_verify($_POST['password'], file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/password"))) {
        die("<script>location.href = '/cms-special/admin/home';</script>");
        return;
    } else {
        $invalid = true;
    }
}

?>

<?php echo("<!--\n\n" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/license") . "\n\n-->") ?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    $ready = true;
} else {
    $ready = false;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/resources/css/admin.css">
    <link rel="stylesheet" href="/resources/css/fonts-import.css">
    <link rel="stylesheet" href="/resources/css/ui.css">
    <title><?php
    
    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery")) {
        mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery");
        mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories");
        mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures");
    }

    if ($ready) {
        echo("Administration du site - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
    } else {
        echo("Administration du site - MPCMS");
    }

    ?></title>
    <?php
        if (!$ready) {
            die("<script>location.href = '/cms-special/setup';</script></head>");
        }
    ?>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/header.php"; ?>
</head>
<body>
    <div id="settings">
        <h1><center>Administration du site</center></h1><center><a class="sblink" href="/cms-special/admin/logout" title="Terminer la session de manière sécurisée et retourner à l'écran de connexion">Terminer la session</a></center>
        <p class="place-bar"><small><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/galery" class="sblink">Galerie de photos</a> &gt; <a href="/cms-special/admin/galery/publish" class="sblink">Ajouter une photo</a></small></p>
        <h2>Ajouter une nouvelle photo</h2>
        <div id="hidding">
            <p>Catégorie : <select id="category">
                <option value="unclassed" selected>Non classé</option>
                <?php
                
                $categories = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories");
                foreach ($categories as $category) {
                    if (trim($category) != "" && $category != "." && $category != "..") {
                        $catname = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories/" . $category);
                        echo("<option value=\"" . $category . "\">" . $catname . "</option>");
                    }
                }
                
                ?>
            </select></p>
            <p>Fichier de la photo : <input type="file" id="file"> <i>Taille maximale : <?= ini_get("upload_max_filesize") ?></i></p>
            <p><center><a class="button" onclick="createCat()">Publier la photo</a></center></p>
        </div>
    </div>
</body>
</html>

<script>

function createCat() {
    document.getElementById('hidding').classList.add('hide')
    var formData = new FormData();
    if (document.getElementById('file').value.trim() != "") {
        formData.append("file", document.getElementById('file').files[0], document.getElementById('file').files[0].name);
    }
    formData.append("category", document.getElementById('category').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/galery_publish_photo.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/galery";
            } else {
                alert("Erreur : " + data)
                document.getElementById('hidding').classList.remove('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication")
            document.getElementById('hidding').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

document.getElementById('file').value = "";

</script>