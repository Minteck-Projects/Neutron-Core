<?php

ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/api/lang/processor.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/headers/preprocessor.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/includes/includes.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/heads.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/components/init.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/components/menubar.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/components/drawer.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/components/banner.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/components/content.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/components/footer.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/tails.php";