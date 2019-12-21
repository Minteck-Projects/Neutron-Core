<p><input type="checkbox" name="wordwrap" id="wordwrap" onchange="ace.edit(&quot;editor&quot;).getSession().setUseWrapMode(document.getElementById('wordwrap').checked);" checked><label for="wordwrap">Retour automatique à la ligne</label></p>

<div id="editor">&lt;!-- L'éditeur de code Minteck Projects CMS ne vous fait pas modifier un fichier entier.
Vous ne modifiez qu'une partie de fichier.

Vous pouvez donc ignorer les avertissements relatifs à certaines informations manquantes

____________________________

--&gt;

&lt;!-- Insérez le code CSS requis pour votre page ici --&gt;
&lt;style&gt;&lt;/style&gt;

&lt;!-- Insérez le code JavaScript requis pour votre page ici --&gt;
&lt;script type="text/javascript"&gt;&lt;/script&gt;

&lt;!-- Insérez le code HTML de votre page ici --&gt;</div>

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
<script>setInterval(() => {ace.edit("editor").session.setMode("ace/mode/html");}, 100)</script>
<center><p><a onclick="createPageHTML()" class="button">Publier</a> <small><a onclick="createPageHTMLNoBack()" class="sblink">Publier et continuer à modifier</a></small></p></center>