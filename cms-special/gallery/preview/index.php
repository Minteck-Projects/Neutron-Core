<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/api/lang/processor.php";

if (isset($_GET['return'])) {
    $callback = $_GET['return'];
} else {
    $callback = "/";
}

?>
<!DOCTYPE html>
<html lang="en" style="height:100%;overflow:hidden;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/resources/css/preview.css">
    <title><?= $lang["gallery"]["preview"]->title ?></title>
</head>
<?php

    if (isset($_GET['url'])) {
        if (strpos($_GET['url'], '..') !== false) {
            die($lang["gallery"]["preview"]->invalid);
        } else {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/" . $_GET['url'])) {
                $ext1 = explode(".", $_GET['url']);
                $ext2 = end($ext1);
                $ext = strtoupper($ext2);
            } else {
                die($lang["gallery"]["preview"]->notfound);
            }
        }
    } else {
        die($lang["gallery"]["preview"]->none);
    }

?>
<body style="background-image:url('<?= $_GET['url'] ?>');background-size:contain;background-position:center;height: 100%;margin: 0;background-repeat: no-repeat;background-color: #222;">
    <a title="<?= $lang["gallery"]["preview"]->close ?>"><img src="/resources/image/close.svg" onclick="location.href = &quot;<?= $callback ?>&quot;"></a>
    <a class="download" href="<?= $_GET['url'] ?>" title="<?= $lang["gallery"]["preview"]->placeholder[0] ?> <?= $ext ?> <?= $lang["gallery"]["preview"]->placeholder[1] ?>" download><?= $lang["gallery"]["preview"]->download ?> (<?= $ext ?>)</a>
</body>
<script>

window.onload = () => {setTimeout(() => {Array.from(document.getElementsByClassName('ppreview')).forEach((el) => {el.classList.add('loaded')});}, 1000)}

</script>
</html>