setInterval(() => {
    console.log("[message] Gathering message title...")
    $.ajax({
        type: "POST",
        url: "./api.php?command=getMessageTitle&data=&key=" + code,
        timeout: 2000,
        success: function (data) {
            console.log("[message] Set message title")
            document.getElementById('message-title').innerHTML = data;
        },
        error: function (error) {
            console.log("[message] Error")
            console.log(error);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}, 10000)

setInterval(() => {
    console.log("[message] Gathering message text...")
    $.ajax({
        type: "POST",
        url: "./api.php?command=getMessageText&data=&key=" + code,
        timeout: 2000,
        success: function (data) {
            console.log("[message] Set message text")
            document.getElementById('message-text').innerHTML = data;
        },
        error: function (error) {
            console.log("[message] Error")
            console.log(error);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}, 10000)