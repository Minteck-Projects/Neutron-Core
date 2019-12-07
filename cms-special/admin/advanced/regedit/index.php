<?php

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {

    } else {
        die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/advanced/regedit&pa='</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/?pr=/cms-special/admin/advanced/regedit&pa='</script>");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Éditeur de registre MPCMS</title>
    <link rel="stylesheet" href="/resources/css/regedit.css">
</head>
<body>
    <h1>Explorateur de registre de Minteck Projects CMS</h1>
    <p><b>Attention :</b> L'éditeur de registre constitue le cœur de votre site, toute modification erronée peut empêcher votre site de fonctionner correctement ou le rendre vulnérable à de potentielles failles de sécurité. Pour cela, seul votre administrateur système est en mesure d'effectuer des modifications.</p>
    <h3>/</h3>
    <a href="/cms-special/admin/advanced/regedit"><small>Dossier parent</small></a><br>
    <img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/keys.svg"><a href="/cms-special/admin/advanced/regedit/view/?key=HKWC">HKEY_WEBSITE_CONTENT</a> <i>(Configuration et contenu du site)</i><br>
    <img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/keys.svg"><a href="/cms-special/admin/advanced/regedit/view/?key=HKST">HKEY_SESSION_TOKENS</a> <i>(Jetons d'authentification à l'administration)</i><br>
    <img width="36px" height="36px" style="vertical-align:middle;margin-left:10px;" src="/resources/image/regedit/keys.svg"><a href="/cms-special/admin/advanced/regedit/view/?key=HKUR">HKEY_UPLOADS_ROOT</a> <i>(Fichiers mis en ligne sur le site)</i>
</body>
</html>