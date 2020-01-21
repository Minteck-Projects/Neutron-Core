<?php $pageConfig = [ "domName" => "Ajouter un événement - Calendrier", "headerName" => "Ajouter un événement" ]; include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
        <div id="datainput">
            <h3>Date</h3>
            <ul>
                <li>Jour : </li>
                <select id="day">
                    <option value="01" <?php if ("01" == date('d')) {echo("selected");} ?>>1er</option>
                    <option value="02" <?php if ("02" == date('d')) {echo("selected");} ?>>2</option>
                    <option value="03" <?php if ("03" == date('d')) {echo("selected");} ?>>3</option>
                    <option value="04" <?php if ("04" == date('d')) {echo("selected");} ?>>4</option>
                    <option value="05" <?php if ("05" == date('d')) {echo("selected");} ?>>5</option>
                    <option value="06" <?php if ("06" == date('d')) {echo("selected");} ?>>6</option>
                    <option value="07" <?php if ("07" == date('d')) {echo("selected");} ?>>7</option>
                    <option value="08" <?php if ("08" == date('d')) {echo("selected");} ?>>8</option>
                    <option value="09" <?php if ("09" == date('d')) {echo("selected");} ?>>9</option>
                    <option value="10" <?php if ("10" == date('d')) {echo("selected");} ?>>10</option>
                    <option value="11" <?php if ("11" == date('d')) {echo("selected");} ?>>11</option>
                    <option value="12" <?php if ("12" == date('d')) {echo("selected");} ?>>12</option>
                    <option value="13" <?php if ("13" == date('d')) {echo("selected");} ?>>13</option>
                    <option value="14" <?php if ("14" == date('d')) {echo("selected");} ?>>14</option>
                    <option value="15" <?php if ("15" == date('d')) {echo("selected");} ?>>15</option>
                    <option value="16" <?php if ("16" == date('d')) {echo("selected");} ?>>16</option>
                    <option value="17" <?php if ("17" == date('d')) {echo("selected");} ?>>17</option>
                    <option value="18" <?php if ("18" == date('d')) {echo("selected");} ?>>18</option>
                    <option value="19" <?php if ("19" == date('d')) {echo("selected");} ?>>19</option>
                    <option value="20" <?php if ("20" == date('d')) {echo("selected");} ?>>20</option>
                    <option value="21" <?php if ("21" == date('d')) {echo("selected");} ?>>21</option>
                    <option value="22" <?php if ("22" == date('d')) {echo("selected");} ?>>22</option>
                    <option value="23" <?php if ("23" == date('d')) {echo("selected");} ?>>23</option>
                    <option value="24" <?php if ("24" == date('d')) {echo("selected");} ?>>24</option>
                    <option value="25" <?php if ("25" == date('d')) {echo("selected");} ?>>25</option>
                    <option value="26" <?php if ("26" == date('d')) {echo("selected");} ?>>26</option>
                    <option value="27" <?php if ("27" == date('d')) {echo("selected");} ?>>27</option>
                    <option value="28" <?php if ("28" == date('d')) {echo("selected");} ?>>28</option>
                    <option value="29" <?php if ("29" == date('d')) {echo("selected");} ?>>29</option>
                    <option value="30" <?php if ("30" == date('d')) {echo("selected");} ?>>30</option>
                    <option value="31" <?php if ("31" == date('d')) {echo("selected");} ?>>31</option>
                </select><br><br>
                <li>Mois : </li>
                <select id="month">
                    <option disabled>1er trimestre</option>
                    <option value="1" <?php if ("01" == date('m')) {echo("selected");} ?>>Janvier</option>
                    <option value="2" <?php if ("02" == date('m')) {echo("selected");} ?>>Février</option>
                    <option value="3" <?php if ("03" == date('m')) {echo("selected");} ?>>Mars</option>
                    <option disabled>2ème trimestre</option>
                    <option value="4" <?php if ("04" == date('m')) {echo("selected");} ?>>Avril</option>
                    <option value="5" <?php if ("05" == date('m')) {echo("selected");} ?>>Mai</option>
                    <option value="6" <?php if ("06" == date('m')) {echo("selected");} ?>>Juin</option>
                    <option disabled>3ème trimestre</option>
                    <option value="7" <?php if ("07" == date('m')) {echo("selected");} ?>>Juillet</option>
                    <option value="8" <?php if ("08" == date('m')) {echo("selected");} ?>>Août</option>
                    <option value="9" <?php if ("09" == date('m')) {echo("selected");} ?>>Septembre</option>
                    <option disabled>4ème trimestre</option>
                    <option value="10" <?php if ("10" == date('m')) {echo("selected");} ?>>Octobre</option>
                    <option value="11" <?php if ("11" == date('m')) {echo("selected");} ?>>Novembre</option>
                    <option value="12" <?php if ("12" == date('m')) {echo("selected");} ?>>Décembre</option>
                </select><br><br>
                <li>Année :</li>
                <select id="year">
                    <option value="<?= date('Y') ?>" selected><?= date('Y') ?></option>
                    <option value="<?= date('Y') + 1 ?>"><?= date('Y') + 1 ?></option>
                    <option value="<?= date('Y') + 2 ?>"><?= date('Y') + 2 ?></option>
                    <option value="<?= date('Y') + 3 ?>"><?= date('Y') + 3 ?></option>
                    <option value="<?= date('Y') + 4 ?>"><?= date('Y') + 4 ?></option>
                    <option value="<?= date('Y') + 5 ?>"><?= date('Y') + 5 ?></option>
                </select>
            </ul>
            <h3>Informations</h3>
            <ul>
                <li>Nom de l'événement :</li>
                <input type="text" placeholder="Nom de l'événement" id="name"><br><br>
                <li>Description <i>(facultatif)</i> :</li>
                <input type="text" placeholder="Description" id="desc"><br><br>
                <li>Adresse du lien <i>(facultatif)</i> :</li>
                <input onchange="validateUrl()" onkeyup="validateUrl()" onkeydown="validateUrl()" type="text" placeholder="Lien externe" id="link"><img id="link_check" src="/resources/image/storeloader.svg" style="vertical-align:middle;" class="hide" width="24px" height="24px"><a class="hide" id="link_invalid" title="L'adresse du lien est invalide"><img src="/resources/image/close.svg" style="vertical-align:middle;" class="invert" width="24px" height="24px"></a>
            </ul>
            <p><table class="message_info"><tbody><tr><td><img src="/resources/image/message_info.svg" class="message_img"></td><td style="width:100%;"><p>La description de l'événement s'affichera entièrement sur le widget "Prochains événements", nous vous conseillons donc de ne pas écrire une description trop longue</p></td></tr></tbody></table></p>
            <center><p><a class="button" onclick="createCmsEvent()">Ajouter l'événement</a></p></center><br>
        </div>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script>

function UrlRegex(str) {
  var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
    '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
    '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
    '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
  return !!pattern.test(str);
}

function validateUrl() {
    document.getElementById('link_invalid').classList.add('hide');
    document.getElementById('link_check').classList.remove('hide');
    setTimeout(() => {
        if (!UrlRegex(document.getElementById('link').value)) {
            document.getElementById('link_invalid').classList.remove('hide');
        } else {
            document.getElementById('link_invalid').classList.add('hide');
        }
        document.getElementById('link_check').classList.add('hide');
    }, 2000)
}

function createCmsEvent() {
    document.getElementById('datainput').classList.add('hide')
    var formData = new FormData();
    formData.append("day", document.getElementById('day').value);
    formData.append("month", document.getElementById('month').value);
    formData.append("year", document.getElementById('year').value);
    formData.append("name", document.getElementById('name').value);
    formData.append("desc", document.getElementById('desc').value);
    formData.append("link", document.getElementById('link').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/calendar_create.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/calendar";
            } else {
                alert("Erreur : " + data + "\n\nLa base de données du calendrier est peut être corrompue")
                document.getElementById('datainput').classList.remove('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication\n\nRien a été modifié dans le calendrier")
            document.getElementById('datainput').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>