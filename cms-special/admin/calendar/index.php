<?php $pageConfig = [ "domName" => "Calendrier", "headerName" => "Gestion des événements" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <?php
        
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/calendar_events")) {
            $calevn = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/calendar_events");
        } else {
            $calevn = "3";
        }
        
        ?>
        Afficher les <select onchange="updateNextEvents()" id="nextevents">
            <option value="1" <?php if ($calevn == "1") { echo("selected"); } ?>>1</option>
            <option value="2" <?php if ($calevn == "2") { echo("selected"); } ?>>2</option>
            <option value="3" <?php if ($calevn == "3") { echo("selected"); } ?>>3</option>
            <option value="4" <?php if ($calevn == "4") { echo("selected"); } ?>>4</option>
            <option value="5" <?php if ($calevn == "5") { echo("selected"); } ?>>5</option>
            <option value="6" <?php if ($calevn == "6") { echo("selected"); } ?>>6</option>
            <option value="7" <?php if ($calevn == "7") { echo("selected"); } ?>>7</option>
            <option value="8" <?php if ($calevn == "8") { echo("selected"); } ?>>8</option>
            <option value="9" <?php if ($calevn == "9") { echo("selected"); } ?>>9</option>
            <option value="10" <?php if ($calevn == "10") { echo("selected"); } ?>>10</option>
        </select> prochains événements dans le widget.
        <h3>Événements</h3>
        <ul>
        <?php
        
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json")) {
            $dbraw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json");
            $corrupted = false;
            if (isJson($dbraw)) {
                $events = json_decode($dbraw);
                foreach ($events->events as $event) {
                    if (isset($event->timestamp)) {
                        echo("<li><span style=\"cursor:help;\" title=\"" . $event->description . "\">" . $event->name . "</span> (" . $event->datestr . ")" . " - <a class=\"sblink\" href=\"/cms-special/admin/calendar/manage/?id=" . $event->timestamp . "\" title=\"Supprimer l'événément\">Gérer</a></li>");
                    }
                }
            } else {
                echo("<div style=\"color:red; text-align: center;\"><b><u>Important :</u> La base de données du calendrier semble corrompue. Si vous n'avez pas effectué d'actions particulières récemment, cela peut venir de corruption du disque ou d'une intrusion dans votre serveur. <u>Contactez votre administrateur réseau</u></b></div>");
                $corrupted = true;
            }
        } else {
            echo("<div style=\"text-align: center;\">Aucun événement dans le calendrier pour le moment</div>");
        }

        ?>
        <?php
        
        if (!$corrupted) {
            echo('<br><li><i><a href="/cms-special/admin/calendar/add" title="Ajouter un nouvel événement au calendrier" class="sblink">Ajouter un nouvel événement</a></i></li>');
        }
        
        ?>
        </ul>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>
<script>

function updateNextEvents() {
    value = document.getElementById('nextevents').value;
    var formData = new FormData();
    formData.append("value", value);
    document.getElementById('nextevents').disabled = true;
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/calendar_nextevents.php",
        success: function (data) {
            if (data == "ok") {
                document.getElementById('nextevents').disabled = false;
            } else {
                alert("Erreur : " + data)
                document.getElementById('nextevents').disabled = false;
            }
        },
        error: function (error) {
            alert("Erreur de communication")
            document.getElementById('nextevents').disabled = false;
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>