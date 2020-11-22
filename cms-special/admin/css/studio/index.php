<?php $pageConfig = [ "domName" => "Personnalisation en cours - Styles personnalisés", "headerName" => "Concentrez-vous sur la personnalisation de votre site" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
    <div style="text-align: center;"><p><a onclick="publishCss()" class="button"><?= $lang["admin-css-studio"]["publish"] ?></a></p></div>
    <div id="easycss-main"></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>

<script src="/api/easycss/src/easycss.js" type="application/javascript" charset="utf-8"></script>
<script src="/api/easycss/language/<?= $langsel ?>.js" type="application/javascript" charset="utf-8"></script>

<script>
    ecss = new EasyCSS.css({
        lang: "<?= $langsel ?>",
        wrapper: "#easycss-main",
        verbose: false,
        theme: "next-dark",
        themeImportPath: "/api/easycss/themes",
        ctypes: [
            {
               name: "WATERMARK",
               localized_name: {
                   <?= $langsel ?>: "<?= $lang["admin-css-studio"]["elements"][0] ?>"
               },
               selector: "#siteadmin"
            },
            {
               name: "MENUBAR",
               localized_name: {
                   <?= $langsel ?>: "<?= $lang["admin-css-studio"]["elements"][1] ?>"
               },
               selector: "#menubar"
            },
            {
               name: "BANNER",
               localized_name: {
                   <?= $langsel ?>: "<?= $lang["admin-css-studio"]["elements"][2] ?>"
               },
               selector: "#banner"
            },
            {
               name: "WIDGETS_BAR",
               localized_name: {
                   <?= $langsel ?>: "<?= $lang["admin-css-studio"]["elements"][3] ?>"
               },
               selector: "#sidebar-widgets"
            },
            {
               name: "PAGE_CONTENT",
               localized_name: {
                   <?= $langsel ?>: "<?= $lang["admin-css-studio"]["elements"][4] ?>"
               },
               selector: "#page-content"
            },
            {
               name: "FOOTER",
               localized_name: {
                   <?= $langsel ?>: "<?= $lang["admin-css-studio"]["elements"][5] ?>"
               },
               selector: "#page-footer"
            },
            {
               name: "ADMIN_DRAWER",
               localized_name: {
                   <?= $langsel ?>: "<?= $lang["admin-css-studio"]["elements"][6] ?>"
               },
               selector: ".mdc-drawer"
            },
            {
               name: "ADMIN_MENUBAR",
               localized_name: {
                   <?= $langsel ?>: "<?= $lang["admin-css-studio"]["elements"][7] ?>"
               },
               selector: "header#header-desktop, header#header-mobile"
            },
            {
               name: "ADMIN_CONTENT",
               localized_name: {
                   <?= $langsel ?>: "<?= $lang["admin-css-studio"]["elements"][8] ?>"
               },
               selector: "main#main-content.main-content"
            },
            {
               name: "ADMIN_LINK",
               localized_name: {
                   <?= $langsel ?>: "<?= $lang["admin-css-studio"]["elements"][9] ?>"
               },
               selector: ".sblink"
            },
        ]
    })

    EasyCSS.loadJsonInput(Object.keys(EasyCSS.sessions)[0], "<?= str_replace("\"", "\\\"", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/styles.json")) ?>")

    function publishCss() {        
        session = Object.keys(EasyCSS.sessions)[0];
        css = EasyCSS.getCssOutput(session);
        json = EasyCSS.getJsonOutput(session);

        var formData = new FormData();
        formData.append("css", css);
        formData.append("json", json);
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/css_publish_changes.php",
            success: function (data) {
                if (data == "ok") {
                    alert("<?= $lang["admin-css-studio"]["saved"] ?>");
                } else {
                    alert("<?= $lang["admin-errors"]["errorprefix"] ?>" + data)
                }
            },
            error: function (error) {
                alert("<?= $lang["admin-errors"]["connerror"] ?>")
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
    }
</script>