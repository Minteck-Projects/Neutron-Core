window.onerror = function(msg, url, line, col, error) {
    if (msg == "ResizeObserver loop completed with undelivered notifications.") {
        return;
    }
    if (typeof line != "undefined") {
        if (typeof col != "undefined") {
            linecol = "at line " + line + " and column " + col
        } else {
            linecol = "at line " + line
        }
    }
    alert_full("Sorry, a runtime error ocurred on this page:\n" + msg + "\n\nThe error is from " + url + "\n" + linecol + "\n\nWe suggest that you submit a bug report on FNS Neutron's website and include above information.");
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