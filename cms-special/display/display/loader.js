window.onload = () => {
    document.getElementById('loader-anim').classList.add('o0-after')
    setTimeout(() => {
        $('#loader').fadeOut(5000)
    }, 2500)
}
