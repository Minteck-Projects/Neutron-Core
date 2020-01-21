<?php $pageConfig = [ "domName" => "Préférences de développement - Options avancées", "headerName" => "Préférences de développement" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
    <p><table class="message_warning"><tbody><tr><td><img src="/resources/image/message_warning.svg" class="message_img"></td><td style="width:100%;"><p>Modifiez ces paramètres avec les plus grandes précautions, car toute modification erronée peut empêcher votre site de fonctionner.</p><p>Si votre site ne fonctionne plus après une modification, demandez à votre administrateur système de supprimer le fichier <code>/data/webcontent/customSettings.json</code>. Le logiciel se chargera de regénérer un nouveau fichier de paramètres avancés sans erreurs.</p></td></tr></tbody></table></p>
    <div id="editing">
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/CodeEditor$3.php" ?>
    </div>
    <div class="hide" id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
    <p><h3>Description des paramètres</h3></p>
    <p><table style="width:100%;border-collapse: separate;border-spacing: 0px;" cellspacing="0" cellpadding="0"><tbody style="width:100%;">
        <tr>
            <td class="storelist"><center><b>Paramètre</b></center></td>
            <td class="storelist"><center><b>Type de valeur</b></center></td>
            <td class="storelist"><center><b>Valeur initiale</b></center></td>
            <td class="storelist"><center><b>Description</b></center></td>
        </tr>
        <tr>
            <td class="storelist"><center><code>RessourcesPersonnalisées</code></center></td>
            <td class="storelist"><center>Objet (<code>object</code>)</center></td>
            <td class="storelist"><center><code>{"CSS": "","JS": ""}</code></center></td>
            <td class="storelist"><center>Ressources externes importées sur toutes les pages de votre site</center></td>
        </tr>
        <tr>
            <td class="storelist"><center><code>RessourcesPersonnalisées/CSS</code></center></td>
            <td class="storelist"><center>Texte (<code>string</code>)</center></td>
            <td class="storelist"><center><code>""</code></center></td>
            <td class="storelist"><center>Feuille de style globale importée sur toutes les pages de votre site</center></td>
        </tr>
        <tr>
            <td class="storelist"><center><code>RessourcesPersonnalisées/JS</code></center></td>
            <td class="storelist"><center>Texte (<code>string</code>)</center></td>
            <td class="storelist"><center><code>""</code></center></td>
            <td class="storelist"><center>Script JavaScript (compatible ECMAScript) importé sur toutes les pages de votre site</center></td>
        </tr>
        <tr>
            <td class="storelist"><center><code>PagesMasquées</code></center></td>
            <td class="storelist"><center>Liste (<code>array</code>)</center></td>
            <td class="storelist"><center><code>[]</code></center></td>
            <td class="storelist"><center>Liste des identifiants des pages à ne pas afficher dans le menu</center></td>
        </tr>
        <tr>
            <td class="storelist"><center><code>AfficherBoutonAdministration</code></center></td>
            <td class="storelist"><center>Booléenne (<code>boolean</code>)</center></td>
            <td class="storelist"><center><code>true</code></center></td>
            <td class="storelist"><center>Afficher le bouton "Administration du site" en haut à droite de votre site</center></td>
        </tr>
        <tr>
            <td class="storelist"><center><code>AdministrationBarreNavigation</code></center></td>
            <td class="storelist"><center>Booléenne (<code>boolean</code>)</center></td>
            <td class="storelist"><center><code>true</code></center></td>
            <td class="storelist"><center>Afficher la barre de navigation dans l'administration du site</center></td>
        </tr>
    </tbody></table></p><br>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>
    window.onbeforeunload = function (e) {
    e = e || window.event;

    // For IE and Firefox prior to version 4
    if (e) {
        e.returnValue = "En quittant cette page, vous perdrez les modifications non enregistrées sur cette page.";
    }

        // For Safari
        return "En quittant cette page, vous perdrez les modifications non enregistrées sur cette page.";
    };
</script>

<script>

function pushSettings() {
    Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = true})
    document.getElementById('loader').classList.remove('hide')
    document.getElementById('editing').classList.add('hide')
    var formData = new FormData();
    formData.append("content", ace.edit("editor").getValue());
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/save_advanced.php",
        success: function (data) {
            if (data == "ok") {
                window.onbeforeunload = undefined;
                location.href = "/cms-special/admin/home";
            } else {
                alert("Erreur : " + data)
                Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
                document.getElementById('loader').classList.add('hide')
                document.getElementById('editing').classList.remove('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication")
            document.getElementById('loader').classList.add('hide')
            document.getElementById('editing').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>