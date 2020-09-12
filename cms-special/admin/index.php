<?php

if (isset($_GET['pr']) || isset($_GET['pa'])) {
    if (isset($_GET['pr']) && !isset($_GET['pa'])) {
        header("Location: /cms-special/admin/login/?pr=" . $_GET['pr']);
    }
    if (!isset($_GET['pr']) && isset($_GET['pa'])) {
        header("Location: /cms-special/admin/login/?pa=" . $_GET['pa']);
    }
    if (isset($_GET['pr']) && isset($_GET['pa'])) {
        header("Location: /cms-special/admin/login/?pr=" . $_GET['pr'] . "&pa=" . $_GET['pa']);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minteck Projects CMS</title>
    <link rel="stylesheet" href="/resources/css/ajax.css">
    <script src="/resources/js/jquery.js"></script>
</head>
<body>
    <iframe id="content" src="/cms-special/admin/login" frameborder="0"></iframe>
    <div id="loader">
        <svg class="spinner" width="48px" height="48px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
            <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
        </svg>
    </div>
</body>

<script>
    function iframeURLChange(iframe, callback) {
        var unloadHandler = function () {
            setTimeout(function () {
                callback(iframe.contentWindow.location.href);
            }, 0);
        };

        function attachUnload() {
            iframe.contentWindow.removeEventListener("unload", unloadHandler);
            iframe.contentWindow.addEventListener("unload", unloadHandler);
        }

        iframe.addEventListener("load", attachUnload);
        attachUnload();
    }

    iframeURLChange(document.getElementById("content"), function (newURL) {
        $("#loader").fadeIn(200);
    });

    document.getElementById('content').onbeforeunload = () => {
        $("#loader").fadeIn(200);
    }

    document.getElementById('content').onload = () => {
        $("#loader").fadeOut(200);

        setTimeout(() => {
            $("#loader").fadeOut(200);
        }, 300)

        els2 = document.getElementById('content').contentWindow.location.href.split("/");

        els2.shift();
        els2.shift();
        els2.shift();

        url = "/" + els2.join("/");
        if (!url.startsWith("/cms-special/admin")) {
            document.getElementById('content').contentWindow.history.back();
            window.open(url);
        }

        els = document.getElementById('content').contentWindow.location.href.split("/");

        els.shift();
        els.shift();
        els.shift();
        els.shift();
        els.shift();
                                                
        oldu = "/" + els.join("/");

        window.history.replaceState("Minteck Projects CMS", "Minteck Projects CMS", "#/" + els.join("/"));
        console.log("/cms-special/admin/" + els.join("/"));

        document.title = document.getElementById('content').contentWindow.document.title;
    }

    oldu = null;
    setInterval(() => {
        hash = location.hash.substr(1);

        if (hash == "" && hash != oldu) {
            document.getElementById('content').src = "/cms-special/admin/home";
            console.log("/cms-special/admin/home");
            $("#loader").fadeIn(200);

            oldu = hash;
        } else if (hash != oldu) {
            if (hash.startsWith("/") && (hash.substr(1, 1) != "/")) {
                document.getElementById('content').src = "/cms-special/admin" + hash;
                console.log("/cms-special/admin" + hash);
                $("#loader").fadeIn(200);
            } else {
                document.getElementById('content').src = "/cms-special/admin/home";
                console.log("/cms-special/admin/home");
                $("#loader").fadeIn(200);
            }

            oldu = hash;
        }
    }, 200)
</script>

</html>