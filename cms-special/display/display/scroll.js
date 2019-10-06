setInterval(() => {
    console.log("[scrollMessage] Gathering latest Scroll Message...")
    $.ajax({
        type: "POST",
        url: "./api.php?command=getScrollMessage&data=&key=" + code,
        timeout: 2000,
        success: function (data) {
            console.log("[scrollMessage] Set latest Scroll Message")
            document.getElementById('scrolltext').innerHTML = data;
        },
        error: function (error) {
            console.log("[scrollMessage] Error")
            console.log(error);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}, 5000)