window.onerror = function(msg, url, line, col, error) {
    if (typeof line != "undefined") {
        if (typeof col != "undefined") {
            linecol = "à la ligne " + line + " et au caractère " + col
        } else {
            linecol = "à la ligne " + line
        }
    }
    alert_full("Nous sommes désolés, mais une erreur s'est produite lors de l'exécution du code sur cette page :\n" + msg + "\n\nL'erreur provient du fichier " + url + "\n" + linecol + "\n\nNous vous conseillons de publier un rapport de bogue sur le site de Minteck Projects CMS et inclure les informations ci-dessus.");
};