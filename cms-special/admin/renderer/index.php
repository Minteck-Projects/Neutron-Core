<?php $pageConfig = [ "domName" => "Options avancées", "headerName" => "Options avancées" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
<?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/renderer.log")): ?>
    <?= "<p><table class=\"message_info\"><tbody><tr><td><img src=\"/resources/image/message_info.svg\" class=\"message_img\"></td><td style=\"width:100%;\"><p>{$lang['admin-renderer']['notice']}</p></td></tr></tbody></table></p>" ?>
    <pre class="update-logs" id="logs"><?= str_replace("\n", "<br>", str_replace("<", "&lt;", str_replace(">", "&gt;", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/renderer.log")))) ?></pre>
<?php else: ?>
    <p><i><?= $lang["admin-renderer"]["notrace"] ?></i></p>
<?php endif; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>