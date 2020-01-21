<?php $pageConfig = [ "domName" => "CMS Sémantique", "headerName" => "CMS Sémantique" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <h3>Apparance</h3>
        <input type="checkbox" name="001" onchange="updateKey('001', 'toc')" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_toc")) {echo("checked");} ?>><label for="001">Utiliser une table des matières pour les pages contenant plusieurs titres</label><br>
        <!-- <input type="checkbox" name="002" onchange="updateKey('002', 'betterHome')" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_betterHome")) {echo("checked");} ?>><label for="002">Générer automatiquement une page d'accueil améliorée</label><br> -->
        <h3>Sécurité</h3>
        <input type="checkbox" name="003" onchange="updateKey('003', 'antiDdos')" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_antiDdos")) {echo("checked");} ?>><label for="003">Bloquer les attaques par requêtes massives (DDOS) automatiquement</label><br>
        <h3>Optimisations</h3>
        <input type="checkbox" name="006" onchange="updateKey('006', 'resourcesPreload')" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/semantic_resourcesPreload")) {echo("checked");} ?>><label for="006">Précharger les ressources pour les prochaines visites</label><br>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function updateKey(name, title) {
    checkbox = document.getElementsByName(name)[0]
    if (typeof checkbox == "undefined") {} else {
        Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = true})

        var formData = new FormData();
        formData.append("setting", title);
        formData.append("value", checkbox.checked.toString());
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/semantic_update.php",
            success: function (data) {
                if (data == "ok") {
                    console.log("Sauvegardé avec succès")
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