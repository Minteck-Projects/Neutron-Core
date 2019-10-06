<?php

// Functions definitions
function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

// Config loader
$configraw = file_get_contents("./api/config.json");
if (isJson($configraw)) {
    $config = json_decode($configraw);
} else {
    echo("APIRejection: config.json is invalid");
}

// Handler

if ($_SERVER['REQUEST_METHOD'] == "GET" || $_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_GET['command'])) {
        $command = $_GET['command'];
    } else {
        die("APIRejection: No command was received by the server");
    }

    if (isset($_GET['key'])) {
        if ($_GET['key'] == file_get_contents("./api/session_key")) {
        } else {
            die("APIRejection: Invalid credentials (&key=) where provided");
        }
    } else {
        if ($command == "pushStatus") {
            file_put_contents("./api/status_timestamp", "&key?");
            die("ok");
        } else if ($command != "confirmKey") {
            die("APIRejection: No token (&key=) was given");
        }
    }

    if (isset($_GET['data'])) {
        if (trim($_GET['data']) == "") {} else {
            $dataraw = $_GET['data'];
            if (isJson($dataraw)) {
                $data = json_decode($dataraw);
            } else {
                die("APIRejection: Syntax error on received data. Data isn't valid JSON\n\nReceived Data:\n" . $dataraw);
            }
        }
    } else {
        die("APIRejection: No data was received by the server");
    }

    if ($command == "getStatus") {
        if ($config->disable_timestamp_checking) {
            die("ok");
        } else {
            // var_dump(file_get_contents("./api/status_timestamp"));
            if (file_get_contents("./api/status_timestamp") == date('YmdHi') . substr(date('s'), 0, 1)) {
                die("ok");
            } else if (file_get_contents("./api/status_timestamp") == "&key?") {
                die("key");
            } else {
                die("offline");
            }
        }
    }

    if ($command == "getScrollMessage") {
        die(file_get_contents("./api/scroll_message"));
    }

    if ($command == "getBackground") {
        die(file_get_contents("./api/background_url"));
    }

    if ($command == "pushStatus") {
        file_put_contents("./api/status_timestamp", date('YmdHi') . substr(date('s'), 0, 1));
        die("ok");
    }

    if ($command == "updateSnowMode") {
        if (isset($data->value)) {
            if (is_bool($data->value)) {
                if ($data->value) {
                    file_put_contents("./api/snow_mode", "true");
                    die("ok");
                } else {
                    file_put_contents("./api/snow_mode", "false");
                    die("ok");
                }
            } else {
                die("APIRejection: Expected key /value/ to be boolean, but wasn't that");
            }
        } else {
            die("APIRejection: Missing key /value/ on data JSON");
        }
    }

    if ($command == "setBackground") {
        if (isset($data->value)) {
            if (is_string($data->value)) {
                file_put_contents("./api/background_url", $data->value);
                die("ok");
            } else {
                die("APIRejection: Expected key /value/ to be string, but wasn't that");
            }
        } else {
            die("APIRejection: Missing key /value/ on data JSON");
        }
    }

    if ($command == "setScrollMessage") {
        if (isset($data->value)) {
            if (is_string($data->value)) {
                file_put_contents("./api/scroll_message", $data->value);
                die("ok");
            } else {
                die("APIRejection: Expected key /value/ to be string, but wasn't that");
            }
        } else {
            die("APIRejection: Missing key /value/ on data JSON");
        }
    }

    if ($command == "confirmKey") {
        if (isset($data->value)) {
            if (is_string($data->value)) {
                if ($data->value == file_get_contents("./api/session_key")) {
                    die("ok");
                } else {
                    die("no");
                }
            } else {
                die("APIRejection: Expected key /value/ to be string, but wasn't that");
            }
        } else {
            die("APIRejection: Missing key /value/ on data JSON");
        }
    }

    if ($command == "setMessageTitle") {
        if (isset($data->value)) {
            if (is_string($data->value)) {
                file_put_contents("./api/message_title", $data->value);
                die("ok");
            } else {
                die("APIRejection: Expected key /value/ to be string, but wasn't that");
            }
        } else {
            die("APIRejection: Missing key /value/ on data JSON");
        }
    }

    if ($command == "setMessageText") {
        if (isset($data->value)) {
            if (is_string($data->value)) {
                file_put_contents("./api/message_text", $data->value);
                die("ok");
            } else {
                die("APIRejection: Expected key /value/ to be string, but wasn't that");
            }
        } else {
            die("APIRejection: Missing key /value/ on data JSON");
        }
    }

    if ($command == "getMessageTitle") {
        die(file_get_contents("./api/message_title"));
    }

    if ($command == "getMessageText") {
        die(file_get_contents("./api/message_text"));
    }

    if ($command == "getSnowMode") {
        die(file_get_contents("./api/snow_mode"));
    }
    
    die("APIRejection: Unknown Command");

} else {
    header("HTTP/1.1 403 Forbidden");
    die("APIRejection: Non-GET and non-POST request method was received by the server");
}