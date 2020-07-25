<div id="portal-background"></div>
<header id="header-desktop" class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <a title="<?= $lang["admin-home"]["home"] ?>" href="/cms-special/admin/home" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button">home</a>
            <span class="mdc-top-app-bar__title"><?php if (isset($name)) { echo($name); } else { echo($lang["login"]["title"]); } ?></span>
        </section>
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
            <a title="<?= $lang["admin-home"]["search"] ?>" href="/cms-special/admin/home/all/#search" class="material-icons-outlined mdc-top-app-bar__navigation-icon mdc-icon-button">search</a>
        </section>
    </div>
</header>