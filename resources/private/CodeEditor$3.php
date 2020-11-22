<p><input type="checkbox" name="wordwrap" id="wordwrap" onchange="ace.edit(&quot;editor&quot;).getSession().setUseWrapMode(document.getElementById('wordwrap').checked);" checked><label for="wordwrap"><?= $lang["editor"]["wrap"] ?></label></p>

<div id="editor"><?php echo(str_ireplace(">", "&gt;", str_ireplace("<", "&lt;", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/customSettings.json")))) ?></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.6/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var codeeditor = ace.edit("editor");
    <?php

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/darktheme-enabled")) {
        echo("ace.edit(\"editor\").setTheme('ace/theme/monokai');");
    }

    ?>
    codeeditor.session.setMode("ace/mode/json");
    codeeditor.session.setUseWrapMode(true);
    function loadAce() {}
</script>
<script>setInterval(() => {ace.edit("editor").session.setMode("ace/mode/json");}, 100)</script>
<div style="text-align: center;"><p><a onclick="pushSettings()" class="button"><?= $lang["editor"]["save"] ?></a></p></div>
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