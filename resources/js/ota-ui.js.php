/*<?php header("Content-Type: application/javascript");require_once $_SERVER['DOCUMENT_ROOT'] . "/api/lang/processor.php"; ?>*/
setTimeout(() => {
    document.title = '<?= $lang["ota"]["steps"][0] . " - " . $lang["ota"]["ititle"] ?> - Minteck Projects CMS';
    setTimeout(() => {
        switchPage("02-loader", "03-welcome")
        document.title = '<?= $lang["ota"]["steps"][2] . " - " . $lang["ota"]["ititle"] ?> - Minteck Projects CMS';
    }, 1000)
}, 1000)

document.title = '<?= $lang["ota"]["steps"][0] . " - " . $lang["ota"]["ititle"] ?> - Minteck Projects CMS';

function switchPage(from, to) {
    $("#" + from).fadeOut(200);
    setTimeout(() => {
        document.getElementById(from).style.display = "none";
        $("#" + to).fadeIn(200);
        setTimeout(() => {
            $("#" + to).fadeIn(200);
            document.getElementById(to).style.display = "block";
        }, 200)
    }, 200)
}

function checkForUpdates() {
    $.ajax({
        type: "GET",
        dataType: 'text',
        url: "/api/updates/check.php",
        success: function (data) {
            try {
                updates = JSON.parse(data);
                console.log("> Data parse");

                if (updates.error == null) {
                    console.log("> No error");

                    if (updates.updates.length == 0) {
                        setTimeout(() => {
                            switchPage("04-search", "00-uptodate")
                            setTimeout(() => {
                                document.getElementById("04-search").style.display = "none";
                            }, 200)
                            console.log("> Up to date");
                        }, 2000);
                    } else {
                        console.log("> Updates");
                        uphtml = "<ul>";
                        ttsize = 0;
                        updates.updates.forEach((update) => {
                            if (update.type == "security") {
                                uphtml = uphtml + "<li><?= $lang['ota']['updef'][0] ?><?= $lang['ota']['updef'][1] ?><?= $lang['ota']['updef'][3] ?>" + update.target + "</li>";
                            }
                            if (update.type == "feature") {
                                uphtml = uphtml + "<li><?= $lang['ota']['updef'][0] ?><?= $lang['ota']['updef'][2] ?><?= $lang['ota']['updef'][3] ?>" + update.target + "</li>";
                            }
                            ttsize = ttsize + update.size
                        })
                        uphtml = uphtml + "<ul>";

                        document.getElementById('updates-list').innerHTML = uphtml;
                        ttsizestr = "";
                        if (ttsizestr >= 1099511627776) {
                            ttsizestr = Math.round(ttsize / 1099511627776) + " <?= $lang['sizes']['tib'] ?>";
                        }
                        if (ttsize >= 1073741824) {
                            ttsizestr = Math.round(ttsize / 1073741824) + " <?= $lang['sizes']['gib'] ?>";
                        }
                        if (ttsize >= 1048576) {
                            ttsizestr = Math.round(ttsize / 1048576) + " <?= $lang['sizes']['mib'] ?>";
                        }
                        if (ttsize >= 1024) {
                            ttsizestr = Math.round(ttsize / 1024) + " <?= $lang['sizes']['kib'] ?>";
                        }
                        if (ttsize < 1024) {
                            ttsizestr = ttsize + " <?= $lang['sizes']['bytes'] ?>";
                        }
                        document.getElementById('updates-ttsize').innerHTML = ttsizestr;

                        setTimeout(() => {
                            switchPage("04-search", "05-updates")
                        }, 2000);
                    }
                } else {
                    console.log("> PHP Error");
                    document.getElementById('00-error-title').innerHTML = `<?= $lang["ota"]["errors"][0] ?>`
                    document.getElementById('00-error-message').innerHTML = updates.error;
                    document.title = `<?= $lang["setup"]["steps"][1] . " - " . $lang["setup"]["ititle"] ?> - Minteck Projects CMS`;
                    switchPage("04-search", "00-error")
                    window.onbeforeunload = undefined;
                }
            } catch (e) {
                console.log("> JS Error");
                document.getElementById('00-error-title').innerHTML = `<?= $lang["ota"]["errors"][0] ?>`
                document.getElementById('00-error-message').innerHTML = e.message
                document.title = `<?= $lang["setup"]["steps"][1] . " - " . $lang["setup"]["ititle"] ?> - Minteck Projects CMS`;
                switchPage("04-search", "00-error")
                console.error(e);
            }
        },
        error: function () {
            document.title = '<?= $lang["setup"]["steps"][1] . " - " . $lang["setup"]["ititle"] ?> - Minteck Projects CMS';
            document.getElementById('00-error-title').innerHTML = `<?= $lang["setup"]["errors"][1] ?>`
            document.getElementById('00-error-message').innerHTML = `<?= $lang["setup"]["errors"][2] ?>`
            switchPage("04-search", "00-error")
            window.onbeforeunload = undefined;
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function installUpdates() {
    console.log("> Installing updates");
    $.ajax({
        type: "GET",
        dataType: 'text',
        url: "/api/updates/proceed.php",
        success: function (data) {
            if (data == "ok") {
                console.log("> Updates done");
                setTimeout(() => {
                    switchPage("06-install", "07-done")
                }, 3500)
                document.title = '<?= $lang["ota"]["steps"][6] . " - " . $lang["ota"]["ititle"] ?> - Minteck Projects CMS';
            } else {
                console.log("> PHP Error");
                document.getElementById('00-error-title').innerHTML = `<?= $lang["ota"]["errors"][0] ?>`
                document.getElementById('00-error-message').innerHTML = data + "<br><?= $lang['ota']['errors'][2] ?>";
                document.title = `<?= $lang["setup"]["steps"][1] . " - " . $lang["setup"]["ititle"] ?> - Minteck Projects CMS`;
                setTimeout(() => {
                    switchPage("06-install", "00-error")
                }, 2000)
                console.error(e);
            }
        },
        error: function () {
            document.title = '<?= $lang["setup"]["steps"][1] . " - " . $lang["setup"]["ititle"] ?> - Minteck Projects CMS';
            document.getElementById('00-error-title').innerHTML = `<?= $lang["setup"]["errors"][1] ?>`
            document.getElementById('00-error-message').innerHTML = `<?= $lang["setup"]["errors"][2] ?>`
            setTimeout(() => {
                switchPage("06-install", "00-error")
            }, 2000)
            window.onbeforeunload = undefined;
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
