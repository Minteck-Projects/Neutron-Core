/*<?php header("Content-Type: application/javascript");require_once $_SERVER['DOCUMENT_ROOT'] . "/api/lang/setup.php"; ?>*/
setTimeout(() => {
    switchPage("01-loader", "02-check")
    document.title = '<?= $lang["setup"]["steps"][0] . " - " . $lang["setup"]["ititle"] ?> - ';
    $.ajax({
        url: "/api/setup/check.php",
        dataType: 'html',
        cache: false,
        contentType: false,
        processData: false,
        type: 'get',
        success: function (data) {
            setTimeout(() => {
                if (data != "ok") {
                    document.getElementById('00-error-title').innerHTML = "Environnement incorrect"
                    document.getElementById('00-error-message').innerHTML = data
                    switchPage("02-check", "00-error")
                    document.title = '<?= $lang["setup"]["steps"][1] . " - " . $lang["setup"]["ititle"] ?> - ';
                    window.onbeforeunload = undefined;
                } else {
                    switchPage("02-check", "03-welcome")
                    document.title = '<?= $lang["setup"]["steps"][2] . " - " . $lang["setup"]["ititle"] ?> - ';
                }
            }, 1000)
        }
    })
}, 1000)

function validateName() {
    document.getElementById('04-name-tip').classList.remove('tip-orange')
    document.getElementById('04-name-tip').classList.remove('tip-green')
    document.getElementById('04-name-tip').classList.remove('tip-red')
    document.getElementById('04-name-tip').innerHTML = "...";
    setTimeout(() => {
        name = document.getElementById('04-name-field').value
        if (name.trim() == "") {
            document.getElementById('04-name-tip').classList.add('tip-red')
            document.getElementById('04-name-tip').innerHTML = "<?= $lang['setup']['sitename'][0] ?>";
            return;
        }
        if (name.includes("<") || name.includes(">") || name.includes("#") || name.includes("@") || name.includes("}") || name.includes("{") || name.includes("|")) {
            document.getElementById('04-name-tip').classList.add('tip-red')
            document.getElementById('04-name-tip').innerHTML = "<?= $lang['setup']['sitename'][1] ?>";
            return;
        }
        if (name.length > 75) {
            document.getElementById('04-name-tip').classList.add('tip-red')
            document.getElementById('04-name-tip').innerHTML = "<?= $lang['setup']['sitename'][2] ?>";
            return;
        }
        if (name.length < 4) {
            document.getElementById('04-name-tip').classList.add('tip-orange')
            document.getElementById('04-name-tip').innerHTML = "<?= $lang['setup']['sitename'][3] ?>";
            return;
        }
        if (name.length > 30) {
            document.getElementById('04-name-tip').classList.add('tip-orange')
            document.getElementById('04-name-tip').innerHTML = "<?= $lang['setup']['sitename'][4] ?>";
            return;
        }
        document.getElementById('04-name-tip').classList.add('tip-green')
        document.getElementById('04-name-tip').innerHTML = "<?= $lang['setup']['sitename'][5] ?>";
        return;
    }, 100)
}

function Name_ChangeIfOk() {
    name = document.getElementById('04-name-field').value
    if (name.trim() == "" || name.includes("<") || name.includes(">") || name.includes("#") || name.includes("@") || name.includes("}") || name.includes("{") || name.includes("|") || name.length > 75) {return;}
    switchPage("04-name", "05-icon")
    document.title = '<?= $lang["setup"]["steps"][3] . " - " . $lang["setup"]["ititle"] ?> - ';
}

function Icon_UploadFile() {
    $("#05-icon-file").trigger('click');
    Icon_Validate()
}

function Icon_Validate() {
    if (document.getElementById('05-icon-file').value != "") {
        document.getElementById('05-icon-img').src = "/resources/image/config_file_replace.svg"
    } else {
        document.getElementById('05-icon-img').src = "/resources/image/config_file_import.svg"
    }
}

function Icon_Validate_Delayed() {
    setTimeout(() => {
        if (document.getElementById('05-icon-file').value != "") {
            document.getElementById('05-icon-img').src = "/resources/image/config_file_replace.svg"
        } else {
            document.getElementById('05-icon-img').src = "/resources/image/config_file_import.svg"
        }
    }, 1000)
}

document.getElementById('04-name-field').value = ""
document.getElementById('05-icon-file').value = ""
setInterval(Icon_Validate, 100)

function upload() {
    document.title = '<?= $lang["setup"]["steps"][4] . " - " . $lang["setup"]["ititle"] ?> - ';
    switchPage("07-finish", "08-checking")
    setTimeout(() => {
        switchPage("08-checking", "09-uploading")
        var formData = new FormData();
        if (document.getElementById('05-icon-file').value.trim() != "") {
            formData.append("file", document.getElementById('05-icon-file').files[0], document.getElementById('05-icon-file').files[0].name);
        }
        formData.append("upload_file", true);
        formData.append("sitename", document.getElementById('04-name-field').value);
        formData.append("language", lang);
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/setup/push.php",
            success: function (data) {
                if (data == "ok") {
                    setTimeout(() => {
                        switchPage("09-uploading", "10-summing")
                        setTimeout(() => {
                            switchPage("10-summing", "11-performance")
                            setTimeout(() => {
                                switchPage("11-performance", "12-done")
                                document.title = '<?= $lang["setup"]["steps"][5] . " - " . $lang["setup"]["ititle"] ?> - ';
                                window.onbeforeunload = undefined;
                            }, 3000)
                        }, 2000)
                    }, 3000)
                } else {
                    document.getElementById('00-error-title').innerHTML = `<?= $lang["setup"]["errors"][0] ?>`
                    document.getElementById('00-error-message').innerHTML = data
                    document.title = `<?= $lang["setup"]["steps"][1] . " - " . $lang["setup"]["ititle"] ?> - `;
                    switchPage("09-uploading", "00-error")
                    window.onbeforeunload = undefined;
                }
            },
            error: function (error) {
                document.title = '<?= $lang["setup"]["steps"][1] . " - " . $lang["setup"]["ititle"] ?> - ';
                document.getElementById('00-error-title').innerHTML = `<?= $lang["setup"]["errors"][1] ?>`
                document.getElementById('00-error-message').innerHTML = `<?= $lang["setup"]["errors"][2] ?>`
                switchPage("02-check", "00-error")
                window.onbeforeunload = undefined;
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
    }, 1000)
}

document.title = '<?= $lang["setup"]["steps"][6] . " - " . $lang["setup"]["ititle"] ?> - ';

function switchPage(from, to) {
    $("#" + from).fadeOut(200);
    setTimeout(() => {
        $("#" + to).fadeIn(200);
    }, 200)
}