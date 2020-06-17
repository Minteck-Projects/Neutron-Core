<?php $pageConfig = [ "domName" => "Configuration de l'extension - Extensions", "headerName" => "Configuration de l'extension" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <p><?= $lang["admin-plugins"]["widgetconf"]->textedit ?></p>
        <div id="data">
        <textarea name="content" id="editor">
                <?php

                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-notes-data")) {
                    echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-notes-data"));
                }

                ?>
            </textarea><br>
            <script>
        let colors = [{
        color: 'hsl(0, 0%, 0%)',
    },
    {
        color: 'hsl(0, 0%, 12.5%)',
    },
    {
        color: 'hsl(0, 0%, 25%)',
    },
    {
        color: 'hsl(0, 0%, 37.5%)',
    },
    {
        color: 'hsl(0, 0%, 50%)',
    },
    {
        color: 'hsl(0, 0%, 62.5%)',
    },
    {
        color: 'hsl(0, 0%, 75%)',
    },
    {
        color: 'hsl(0, 0%, 87.5%)',
    },
    {
        color: 'hsl(0, 0%, 100%)',
        hasBorder: true,
    },
    {
        color: 'hsl(0, 100%, 10%)',
    },
    {
        color: 'hsl(0, 100%, 12.5%)',
    },
    {
        color: 'hsl(0, 100%, 25%)',
    },
    {
        color: 'hsl(0, 100%, 37.5%)',
    },
    {
        color: 'hsl(0, 100%, 50%)',
    },
    {
        color: 'hsl(0, 100%, 62.5%)',
    },
    {
        color: 'hsl(0, 100%, 75%)',
    },
    {
        color: 'hsl(0, 100%, 87.5%)',
    },
    {
        color: 'hsl(0, 100%, 90%)',
        hasBorder: true,
    },
    {
        color: 'hsl(30, 100%, 10%)',
    },
    {
        color: 'hsl(30, 100%, 12.5%)',
    },
    {
        color: 'hsl(30, 100%, 25%)',
    },
    {
        color: 'hsl(30, 100%, 37.5%)',
    },
    {
        color: 'hsl(30, 100%, 50%)',
    },
    {
        color: 'hsl(30, 100%, 62.5%)',
    },
    {
        color: 'hsl(30, 100%, 75%)',
    },
    {
        color: 'hsl(30, 100%, 87.5%)',
    },
    {
        color: 'hsl(30, 100%, 90%)',
        hasBorder: true,
    },
    {
        color: 'hsl(60, 100%, 10%)',
    },
    {
        color: 'hsl(60, 100%, 12.5%)',
    },
    {
        color: 'hsl(60, 100%, 25%)',
    },
    {
        color: 'hsl(60, 100%, 37.5%)',
    },
    {
        color: 'hsl(60, 100%, 50%)',
    },
    {
        color: 'hsl(60, 100%, 62.5%)',
    },
    {
        color: 'hsl(60, 100%, 75%)',
    },
    {
        color: 'hsl(60, 100%, 87.5%)',
    },
    {
        color: 'hsl(60, 100%, 90%)',
        hasBorder: true,
    },
    {
        color: 'hsl(90, 100%, 10%)',
    },
    {
        color: 'hsl(90, 100%, 12.5%)',
    },
    {
        color: 'hsl(90, 100%, 25%)',
    },
    {
        color: 'hsl(90, 100%, 37.5%)',
    },
    {
        color: 'hsl(90, 100%, 50%)',
    },
    {
        color: 'hsl(90, 100%, 62.5%)',
    },
    {
        color: 'hsl(90, 100%, 75%)',
    },
    {
        color: 'hsl(90, 100%, 87.5%)',
    },
    {
        color: 'hsl(90, 100%, 90%)',
        hasBorder: true,
    },
    {
        color: 'hsl(120, 100%, 10%)',
    },
    {
        color: 'hsl(120, 100%, 12.5%)',
    },
    {
        color: 'hsl(120, 100%, 25%)',
    },
    {
        color: 'hsl(120, 100%, 37.5%)',
    },
    {
        color: 'hsl(120, 100%, 50%)',
    },
    {
        color: 'hsl(120, 100%, 62.5%)',
    },
    {
        color: 'hsl(120, 100%, 75%)',
    },
    {
        color: 'hsl(120, 100%, 87.5%)',
    },
    {
        color: 'hsl(120, 100%, 90%)',
        hasBorder: true,
    },
    {
        color: 'hsl(150, 100%, 10%)',
    },
    {
        color: 'hsl(150, 100%, 12.5%)',
    },
    {
        color: 'hsl(150, 100%, 25%)',
    },
    {
        color: 'hsl(150, 100%, 37.5%)',
    },
    {
        color: 'hsl(150, 100%, 50%)',
    },
    {
        color: 'hsl(150, 100%, 62.5%)',
    },
    {
        color: 'hsl(150, 100%, 75%)',
    },
    {
        color: 'hsl(150, 100%, 87.5%)',
    },
    {
        color: 'hsl(150, 100%, 90%)',
        hasBorder: true,
    },
    {
        color: 'hsl(180, 100%, 10%)',
    },
    {
        color: 'hsl(180, 100%, 12.5%)',
    },
    {
        color: 'hsl(180, 100%, 25%)',
    },
    {
        color: 'hsl(180, 100%, 37.5%)',
    },
    {
        color: 'hsl(180, 100%, 50%)',
    },
    {
        color: 'hsl(180, 100%, 62.5%)',
    },
    {
        color: 'hsl(180, 100%, 75%)',
    },
    {
        color: 'hsl(180, 100%, 87.5%)',
    },
    {
        color: 'hsl(180, 100%, 90%)',
        hasBorder: true,
    },
    {
        color: 'hsl(210, 100%, 10%)',
    },
    {
        color: 'hsl(210, 100%, 12.5%)',
    },
    {
        color: 'hsl(210, 100%, 25%)',
    },
    {
        color: 'hsl(210, 100%, 37.5%)',
    },
    {
        color: 'hsl(210, 100%, 50%)',
    },
    {
        color: 'hsl(210, 100%, 62.5%)',
    },
    {
        color: 'hsl(210, 100%, 75%)',
    },
    {
        color: 'hsl(210, 100%, 87.5%)',
    },
    {
        color: 'hsl(210, 100%, 90%)',
        hasBorder: true,
    },
    {
        color: 'hsl(240, 100%, 10%)',
    },
    {
        color: 'hsl(240, 100%, 12.5%)',
    },
    {
        color: 'hsl(240, 100%, 25%)',
    },
    {
        color: 'hsl(240, 100%, 37.5%)',
    },
    {
        color: 'hsl(240, 100%, 50%)',
    },
    {
        color: 'hsl(240, 100%, 62.5%)',
    },
    {
        color: 'hsl(240, 100%, 75%)',
    },
    {
        color: 'hsl(240, 100%, 87.5%)',
    },
    {
        color: 'hsl(240, 100%, 90%)',
        hasBorder: true,
    },
    {
        color: 'hsl(270, 100%, 10%)',
    },
    {
        color: 'hsl(270, 100%, 12.5%)',
    },
    {
        color: 'hsl(270, 100%, 25%)',
    },
    {
        color: 'hsl(270, 100%, 37.5%)',
    },
    {
        color: 'hsl(270, 100%, 50%)',
    },
    {
        color: 'hsl(270, 100%, 62.5%)',
    },
    {
        color: 'hsl(270, 100%, 75%)',
    },
    {
        color: 'hsl(270, 100%, 87.5%)',
    },
    {
        color: 'hsl(270, 100%, 90%)',
        hasBorder: true,
    },
    {
        color: 'hsl(300, 100%, 10%)',
    },
    {
        color: 'hsl(300, 100%, 12.5%)',
    },
    {
        color: 'hsl(300, 100%, 25%)',
    },
    {
        color: 'hsl(300, 100%, 37.5%)',
    },
    {
        color: 'hsl(300, 100%, 50%)',
    },
    {
        color: 'hsl(300, 100%, 62.5%)',
    },
    {
        color: 'hsl(300, 100%, 75%)',
    },
    {
        color: 'hsl(300, 100%, 87.5%)',
    },
    {
        color: 'hsl(300, 100%, 90%)',
        hasBorder: true,
    },
    {
        color: 'hsl(330, 100%, 10%)',
    },
    {
        color: 'hsl(330, 100%, 12.5%)',
    },
    {
        color: 'hsl(330, 100%, 25%)',
    },
    {
        color: 'hsl(330, 100%, 37.5%)',
    },
    {
        color: 'hsl(330, 100%, 50%)',
    },
    {
        color: 'hsl(330, 100%, 62.5%)',
    },
    {
        color: 'hsl(330, 100%, 75%)',
    },
    {
        color: 'hsl(330, 100%, 87.5%)',
    },
    {
        color: 'hsl(330, 100%, 90%)',
        hasBorder: true,
    }];
        let editor;
        ClassicEditor
            .create( document.querySelector( '#editor' ), {
                language: {
                    ui: <?= "'" . $langsel . "'" ?>,
                    content: <?= "'" . $langsel . "'" ?>
                },
                toolbar: [
                    'undo', 'redo', '|', 'removeFormat', '|', 'fontSize', 'fontColor', 'fontBackgroundColor', 'alignment', '|', 'bold', 'italic', 'underline', 'strikethrough', '|', 'code', '|', 'outdent', 'indent', '|', 'bulletedList', 'numberedList', '|', 'link'
                ],
                fontColor: {
                    colors: colors,
                    columns: 9
                },
            } )
            .then( newEditor => {
                editor = newEditor;
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
            <p><center><a class="button" onclick="saveChanges()" title="<?= $lang["admin-plugins"]["widgetconf"]->saveph ?>"><?= $lang["admin-plugins"]["widgetconf"]->save ?></a></center></p>
        </div>
        <div class="hide" id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

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
                alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data);
                document.getElementById('data').classList.remove('hide')
                document.getElementById('loader').classList.add('hide')
            }
        },
        error: function (error) {
            alert("<?= $lang["admin-errors"]["connerror"] ?>");
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
