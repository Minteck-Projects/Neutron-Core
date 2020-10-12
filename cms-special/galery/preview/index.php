<?php

header("Location: " . str_replace("/galery", "/gallery", $_SERVER['REQUEST_URI']));
require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit();