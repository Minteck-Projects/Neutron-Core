<header id="header-desktop" class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <span class="mdc-top-app-bar__title"><?php if (isset($name)) { echo($name); } else { echo("Administration du site"); } ?></span>
        </section>
    </div>
</header>

<header id="header-mobile" class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <a onclick="pushbar.open('drawer');" class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button">menu</a>
            <a href="/cms-special/admin/home"><span class="mdc-top-app-bar__title"><?php if (isset($name)) { echo($name); } else { echo("Administration du site"); } ?></span></a>
        </section>
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
        </section>
    </div>
</header>