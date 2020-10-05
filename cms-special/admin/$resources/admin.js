window.onscroll = () => {
    // console.log("> Scroll");
    if (window.scrollY >= 52 && !document.getElementById('portal-background').classList.contains('scrolled')) {
        // console.log("> ADD");
        document.getElementById('portal-background').classList.add('scrolled');
    } else if (window.scrollY < 52 && document.getElementById('portal-background').classList.contains('scrolled')) {
        // console.log("> REMOVE");
        document.getElementById('portal-background').classList.remove('scrolled');
    } else {
        // console.log("> Nothing");
    }
}

window.onbeforeunload = () => {
    window.parent.$("#loader").fadeIn(200);
}