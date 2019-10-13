<div id="editor"><?php echo(str_ireplace(">", "&gt;", str_ireplace("<", "&lt;", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $currentSlug)))) ?></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.6/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    setInterval(() => {
        var codeeditor = ace.edit("editor");
        <?php
        
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/darktheme-enabled")) {
            echo("ace.edit(\"editor\").setTheme('ace/theme/monokai');");
        }

        ?>
        codeeditor.session.setMode("ace/mode/html");
    }, 100)
    function loadAce() {}
</script>
<center><p><a onclick="updatePageHTML()" class="button">Publier</a></p></center>