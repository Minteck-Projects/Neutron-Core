<textarea name="content" id="editor">
                <?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $currentSlug) ?>
            </textarea><br>
            <center><p><a onclick="updatePage()" class="button">Publier</a></p></center>
            <script>
        let editor;
        ClassicEditor
            .create( document.querySelector( '#editor' ), {
                language: {
                    ui: 'fr',
                    content: 'fr'
                },
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'link', '|', 'mediaembed', 'blockquote', 'inserttable', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo'
                ],
                typing: {
            transformations: {
                include: [
                    'quotes',
                    'typography',
                    'symbols',
                    'quotes',

                    'arrowLeft',
                    'arrowRight',

                    { from: 'CKE', to: 'CKEditor' },
                    {
                        from: /(^|\s)(")([^"]*)(")$/,
                        to: [ null, '« ', null, ' »' ]
                    },
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