<?php

$db = json_decode(file_get_contents("./db.json"));

$pageConfig = [ "domName" => "Tableau de bord", "headerName" => "Tableau de bord" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
<center>
    <a href="/cms-special/admin/home" class="mdc-button mdc-button--outlined">
        <div class="mdc-button__ripple"></div>
        <i class="material-icons-outlined mdc-button__icon" aria-hidden="true">arrow_back</i>
        <span class="mdc-button__label"><?= $lang["admin-home"]["items"][7] ?></span>
    </a>

    <h1><?= $lang["admin-home"]["all"] ?></h1>

    <div class="nd_Field nd_Field_input" id="searchbox">
        <input onchange="refreshSearch()" onkeyup="refreshSearch()" onkeydown="refreshSearch()" id="search" name="search" type="text" placeholder="<?= $lang["admin-home"]["find"] ?>" spellcheck="false" 
autocomplete="off">
        <label for="search">
            <?= $lang["admin-home"]["find"] ?>
        </label>
	</div>

    <div class="mdc-list-group">
        <?php foreach ($db as $group): ?>
        <h3 class="mdc-list-group__subheader sq-header"><?= $lang["admin-home"]["categories"][$group->id] ?></h3>
        <ul class="mdc-list">
            <?php foreach ($group->items as $item): ?>
            <li class="mdc-list-item sq-list" tabindex="0">
                <span class="mdc-list-item__ripple"></span>
                <a href="/cms-special/admin/<?= $item->page ?>" class="mdc-list-item__text all-item-link">
                    <i class="material-icons-outlined all-item-icon" aria-hidden="false"><?= $item->icon ?></i>
                    <span class="all-item-text"><?= $lang["admin-home"]["allitems"][$item->id] ?></span>
                </a>
            </li>
            <?php endforeach ?>
        </ul>
        <?php endforeach ?>
    </div>
</center>
<script>

function results(query) {
    els = [];
    Array.from(document.getElementsByClassName('all-item-text')).forEach((e) => {
        els.push(e.innerHTML)
    })
    htmls = Array.from(document.getElementsByClassName('all-item-text'))
  
    matches = [];
    htmlmatches = [];
    els.forEach((e, i) => {
        if (e.trim().includes(query.trim())) {
            ne = e.split('<span class="search-match">').join('').split('</span>').join('')
            matches.push(ne);
            htmls[i].innerHTML = ne;
            htmlmatches.push(htmls[i]);
        }
    })
  
    elmatches = [];
    htmlmatches.forEach((e) => {
        elmatches.push(e.parentElement.parentElement);
    });
  
    smatches = [];
    matches.forEach((e) => {
        smatches.push(e.split(query).join("<span class=\"search-match\">" + query + "</span>"))
    })
  
    amatches = [];
    matches.forEach((_e, i) => {
        amatches.push(
    	    {
      	        text: matches[i],
                style: smatches[i],
                dom: {
                    text: htmlmatches[i],
                    element: elmatches[i]
                },
    	    }
        )
    })

    return amatches;
}

function hideAll() {
    Array.from(document.getElementsByClassName('sq-list')).forEach((e) => {
        e.style.display = "none";
    })
    
    Array.from(document.getElementsByClassName('sq-header')).forEach((e) => {
        e.style.display = "none";
    })
}

function showAll() {
    Array.from(document.getElementsByClassName('sq-list')).forEach((e) => {
        e.style.display = "";
        e.children[1].children[1].innerHTML = e.children[1].children[1].innerHTML.split('<span class="search-match">').join('').split('</span>').join('');
    })
    
    Array.from(document.getElementsByClassName('sq-header')).forEach((e) => {
        e.style.display = "";
    })
}

function areAllHidden() {
    stat = true;
  
    Array.from(document.getElementsByClassName('sq-list')).forEach((e) => {
        if (e.style.display != "none") {
            stat = false;
        };
    })
    
    Array.from(document.getElementsByClassName('sq-header')).forEach((e) => {
        if (e.style.display != "none") {
            stat = false;
        };
    })
  
    return stat;
}

function refreshSearch() {
    q = document.getElementById('search').value;
    
    if (q.trim() == "" || q.trim() == ".") {
        showAll();
        document.getElementById('search').labels[0].innerHTML = "<?= $lang["admin-home"]["find"] ?>";
    } else {
        hideAll();

        Array.from(document.getElementsByClassName('sq-list')).forEach((e) => {
            e.children[1].children[1].innerHTML = e.children[1].children[1].innerHTML.split('<span class="search-match">').join('').split('</span>').join('');
        })

        found = results(q);
        count = found.length;

        if (count > 1) {
            document.getElementById('search').labels[0].innerHTML = count + "<?= $lang["admin-home"]["multiple"] ?>";
        } else if (count > 0) {
            document.getElementById('search').labels[0].innerHTML = "<?= $lang["admin-home"]["one"] ?>";
        } else {
            document.getElementById('search').labels[0].innerHTML = "<?= $lang["admin-home"]["nofound"] ?>";
        }

        found.forEach((e) => {
            e.dom.text.innerHTML = e.style;
            e.dom.element.style.display = "";
        })
    }
}

</script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>