<?php $pageConfig = [ "domName" => "Options avancées", "headerName" => "Options avancées" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <ul>
            <li>
                <a href="/cms-special/admin/advanced/jsonconf" title="Modifiez le fichier JSON des préférences de développement avancés" class="sblink">Préférences de développement</a>
            </li>
            <li>
                <a href="/cms-special/admin/advanced/regedit" title="Modifiez la base de registre de votre site (très dangeureux)" class="sblink">Éditeur de registre</a>
            </li>
        </ul>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>