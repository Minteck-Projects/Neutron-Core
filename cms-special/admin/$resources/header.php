<header id="header-desktop" class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <span class="mdc-top-app-bar__title"><?php if (isset($name)) { echo($name); } else { echo($lang["login"]["title"]); } ?></span>
        </section>
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
            <a title="<?= $lang["admin-home"]["language"] ?> — Change website language" href="/cms-special/admin/language" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button">translate</a>
        </section>
    </div>
</header>

<header id="header-mobile" class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <a onclick="pushbar.open('drawer');" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button">menu</a>
            <a href="/cms-special/admin/home"><span class="mdc-top-app-bar__title"><?php if (isset($name)) { echo($name); } else { echo($lang["login"]["title"]); } ?></span></a>
        </section>
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
            <a title="<?= $lang["admin-home"]["language"] ?> — Change website language" href="/cms-special/admin/language" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button">translate</a>
        </section>
    </div>
</header>