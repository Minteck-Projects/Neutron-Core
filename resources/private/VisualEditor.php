<textarea name="content" id="editor">
                <?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $currentSlug) ?>
            </textarea><br>
            <center><p><a onclick="updatePage()" class="button"><?= $lang["editor"]["publish"] ?></a> <small><a onclick="updatePageNoBack()" class="sblink"><?= $lang["editor"]["publishnoback"] ?></a></small></p></center>
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
                    'undo', 'redo', '|', 'removeFormat', '|', 'heading', '|', 'fontSize', 'fontColor', 'fontBackgroundColor', 'alignment', '|', 'bold', 'italic', 'underline', 'strikethrough', '|', 'subscript', 'superscript', '|', 'code', '|', 'outdent', 'indent', '|', 'bulletedList', 'numberedList', '|', 'link', 'imageUpload', 'mediaEmbed', 'blockQuote', 'insertTable', 'codeBlock', '|', 'horizontalLine'
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
    <script>
        window.onbeforeunload = function (e) {
        e = e || window.event;

        // For IE and Firefox prior to version 4
        if (e) {
            e.returnValue = "<?= $lang["editor"]["exit"] ?>";
        }

            // For Safari
            return "<?= $lang["editor"]["exit"] ?>";
        };
    </script>