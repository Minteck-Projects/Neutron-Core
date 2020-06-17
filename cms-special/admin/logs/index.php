<?php $pageConfig = [ "domName" => "Historique d'activité", "headerName" => "Historique d'activité" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <div id="logs">
            <?php
            
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
                $file = file($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log");
                for ($i = max(0, count($file)-100); $i < count($file); $i++) {
                    echo $file[$i] . "<br>";
                }
            } else {
                echo($lang["admin-logs"]["nothing"][0] . "<br><br>" . $lang["admin-logs"]["nothing"][1]);
            }
            
            ?>
            </div><br><br>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>