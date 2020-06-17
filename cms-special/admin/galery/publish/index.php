<?php $pageConfig = [ "domName" => "Nouvelle photo - Galerie de photos", "headerName" => "Nouvelle photo" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
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
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

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