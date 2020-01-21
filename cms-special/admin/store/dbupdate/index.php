<?php $pageConfig = [ "domName" => "Regénération de la base de données - CMS Store", "headerName" => "Regénération de la base de données" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <?php
        
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/store")) {
            die("<script>location.href = \"/cms-special/admin/store\"</script></div></body></html>");
        }

        ?>
        <?php

        echo("<br><br><center><img src=\"/resources/image/storeloader.svg\" width=\"48px\" height=\"48px\" style=\"filter:brightness(50%);\"><br><span id=\"loadmsg\">Regénération de la base de données...</span></center><br><br>");
        $install = true;

        ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

window.onload = () => {
    if (<?php if($install === true){echo("true");}else{echo("false");}; ?>) {
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/store_database_update.php",
            success: function (data) {
                if (data == "ok") {
                    document.getElementById('loadmsg').innerHTML = "Terminé"
                    location.href = "/cms-special/admin/store/"
                } else {
                    document.getElementById('loadmsg').innerHTML = "Une erreur s'est produite : " + data;
                }
            },
            error: function (error) {
                document.getElementById('loadmsg').innerHTML = "Erreur de communication";
                window.onbeforeunload = undefined;
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
}

</script>