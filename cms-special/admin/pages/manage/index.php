<?php

if (isset($_GET['slug'])) {
    $currentSlug = $_GET['slug'];
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $currentSlug)) {} else {
        header("Location: /cms-special/admin/pages");
        die();
    }
} else {
    header("Location: /cms-special/admin/pages");
    die();
}

?>
<?php $pageConfig = [ "domName" => "Pages", "headerName" => "Pages" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <?php

        if ($currentSlug == "index") {
            $currentName = "{$lang['admin-pages']['home']}";
            echo("<script>page = \"index\"</script>");
        } else {
            $currentName = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $currentSlug . "/pagename");
            echo("<script>page = \"{$currentSlug}\"</script>");
        }
            
            if ($currentSlug == "index") {
                echo("<p><table class=\"message_info\"><tbody><tr><td><img src=\"/resources/image/message_info.svg\" class=\"message_img\"></td><td style=\"width:100%;\"><p>{$lang['admin-pages']['provided'][0]}</p><p>{$lang['admin-pages']['provided'][1]} <code>\"index\"</code> {$lang['admin-pages']['provided'][2]} <code>hiddenPages</code> {$lang['admin-pages']['provided'][3]}</p></td></tr></tbody></table></p>");
            }
            
            ?>
        <?= $lang["admin-pages"]["actions"] ?>
        <ul>
            <li><a class="sblink" href="/cms-special/admin/pages/edit/?slug=<?= $currentSlug ?>" title="<?= $lang["admin-pages"]["editl"] ?>"><?= $lang["admin-pages"]["edit"] ?> <?php if ($currentSlug == "index") {echo($lang["admin-pages"]["visual"]);} ?></a></li>
            <?php
            
            if ($currentSlug != "index") {
                echo('<li><a class="sblink" href="/cms-special/admin/pages/rename/?slug=' . $currentSlug . '" title="' . $lang["admin-pages"]["renamel"] . '">' . $lang["admin-pages"]["rename"] . '</a></li>');
                echo('<li><a class="sblink" href="/cms-special/admin/pages/delete/?slug=' . $currentSlug . '" title="' . $lang["admin-pages"]["deletel"] . '">' . $lang["admin-pages"]["delete"] . '</a></li>');
            } else {
                echo('<li><a class="sblink" href="/cms-special/admin/pages/edit/?slug=' . $currentSlug . '&forcehtml" title="' . $lang["admin-pages"]["htmll"] . '">' . $lang["admin-pages"]["htmle"] . '</a></li>');
            }
            
            ?>
        </ul>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>