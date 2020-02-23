<textarea name="content" id="editor">
            </textarea><br>
            <center><p><a onclick="createPageVisual()" class="button">Publier</a></p></center>
            <script>
        let editor;
        ClassicEditor
            .create( document.querySelector( '#editor' ), {
                language: {
                    ui: <?= "'" . $langsel . "'" ?>,
                    content: <?= "'" . $langsel . "'" ?>
                },
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'link', '|', 'mediaembed', 'blockquote', 'inserttable', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo'
                ],
                typing: {
            transformations: {
                include: [
                    // Use only the 'quotes' and 'typography' groups.
                    'quotes',
                    'typography',

                    // Plus some custom transformation.
                    { from: 'CKE', to: 'CKEditor' }
                ],
            }
        }
            } )
            .then( newEditor => {
                editor = newEditor;
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
