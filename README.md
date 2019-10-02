# Code source de Minteck Projects CMS
Ce projet contient le code source de Minteck Projects CMS, distribué sous licence GNU GPL3.

## Liens
*  [Contrat de licence (en anglais)](LICENSE)
*  [Télécharger une version](https://gitlab.com/minteck-projects/mpcms/code-base/-/tags)

## Le logiciel contient déjà un site
En effet, si vous téléchargez une préversion du logiciel, notre environnement de test reste installé. Vous pouvez, soit :
*  utiliser l'environnement de test : le mot de passe de l'administration est `MPCMS-usr-motdepasse` (le mot de passe par défaut),
*  repartir de zéro en **vidant** *et non en supprimant* les dossier `/data/tokens`, `/data/webcontent`, et `/resources/upload`, ou enfin
*  mettre à jour à partir de votre base de données en suivant ces étapes :
   *  supprimez le dossier `/data` du nouveau site ainsi que son contenu
   *  créez un nouveau dossier `/data` sur le nouveau site
   *  copiez le contenu du dossier `/data` de votre ancien site dans le dossier `/data` du nouveau site *(il devrait y avoir 2 dossiers et 1 fichier : `tokens`, `webcontent`, et `.htaccess`, le fichier [`.htaccess`] peut ne pas être visible selon la configuration de votre système)*
   *  rechargez votre nouveau site
   *  > Notez que si vous rencontrez des problèmes lors de cette manipulation, vous pouvez [créer un nouveau ticket](https://gitlab.com/minteck-projects/mpcms/code-base/issues) sur ce projet.