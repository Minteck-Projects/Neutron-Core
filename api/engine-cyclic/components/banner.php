<div id="page-banner"></div>
<style>:root { --mpcms-banner: url(<?php
rlgps("Loaded banner image");
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/banner.jpg")) {
    echo('"/resources/upload/banner.jpg"');
} else {
    echo('"/resources/image/default.jpg"');
}

?>); }</style>