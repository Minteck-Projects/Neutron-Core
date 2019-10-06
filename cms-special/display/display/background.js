setInterval(() => {
    console.log("[background] Gathering page background...")
    $.ajax({
        type: "POST",
        url: "./api.php?command=getBackground&data=&key=" + code,
        timeout: 2000,
        success: function (data) {
            console.log("[background] Set correct background")
            $('body').css('background-image', 'url("' + data + '")')
        },
        error: function (error) {
            console.log("[background] Error")
            console.log(error);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}, 10000)