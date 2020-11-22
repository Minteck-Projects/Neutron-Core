<?php $pageConfig = [ "domName" => "Erreur", "headerName" => "Erreur" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
                    <h1><div style="text-align: center;"><?= $lang["admin-errors"]["common"]->title ?></div></h1>
                    <p><div style="text-align: center;"><?= $lang["admin-errors"]["common"]->message ?></div></p>
                    <p><div style="text-align: center;">
                        <ul>
                            <li><a href="http://bugs.minteck-projects.rf.gd/set_project.php?project_id=1" target="_blank"><?= $lang["admin-errors"]["common"]->report ?></a></li>
                            <li><a href="/cms-special/admin/home"><?= $lang["admin-errors"]["common"]->home ?></a></li>
                        </ul>
                    </div></p>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>
