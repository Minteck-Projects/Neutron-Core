<?php

ob_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/api/lang/processor.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/headers/preprocessor.php";

include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/heads.php";

include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/components/init.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/components/menubar.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/components/drawer.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/components/banner.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/components/content.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/components/footer.php";

include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/tails.php";

?>