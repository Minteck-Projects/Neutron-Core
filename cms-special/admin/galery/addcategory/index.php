<?php $pageConfig = [ "domName" => "Nouvelle catégorie - Galerie de photos", "headerName" => "Nouvelle catégorie" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <div id="hidding">
            <input type="text" id="catname" placeholder="Nom de la catégorie">
            <p><i>Si une catégorie du même nom existe déjà, rien ne se passera</i></p>
            <p><center><a class="button" onclick="createCat()">Créer la catégorie</a></center></p>
        </div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function createCat() {
    document.getElementById('hidding').classList.add('hide')
    var formData = new FormData();
    formData.append("category", document.getElementById('catname').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/galery_create_category.php",
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

</script>