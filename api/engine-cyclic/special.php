<?php

ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/api/lang/processor.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/headers/preprocessor.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/api/engine-cyclic/includes/includes.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/api/engine-cyclic/heads.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/api/engine-cyclic/components/init.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/api/engine-cyclic/components/menubar.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/api/engine-cyclic/components/drawer.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/api/engine-cyclic/components/banner.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/api/engine-cyclic/components/content.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/api/engine-cyclic/components/footer.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/api/engine-cyclic/tails.php";