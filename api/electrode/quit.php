<?php

function quit (string $message = NULL) {
    if (function_exists("__electrode_end_hooks")) {
        __electrode_end_hooks();
    }
    if (isset($message)) {
        die($message);
    } else {
        die();
    }
}
