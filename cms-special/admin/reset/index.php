<?php $pageConfig = [ "domName" => "Réinitialisation - Maintenance", "headerName" => "Réinitialisation" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <div id="page-confirm">
            <center><p><?= $lang["admin-housekeeping"]["disclaimer"][0] ?><ul><li><?= $lang["admin-housekeeping"]["disclaimer"][1] ?></li><li><?= $lang["admin-housekeeping"]["disclaimer"][2] ?></li><li><?= $lang["admin-housekeeping"]["disclaimer"][3] ?></li><li><?= $lang["admin-housekeeping"]["disclaimer"][4] ?></li></ul></p>
            <p><b><?= $lang["admin-housekeeping"]["confirm"] ?></b></p><input id="confirm" onkeyup="validate()" onkeydown="validate()" onchange="validate()" type="text" placeholder="<?= $lang["admin-housekeeping"]["confirmboxph"] ?>"></center>
            <p><center><a onclick="confirmPass()" id="reset-confirm" class="hide button-dangerous"><?= $lang["admin-housekeeping"]["confirmbutton"] ?></a></center></p>
        </div>
        <div id="page-select" class="hide">
            <?= $lang["admin-housekeeping"]["select"][0] ?>
            <p><table class="message_warning"><tbody><tr><td><img src="/resources/image/message_warning.svg" class="message_img"></td><td style="width:100%;"><p><?= $lang["admin-housekeeping"]["select"][1] ?></p></td></tr></tbody></table></p>
            <div class="reset-option" onclick="resetKeep()">
                <b><?= $lang["admin-housekeeping"]["select"][2] ?></b>
                <p><?= $lang["admin-housekeeping"]["select"][3] ?></p>
            </div>
            <div class="reset-option" onclick="resetClear()">
                <b><?= $lang["admin-housekeeping"]["select"][4] ?></b>
                <p><?= $lang["admin-housekeeping"]["select"][5] ?></p>
            </div>
        </div>
    </div>
    <div class="hide" id="resetbox-placeholder">
        <div id="resetbox" class="centered">
            <p><?= $lang["admin-housekeeping"]["select"][6] ?></p>
            <div id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
            <p><small><?= $lang["admin-housekeeping"]["select"][7] ?><br><span id="reset-message">-</span></small></p>
        </div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function resetKeep() {
    document.getElementById('reset-message').innerHTML = "<?= $lang["admin-housekeeping"]["select"][2] ?>"
    progressbox(true)
    var formData = new FormData();
    formData.append("keep", "1");
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/reset.php",
        success: function (data) {
            if (data == "ok") {
                window.parent.location.href = "/cms-special/admin/resetted";
            } else {
                alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data + "\n\n<?= $lang["admin-errors"]["housekeeping"][0] ?>")
                Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
                progressbox(false)
            }
        },
        error: function (error) {
            alert("<?= $lang["admin-errors"]["connerror"] ?>\n\n<?= $lang["admin-errors"]["housekeeping"][1] ?>")
            progressbox(false)
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function resetClear() {
    document.getElementById('reset-message').innerHTML = "<?= $lang["admin-housekeeping"]["select"][4] ?>"
    progressbox(true)
    var formData = new FormData();
    formData.append("keep", "0");
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/reset.php",
        success: function (data) {
            if (data == "ok") {
                window.parent.location.href = "/cms-special/admin/resetted";
            } else {
                alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data + "\n\n<?= $lang["admin-errors"]["housekeeping"][0] ?>")
                Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
                progressbox(false)
            }
        },
        error: function (error) {
            alert("<?= $lang["admin-errors"]["connerror"] ?>\n\n<?= $lang["admin-errors"]["housekeeping"][1] ?>")
            progressbox(false)
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function progressbox(toggle) {
    if (typeof toggle != "boolean") {
        throw new TypeError("Argument 1 expected to be boolean, " + typeof toggle + " given")
    } else {
        if (toggle) {
            $('#resetbox-placeholder').fadeIn(200)
            document.getElementById('settings').classList.add('blurred')
        } else {
            $('#resetbox-placeholder').fadeOut(200)
            document.getElementById('settings').classList.remove('blurred')
        }
    }
}

function confirmPass() {
    document.getElementById('page-confirm').classList.add('hide')
    document.getElementById('page-select').classList.remove('hide')
}

function validate() {
    if (document.getElementById('confirm').value == "<?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename") ?>") {
        document.getElementById('reset-confirm').classList.remove('hide')
    } else {
        document.getElementById('reset-confirm').classList.add('hide')
    }
}

document.getElementById('confirm').value = ""

</script>