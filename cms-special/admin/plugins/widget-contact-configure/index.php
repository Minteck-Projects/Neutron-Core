<?php $pageConfig = [ "domName" => "Configuration de l'extension - Extensions", "headerName" => "Configuration de l'extension" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <p>Entrez les informations de contact que vous souhaitez fournir à vos visiteurs. Laissez vide les champs que vous ne souhaitez pas afficher</p>
        <div id="data">
        <?php
        
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-contact-data")) {
            $data = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-contact-data");
            $parts = explode('|', $data);
        }

        ?>
            <table>
                <tbody>
                    <tr>
                        <td>Numéro de téléphone : </td>
                        <td><input type="text" id="phone" placeholder="ex: +33 1 23 45 67 89" value="<?php if (isset($parts)) {echo($parts[0]);} ?>"></td>
                    </tr>
                    <tr>
                        <td>Adresse email : </td>
                        <td><input type="text" id="email" placeholder="ex: contact@example.com" value="<?php if (isset($parts)) {echo($parts[1]);} ?>"></td>
                    </tr>
                    <tr>
                        <td>Adresse postale : </td>
                        <td><input type="text" id="address" placeholder="ex: 123 Rue du Test, Paris, France" value="<?php if (isset($parts)) {echo($parts[2]);} ?>"></td>
                    </tr>
                    <tr>
                        <td>Personne à contacter en cas de nécessité : </td>
                        <td><input type="text" id="people" placeholder="ex: John Doe" value="<?php if (isset($parts)) {echo($parts[3]);} ?>"></td>
                    </tr>
                </tbody>
            </table>
            <p><center><a class="button" onclick="saveChanges()" title="Sauvegarder la configuration du widget">Sauvegarder</a></center></p>
        </div>
        <div class="hide" id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function saveChanges() {
    document.getElementById('data').classList.add('hide')
    document.getElementById('loader').classList.remove('hide')
    var formData = new FormData();
    formData.append("phone", document.getElementById('phone').value);
    formData.append("email", document.getElementById('email').value);
    formData.append("address", document.getElementById('address').value);
    formData.append("people", document.getElementById('people').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/widget-contact-configure.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/widgets"
            } else {
                alert("Erreur : " + data);
                document.getElementById('data').classList.remove('hide')
                document.getElementById('loader').classList.add('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication");
            document.getElementById('data').classList.remove('hide')
            document.getElementById('loader').classList.add('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>