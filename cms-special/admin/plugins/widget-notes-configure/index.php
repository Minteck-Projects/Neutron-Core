<?php $pageConfig = [ "domName" => "Configuration de l'extension - Extensions", "headerName" => "Configuration de l'extension" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <p>Entrez le texte qui devra être affiché dans la barre des widgets. L'édition "inline" uniquement est supportée (pas de titres, tableaux, etc...).</p>
        <div id="data">
        <textarea name="content" id="editor">
                <?php
                
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-notes-data")) {
                    echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-notes-data"));
                }
                
                ?>
            </textarea><br>
            <script>
        let editor;
        ClassicEditor
            .create( document.querySelector( '#editor' ), {
                language: {
                    ui: 'fr',
                    content: 'fr'
                },
                toolbar: [
                    'bold', 'italic', 'link', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo'
                ]
            } )
            .then( newEditor => {
                editor = newEditor;
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
            <p><center><a class="button" onclick="saveChanges()" title="Sauvegarder la configuration du widget">Sauvegarder</a></center></p>
        </div>
        <div class="hide" id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function saveChanges() {
    document.getElementById('data').classList.add('hide')
    document.getElementById('loader').classList.remove('hide')
    var formData = new FormData();
    formData.append("content", editor.getData());
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/widget-notes-configure.php",
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