<?php $pageConfig = [ "domName" => "Supprimer un événement - Calendrier", "headerName" => "Supprimer un événement" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <h3>Informations sur l'événement</h3>
        <ul>
            <li><b><?= $event->name ?></b></li>
            <?php
            
            if (trim($event->description) != "") {
                echo("<li><i>" . $event->description . "</i></li>");
            }

            if (isset($event->link)) {
                if (trim($event->link) != "") {
                    echo("<li><i>" . $event->link . "</i></li>");
                }
            }
            
            ?>
            <li><?= $event->datestr ?> (<code><?= $event->timestamp ?></code>)</li>
        </ul>
        <h3>Supprimer l'événement ?</h3>
        <ul id="delete">
            <li><a class="sblink" href="/cms-special/admin/calendar" title="Ne pas supprimer l'événement sélectionné">Non</a></li>
            <li><a class="sblink" onclick="deleteEvent()" title="Supprimer l'événement sélectionné">Oui</a></li>
        </ul>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function deleteEvent() {
    document.getElementById('delete').classList.add('hide')
    var formData = new FormData();
    formData.append("id", <?= $event->timestamp ?>);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/calendar_delete.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/calendar";
            } else {
                alert("Erreur : " + data + "\n\nLa base de données du calendrier est peut être corrompue")
                document.getElementById('delete').classList.remove('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication\n\nRien a été modifié dans le calendrier")
            document.getElementById('delete').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>