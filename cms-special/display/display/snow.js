// <div id="snowapi-placeholder"><div snowapi-enable-snowfall></div></div>

setInterval(() => {
    console.log("[snowMode] Gathering snow mode status...")
    $.ajax({
        type: "POST",
        url: "./api.php?command=getSnowMode&data=&key=" + code,
        timeout: 2000,
        success: function (data) {
            if (data == "true") {
                console.log("[snowMode] Enabled snow mode")
                if (document.getElementById('snowmode-handler').innerHTML == '<div id="snowapi-placeholder"><div snowapi-enable-snowfall></div></div>') {} else {
                    document.getElementById('snowmode-handler').innerHTML = '<div id="snowapi-placeholder"><div snowapi-enable-snowfall></div></div>';
                }
            } else {
                console.log("[snowMode] Disabled snow mode")
                document.getElementById('snowmode-handler').innerHTML = '';
            }
        },
        error: function (error) {
            console.log("[snowMode] Error")
            console.log(error);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}, 5000)