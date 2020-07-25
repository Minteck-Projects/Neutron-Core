<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Affichage connecté</title>
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="./marquee.css">
    <link rel="stylesheet" href="./snow.css">
    <link rel="stylesheet" href="/resources/css/fonts-import.css">
    <script src="/resources/js/jquery.js"></script>
</head>
<body id="ui">
    <?php
    
    if (isset($_COOKIE['ADMIN_TOKEN']) && $_COOKIE['ADMIN_TOKEN'] != "." && $_COOKIE['ADMIN_TOKEN'] != ".." && $_COOKIE['ADMIN_TOKEN'] != "/") {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {
    
        } else {
            die("<script>location.href = '/cms-special/admin'</script></body></html>");
        }
    } else {
        die("<script>location.href = '/cms-special/admin'</script></body></html>");
    }
    
    ?>
    <div id="gradient" class="background"></div>
    <div class="errorb hide" id="connection"><b>Erreur :</b> La communication avec l'appareil de configuration a été interrompue d'une manière inopinnée</div>
    <div class="warningb hide" id="slow"><b>Avertissement :</b> La communication avec le serveur est plus lente que d'habitude</div>
    <div class="infob hide" id="control"><b>Information :</b> Un appareil distant tente de s'authentifier auprès de cet affichage connecté</div>
    <div class="fullbox hide" id="starterror">
        <div class="fbheader">Impossible de démarrer l'affichage connecté</div>
        <p>L'affichage connecté ne peut pas démarrer correctement sur votre appareil et/ou votre réseau, pour une ou plusieurs raisons spécifiques. Ces raisons sont généralement :</p>
        <ul>
            <li>votre connexion Internet est trop lente</li>
            <li>l'affichage connecté n'est pas installé correctement</li>
            <li>votre navigateur n'est pas compatible</li>
        </ul>
    </div>
    <div class="fullbox hide" id="welcome">
        <div class="fbheader">Associez cet affichage connecté à votre smartphone</div>
        <p>Utilisez l'application Android MPCMS Display pour contrôler à distance cet affichage connecté, et entrez-y ce texte dans le champ "Adresse du serveur" :</p>
        <h3><center><?= $_SERVER['HTTP_HOST'] ?></center></h3>
        <p>Si votre site Web est protégé par un mot de passe, entrez vos identifiants dans les champs correspondants. Si il n'est pas protégé par un mot de passe, laissez les vide.</p>
    </div>
    <div class="fullbox hide" id="code">
        <div class="fbheader">Confirmez que c'est bien vous</div>
        <p>Vous devez confirmer que c'est bien vous qui essayez de vous connecter à l'affichage</p>
        <?php $code = rand(11111, 99999);file_put_contents("./api/session_key", $code);echo("<script>var code = " . $code . ";</script>") ?>
        <h3><center><?= $code ?></center></h3>
        <p>Ce code permet de vérifier que vous avez bien accès à l'affichage connecté que vous voulez contrôler.</p>
    </div>
    <div id="clock">
        <span id="clock-time">00:00</span><br>
        <span id="clock-date">1er janv.</span>
    </div>
    <div id="info">
        <table>
            <tbody>
                <tr>
                    <td><img src="/resources/image/display.svg" id="icon"></td>
                    <td><span id="info-text"><?= $_SERVER['HTTP_HOST'] ?><br><small><?= $code ?></small></span></td>
                </tr>
            </tbody>
        </table>
    </div>
    <span class="marquee" id="scrolltext">Vous n'avez défini aucun message pour le texte défilent, ou alors il n'a pas encore été récupéré. Définissez-en un via l'application mobile</span>
    <div id="snowmode-handler"></div>
    <div id="message-placeholder" class="centered">
        <h3 id="message-title">Chargement en cours...</h3>
        <span id="message-text">Le chargement du contenu demandé est en cours</span>
    </div>
    <div id="loader">
        <span class="centered">
            <p><img src="./logo.png" width="128px" height="128px"></p>
            <p><img class="o0-before" id="loader-anim" src="./loader.svg" width="56px" height="56px"></p>
        </span>
    </div>
</body>
<script src="./watchdog.js"></script>
<script src="./scroll.js"></script>
<script src="./background.js"></script>
<script src="./snow.js"></script>
<script src="./clock.js"></script>
<script src="./message.js"></script>
<script src="./loader.js"></script>
</html>
