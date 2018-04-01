# PostGreSQL
Groupe CFAC 

<b> Membres: </b>
 
CANTELOUP Anthony (fufulift) 
 
FLAMANT Cédric (Drice33)

## Choix de l'ISO
<p>Nous avons choisit l'installation d'une VM windows 10.</p>
 (4 Go de RAM, 32 Go de stockage).</p>

## Installation de MySQL et PhpMyAdmin graphique
Pour le bon fonctionnement de MySQL et PhpMyAdmin sous windows 10, nous allons installer WampServer 3.0.1.

Les étapes d'installations sont sur les images 1 à 4 dans le bon ordre.

Ensuite il suffit de démarer WampServer et de ce connecter avec ces identifiants.

## Création de l'application
Tout est dans le fichier : class.BackupMysql.php

Le fichier suivant fait les ordres suvants:

### Sauvegarde de l'ensemble des bases de données présentes sur le serveur
### Restauration de la sauvegarde
### Gérer la rétention des sauvegardes (ex: fichier de conf)

