# AVEC CHEVAL BDE, LAISSE TON CERVEAU AU VESTIAIRE!

![alt text](https://imgur.com/MLecfHU "BDE CHEVAL")
*
<3

Installer [PHP](http://php.net/downloads.php), [apache](https://httpd.apache.org/download.cgi), [MySQL](https://www.mysql.com/fr/downloads/)

Executer les commandes suivantes : 
`php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"`
`php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"`
`php composer-setup.php`
`php -r "unlink('composer-setup.php');"`

`mv composer.phar /usr/local/bin/composer`

Si ne marche pas : `mkdir -p /usr/local/bin`

Installer [git](https://git-scm.com/downloads)


`Cd {MonDossierOuLeProjetSeraInstallé} `

`Git clone https://github.com/alexzerah/projetChevalSymfony.git`

`Cd {NomDuDossierContenantLeProjet} : composer Install`

Dans .env modifié la Database `DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name`

Démarrer SQL

`Php bin/console doctrine:database:create`
`Php bin/console doctrine:database:update —force`
`Php bin/console doctrine:fixtures:load`
