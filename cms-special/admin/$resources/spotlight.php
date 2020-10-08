<?php // Tutoriel utilisé : https://www.youtube.com/watch?v=5Y3Urj_DVMw 
?>
<script src="/resources/js/spotlight.js" defer></script>

<?php

$data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/home/all/db.json"));

?>
<ul class="spotlight-elements">
    <?php foreach ($data as $category): ?>
        <?php foreach ($category->items as $item): ?>
            <li class="spotlight-element">
                <a href="#/<?= $item->page ?>" cat="<?= $category->name ?>" icon="<?= $category->icon ?>" class="spotlight-link"><?= $lang["admin-home"]["allitems"][$item->id] ?></a>
            </li>
        <?php endforeach; ?>
    <?php endforeach; ?>
</ul>
<spotlight-bar target=".spotlight-elements a" placeholder="<?= $lang["spotlight"]["search"] ?>">
</spotlight-bar>