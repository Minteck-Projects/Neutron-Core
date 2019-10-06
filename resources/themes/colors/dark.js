// setInterval(() => {
//     try{$('.ck.ck-content.ck-editor__editable.ck-rounded-corners.ck-editor__editable_inline.ck-blurred').css('background', '#4a4a4a')}catch(err){}
// }, 1)
if (location.pathname.startsWith("/cms-special/admin/") && !location.pathname.startsWith("/cms-special/admin/home") && !location.pathname == "/cms-special/admin/" && !location.pathname == "/cms-special/admin/index.php" && !location.pathname == "/cms-special/admin/index.php/" && !location.pathname == "/cms-special/admin") {
    $('document').ready(() => {
        $('body').css('background-color', '#4a4a4a')
        $('body').css('min-height', '100%')
        $('html').css('min-height', '100%')
    })
}