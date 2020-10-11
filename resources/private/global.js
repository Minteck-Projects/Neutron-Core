window.onerror = function(msg, url, line, col, error) {
    if (msg == "ResizeObserver loop completed with undelivered notifications.") {
        return;
    }
    if (typeof line != "undefined") {
        if (typeof col != "undefined") {
            linecol = "à la ligne " + line + " et au caractère " + col
        } else {
            linecol = "à la ligne " + line
        }
    }
    alert_full("Nous sommes désolés, mais une erreur s'est produite lors de l'exécution du code sur cette page :\n" + msg + "\n\nL'erreur provient du fichier " + url + "\n" + linecol + "\n\nNous vous conseillons de publier un rapport de bogue sur le site de  et inclure les informations ci-dessus.");
};

// New Ajax Lazy Loader
location.reloadLegacy = location.reload;
reloadPage = () => { location.reload() };
ajaxPageReload = () => {
    try {
        document.title = "...";
        $('body').fadeOut(200);
        $.ajax({
            type: "GET",
            dataType: 'html',
            url: location.href,
            success: function (data) {
                document.getElementsByTagName('html')[0].innerHTML = data + "<style>body{display:none;}</style>";
                setTimeout(() => {
                    $('body').fadeIn(200);
                }, 500)
            },
            error: function (error) {
                location.reloadLegacy();
            },
            cache: false,
            contentType: false,
            processData: false
        });
    } catch (err) {
        location.reloadLegacy();
    }
}
switchToPage = (url) => {
    try {
        let stateObj = {
            foo: ".",
        };
        document.title = "...";
        history.pushState(stateObj, "page 2", "#/loading");
        $('body').fadeOut(200);
        $.ajax({
            type: "GET",
            dataType: 'html',
            url: url,
            success: function (data) {
                document.getElementsByTagName('html')[0].innerHTML = data + "<style>body{display:none;}</style>";
                Array.from(document.getElementsByTagName('script')).forEach((el) => {
                    if (el.src.trim() == "") {
                        eval(el.innerHTML);
                    }
                });
                if (location.pathname.startsWith("/cms-special/admin")) {
                    $.ajax({
                        type: "GET",
                        dataType: 'html',
                        url: "/cms-special/admin/$resources/admin.js",
                        success: function (data) {
                            eval(data);
                        },
                        error: function (error) {
                            console.error("Unable to load script at " + "/cms-special/admin/$resources/admin.js");
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
                setTimeout(() => {
                    $('body').fadeIn(200);
                    history.pushState(stateObj, "page 2", url);
                }, 500)
            },
            error: function (error) {
                console.log(error);
                location.href = url;
            },
            cache: false,
            contentType: false,
            processData: false
        });
    } catch (err) {
        console.log(err);
        location.href = url;
    }
}