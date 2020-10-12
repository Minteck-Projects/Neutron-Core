<?php

// Token check
if (isset($_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN']) && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != "." && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != ".." && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != "/") {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'])) { 
    } else {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("<script>location.href = '/cms-special/admin'</script></body></html>");
    }
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("<script>location.href = '/cms-special/admin'</script></body></html>");
}
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
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: No command was received by the server");
    }

    if (isset($_GET['key'])) {
        if ($_GET['key'] == file_get_contents("./api/session_key")) {
        } else {
            require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: Invalid credentials (&key=) where provided");
        }
    } else {
        if ($command == "pushStatus") {
            file_put_contents("./api/status_timestamp", "&key?");
            require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");
        } else if ($command != "confirmKey") {
            require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: No token (&key=) was given");
        }
    }

    if (isset($_GET['data'])) {
        if (trim($_GET['data']) == "") {} else {
            $dataraw = $_GET['data'];
            if (isJson($dataraw)) {
                $data = json_decode($dataraw);
            } else {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: Syntax error on received data. Data isn't valid JSON\n\nReceived Data:\n" . $dataraw);
            }
        }
    } else {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: No data was received by the server");
    }

    if ($command == "getStatus") {
        if ($config->disable_timestamp_checking) {
            require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");
        } else {
            // var_dump(file_get_contents("./api/status_timestamp"));
            if (file_get_contents("./api/status_timestamp") == date('YmdHi') . substr(date('s'), 0, 1)) {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");
            } else if (file_get_contents("./api/status_timestamp") == "&key?") {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("key");
            } else {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("offline");
            }
        }
    }

    if ($command == "getScrollMessage") {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit(file_get_contents("./api/scroll_message"));
    }

    if ($command == "getBackground") {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit(file_get_contents("./api/background_url"));
    }

    if ($command == "pushStatus") {
        file_put_contents("./api/status_timestamp", date('YmdHi') . substr(date('s'), 0, 1));
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");
    }

    if ($command == "updateSnowMode") {
        if (isset($data->value)) {
            if (is_bool($data->value)) {
                if ($data->value) {
                    file_put_contents("./api/snow_mode", "true");
                    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");
                } else {
                    file_put_contents("./api/snow_mode", "false");
                    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");
                }
            } else {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: Expected key /value/ to be boolean, but wasn't that");
            }
        } else {
            require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: Missing key /value/ on data JSON");
        }
    }

    if ($command == "setBackground") {
        if (isset($data->value)) {
            if (is_string($data->value)) {
                file_put_contents("./api/background_url", $data->value);
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");
            } else {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: Expected key /value/ to be string, but wasn't that");
            }
        } else {
            require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: Missing key /value/ on data JSON");
        }
    }

    if ($command == "setScrollMessage") {
        if (isset($data->value)) {
            if (is_string($data->value)) {
                file_put_contents("./api/scroll_message", $data->value);
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");
            } else {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: Expected key /value/ to be string, but wasn't that");
            }
        } else {
            require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: Missing key /value/ on data JSON");
        }
    }

    if ($command == "confirmKey") {
        if (isset($data->value)) {
            if (is_string($data->value)) {
                if ($data->value == file_get_contents("./api/session_key")) {
                    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");
                } else {
                    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("no");
                }
            } else {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: Expected key /value/ to be string, but wasn't that");
            }
        } else {
            require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: Missing key /value/ on data JSON");
        }
    }

    if ($command == "setMessageTitle") {
        if (isset($data->value)) {
            if (is_string($data->value)) {
                file_put_contents("./api/message_title", $data->value);
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");
            } else {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: Expected key /value/ to be string, but wasn't that");
            }
        } else {
            require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: Missing key /value/ on data JSON");
        }
    }

    if ($command == "setMessageText") {
        if (isset($data->value)) {
            if (is_string($data->value)) {
                file_put_contents("./api/message_text", $data->value);
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");
            } else {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: Expected key /value/ to be string, but wasn't that");
            }
        } else {
            require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: Missing key /value/ on data JSON");
        }
    }

    if ($command == "getMessageTitle") {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit(file_get_contents("./api/message_title"));
    }

    if ($command == "getMessageText") {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit(file_get_contents("./api/message_text"));
    }

    if ($command == "getSnowMode") {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit(file_get_contents("./api/snow_mode"));
    }
    
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: Unknown Command");

} else {
    header("HTTP/1.1 403 Forbidden");
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("APIRejection: Non-GET and non-POST request method was received by the server");
}