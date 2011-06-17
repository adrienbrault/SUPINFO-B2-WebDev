Installation
============

PHP
---

Dans un terminal et à la racine des sources du projet executez:

1) Assurez vous que cette commande ne renvoie aucun "major problem". Corrigez les si besoin.:

    $ php app/check.php

2) Monter le dossier web/ comme dossier root de votre serveur apache. Affichez la page http://localhost/config.php (ou équivalent) et corrigez les "major problems".


SYMFONY2
--------

3) Vous devez installez le Framework symfony pour continuer:

    $ php bin/vendors.php --reinstall


DATABASE
--------

4) Entrez les informations de votre base de donnée dans le fichier suivant:

    app/config/parameters.ini


5) Si la base de donnée dédié au projet n'est pas déjà créée vous pouvez executez la commande suivante:

    $ php app/console doctrine:database:create


6) Pour créér les tables executez cette commande:

    $ php app/console doctrine:schema:create --force


7) Il est ensuite conseillé d'executer cette commande afin que Symfony2 déploie ses fichiers statiques:

    $ php app/console assets:install web/