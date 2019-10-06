setInterval(() => {
    console.log("[watchdog] Try getting status...")
    $.ajax({
        type: "POST",
        url: "./api.php?command=getStatus&data=&key=" + code,
        timeout: 5000,
        success: function (data) {
            if (data == "ok") {
                console.log("[watchdog] Status OK")
                $('#slow').fadeOut(500)
                $('#connection').fadeOut(500)
                $('#connect').fadeOut(500)
                $('#welcome').fadeOut(500)
                setTimeout(() => {
                    document.getElementById('welcome').classList.add('hide')
                })
                $('#code').fadeOut(500)
            } else if (data == "key") {
                console.log("[watchdog] Status asking key")
                if (document.getElementById('welcome').classList.contains("hide")) {
                    $('#connect').fadeIn(500)
                } else {
                    $('#code').fadeIn(500)
                }
            } else {
                console.log("[watchdog] Status offline")
                $('#connect').fadeOut(500)
                $('#connection').fadeOut(500)
                $('#connection').fadeIn(500)
                $('#slow').fadeOut(500)
            }
        },
        error: function (error) {
            console.log("[watchdog] Error")
            console.log(error);
            $('#connection').fadeOut(500)
            $('#slow').fadeOut(500)
            $('#connect').fadeOut(500)
            $('#slow').fadeOut(500)
        },
        cache: false,
        contentType: false,
        processData: false
    });
}, 7500)

$('body').css('background-image', 'url("/resources/image/error.jpg")')

$.ajax({
    type: "POST",
    url: "./api.php?command=getStatus&data=&key=" + code,
    success: function (data) {
        if (data == "ok") {
            console.log("[conntest] Status OK")
            document.getElementById('slow').classList.add('hide')
            document.getElementById('connection').classList.add('hide')
        } else {
            console.log("[conntest] Status offline")
            document.getElementById('welcome').classList.remove('hide')
        }
    },
    error: function (error) {
        console.log("[conntest] Error")
        console.log(error);
        document.getElementById('starterror').classList.remove('hide')
    },
    cache: false,
    contentType: false,
    processData: false
});
