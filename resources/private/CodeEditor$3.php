<p><input type="checkbox" name="wordwrap" id="wordwrap" onchange="ace.edit(&quot;editor&quot;).getSession().setUseWrapMode(document.getElementById('wordwrap').checked);" checked><label for="wordwrap">Retour automatique à la ligne</label></p>

<div id="editor"><?php echo(str_ireplace(">", "&gt;", str_ireplace("<", "&lt;", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json")))) ?></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.6/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var codeeditor = ace.edit("editor");
    <?php
    
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/darktheme-enabled")) {
        echo("ace.edit(\"editor\").setTheme('ace/theme/monokai');");
    }
    
    ?>
    codeeditor.session.setMode("ace/mode/html");
    codeeditor.session.setUseWrapMode(true);
    function loadAce() {}
</script>