**<a href="http://bugs.minteck-projects.rf.gd">Minteck Projects Bugs</a>** remplace maintenant le système de tickets de **GitLab**.<br>
Pour continuer à signaler des bugs, vous devez vous créer un compte sur Minteck Projects Bugs.
<hr>

# Code source de FNS Neutron

Ce projet contient le code source de FNS Neutron, distribué sous licence GNU GPL3.

## Liens
*  [Contrat de licence (en anglais)](LICENSE)
*  [Règles de contribution](CONTRIBUTING.md)
*  [Télécharger une version](https://gitlab.com/minteck-projects/mpcms/code-base/-/tags)

## Installation

### Serveur privé (Debian et dérivés)

Exécutez les commandes suivantes dans un terminal de commandes de type `bash` en tant que super-utilisateur (`root`).
```shell
apt-get update # Rechercher des mises à jour
apt-get upgrade # Installer des mises à jour
apt-get install apache2 php php-gd curl wget tar # Installer les logiciels requis (Apache et la dernière version de PHP, la librairie GD2, et quelques utilitaires pour le téléchargement)
wget https://gitlab.com/minteck-projects/mpcms/code-base/-/archive/$(curl https://gitlab.com/minteck-projects/mpcms/changelog/raw/master/latest_version_dl)/code-base-$(curl https://gitlab.com/minteck-projects/mpcms/changelog/raw/master/latest_version_dl).tar.gz -O mpcms.tar.gz # Téléchargez la dernière version stable
tar xvzf mpcms.tar.gz # Extraire le fichier dans le dossier courant
cd code-base-* # Accéder aux fichiers extraits
cp -Rv * /var/www/html # Copier les fichiers dans le dossier racine d'Apache
cd .. # Retourner dans le dossier parent
rm -Rfvd code-base-* mpcms.tar.gz # Supprimer les fichiers qui ne sont plus nécessaires.
rm -fv /var/www/html/index.html # Supprimer la page de test par défaut
chmod -Rv 777 /var/www/html # Configurez les permissions
```

Notez que le téléchargement des fichiers peut s'avérer long, soyez patient.

Répétez les mêmes commandes pour mettre à jour le logiciel vers une nouvelle version.

> Plus d'informations arrivent prochainement
