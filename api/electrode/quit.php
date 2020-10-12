<?php

function quit (string $message) {
    if (function_exists("__electrode_end_hooks")) {
        __electrode_end_hooks();
    }
    die($message);
}