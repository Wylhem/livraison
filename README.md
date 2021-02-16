## Projet S3 Livraison ##

Repo git du Projet de S3 de nicolas.marie et wylhem.dorville

# Documentation technique



## Installation de la base de données.

 

Pour pouvoir installer la base de données, lancer le script  ```tables-creates.sql``` » se trouvant 
 ```../projet-s3-livraison/BD```

Si vous voulez avoir un jeu de donnée pour les produits, lancer le script PHP ```populate.php```  se trouvant :  ```../projet-s3-livraison/fruitslegumes```

## Lancer le site web

 

Prérequis, il vous faut aller dans le fichier ```info.php``` et ajouter dans les variables globales vos identifiants pour vous connecter à la base de données ex : 

```php
<?php
namespace Projet;
$GLOBALS["bd_user"] = "apache";
$GLOBALS["bd_passwd"] = "apache";
?>
  
```



Puis lancer le site web.

## Modifier les feuilles de style

##  

Pour ce projet, nous avons utilisée la technologie SASS. Pour installer SASS il vous faut avoir au préalable NodeJS.

### Installer NodeJS et SASS sous Windows

(Ici, j’explique la façon dont nous avons pu installer SASS. Sur le Site web de SASS, ils donnent d’autres possibilités. https://sass-lang.com/install)

\1.    Pour installer NodeJS, aller sur le site de NodeJS https://nodejs.org/fr/download/ puis installer la dernière version de Node.

\2.    Vérifiez bien que Node et NPM soient bien installer en utilisant les commande `node -v et npm -v`

\3.    D’après le site officiel de SASS, https://sass-lang.com/install , vous pouvez installer l’installer la technologie grâce à la commande `npm install -g sass`
 

### Installer NodeJS et SASS sous linux et MACOS

Vous avez la possibilité de suivre le même cheminement que pour l’installation Windows https://nodejs.org/en/download/ . Cependant, vous avez aussi la possibilité de l’installer par ligne de commande
 https://nodejs.org/en/download/package-manager/