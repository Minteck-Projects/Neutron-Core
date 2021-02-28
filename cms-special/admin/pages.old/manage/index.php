<?php

if (isset($_GET['slug'])) {
    $currentSlug = $_GET['slug'];
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $currentSlug)) {} else {
        header("Location: /cms-special/admin/pages.old");
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit();
    }
} else {
    header("Location: /cms-special/admin/pages.old");
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit();
}

?>
<?php $pageConfig = [ "domName" => "Pages", "headerName" => "Pages" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <?php

        if ($currentSlug == "index") {
            $currentName = "{$lang['admin-pages-old']['home']}";
            echo("<script>page = \"index\"</script>");
        } else {
            $currentName = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $currentSlug . "/pagename");
            echo("<script>page = \"{$currentSlug}\"</script>");
        }
            
            if ($currentSlug == "index") {
                echo("<p><table class=\"message_info\"><tbody><tr><td><img src=\"/resources/image/message_info.svg\" class=\"message_img\"></td><td style=\"width:100%;\"><p>{$lang['admin-pages-old']['provided'][0]}</p><p>{$lang['admin-pages-old']['provided'][1]} <code>\"index\"</code> {$lang['admin-pages-old']['provided'][2]} <code>hiddenPages</code> {$lang['admin-pages-old']['provided'][3]}</p></td></tr></tbody></table></p>");
            }
            
            ?>
        <?= $lang["admin-pages-old"]["actions"] ?>
        <ul>
            <li><a class="sblink" href="/cms-special/admin/pages.old/edit/?slug=<?= $currentSlug ?>" title="<?= $lang["admin-pages-old"]["editl"] ?>"><?= $lang["admin-pages-old"]["edit"] ?> <?php if ($currentSlug == "index") {echo($lang["admin-pages-old"]["visual"]);} ?></a></li>
            <?php
            
            if ($currentSlug != "index") {
                echo('<li><a class="sblink" href="/cms-special/admin/pages.old/rename/?slug=' . $currentSlug . '" title="' . $lang["admin-pages-old"]["renamel"] . '">' . $lang["admin-pages-old"]["rename"] . '</a></li>');
                echo('<li><a class="sblink" href="/cms-special/admin/pages.old/delete/?slug=' . $currentSlug . '" title="' . $lang["admin-pages-old"]["deletel"] . '">' . $lang["admin-pages-old"]["delete"] . '</a></li>');
            } else {
                echo('<li><a class="sblink" href="/cms-special/admin/pages.old/edit/?slug=' . $currentSlug . '&forcehtml" title="' . $lang["admin-pages-old"]["htmll"] . '">' . $lang["admin-pages-old"]["htmle"] . '</a></li>');
            }
            
            ?>
        </ul>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>
