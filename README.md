# Contact Manager

## Stack Technique

* **Backend :** PHP natif
* **Base de données :** MySQL (connexion via PDO)
* **Frontend :** HTML5, Tailwind CSS
* **Icônes :** Phosphor Icons


## Lancement en local

### Prérequis
* Un serveur local (**XAMPP**, **WAMP**, **MAMP**)
* **PHP**
* **MySQL**

### 1. Cloner le projet
Clonez le dossier du projet dans le répertoire racine de votre serveur (`htdocs` ou `www`)
```bash
git clone https://github.com/PeRazk/contacts_manager.git
cd contacts_manager
```

### 2. Configuration de la base de données
1. Ouvrez phpMyAdmin
2. Importez le fichier SQL `database.sql` fourni à la racine du projet
3. Si besoin, modifiez le fichier de config `config/database.php` avec vos identifiants locaux :
```php
$host = 'localhost';
$dbName = 'contacts_dev';
$username = 'root';
$password = '';
```

### 3. Accès à l'application
Ouvrez votre navigateur et allez sur :
`http://localhost/contacts_manager`