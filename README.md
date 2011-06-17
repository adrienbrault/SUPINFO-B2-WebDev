Installation
============

PHP
---

Ouvrez un terminal et placez vous dans le dossier contenant les sources du projet:

1) Assurez vous que la commande suivante ne renvoie aucun "major problem". Corrigez les si besoin. Vous pouvez ignorer les erreurs à propos de app/cache/ car les dossiers seront créés automatiquement plus tard.

    $ php app/check.php

2) Monter le dossier web/ comme dossier root de votre serveur apache. Affichez la page http://localhost/config.php (ou équivalent) et corrigez les "major problems".

SYMFONY2
--------

3) Vous devez installez le Framework Symfony pour continuer:

    $ php bin/vendors.php --reinstall


DATABASE
--------

4) Entrez les informations de votre base de donnée MySQL dans le fichier suivant:

    app/config/parameters.ini

5) Si la base de donnée dédié au projet n'est pas déjà créée vous pouvez exécutez la commande suivante:

    $ php app/console doctrine:database:create

6) Pour créer les tables executez cette commande:

    $ php app/console doctrine:schema:create

7) Il est ensuite conseillé d'executer cette commande afin que Symfony2 déploie ses fichiers statiques:

    $ php app/console assets:install web/