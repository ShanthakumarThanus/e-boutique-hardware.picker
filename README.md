# 🛒 e-boutique-hardware.picker

🔗 Voir ma boutique en ligne : https://thanus.alwaysdata.net/hardware.picker/

**e-boutique-hardware.picker** est une application développée avec le framework Symfony. Elle permet aux utilisateurs de parcourir une sélection de produits informatiques (Processeur, Carte Graphique), de les ajouter à leur panier et de passer commande. Le projet inclut une interface d'administration pour la gestion des produits, des utilisateurs et des commandes.

---

## 🚀 Fonctionnalités principales

- **Catalogue de produits** : Affichage des produits avec images, descriptions et prix.
- **Système de panier** : Ajout, modification et suppression d'articles dans le panier.
- **Gestion des commandes** : Processus de commande complet avec récapitulatif.
- **Authentification et rôles** :
  - Inscription et connexion des utilisateurs.
  - Attribution automatique du rôle `ROLE_USER` lors de l'inscription.
  - Interface d'administration accessible aux utilisateurs avec le rôle `ROLE_ADMIN`.
- **Gestion des produits** : Ajout, modification et suppression de produits via l'interface d'administration.
- **Upload d'images** : Téléversement d'images pour les produits avec gestion des fichiers.
- **Interface responsive** : Adaptée aux différents types d'écrans (ordinateurs, tablettes, mobiles).

---

## 🛠️ Technologies utilisées

- **Backend** : PHP 8.x, Symfony 5.x/6.x
- **Frontend** : Twig, Bootstrap 5
- **Base de données** : MySQL
- **ORM** : Doctrine
- **Autres** :
  - Composer pour la gestion des dépendances.
  - Symfony Flex pour la configuration rapide.
  - VichUploaderBundle pour la gestion des uploads d'images.

---

## 📦 Installation

### Prérequis

- PHP 8.0 ou supérieur
- Composer
- MySQL
- Un serveur web (Apache, Nginx, etc.)

### Étapes

1. **Cloner le dépôt**

   ```bash
   git clone https://github.com/ShanthakumarThanus/e-boutique-hardware.picker.git
   cd e-boutique-hardware.picker

2. Installer les dépendances

```bash
composer install
```

3. Configurer les variables d'environnement

Copier le fichier .env et le renommer en .env.local, puis configurer la connexion à la base de données :

DATABASE_URL="mysql://utilisateur:motdepasse@127.0.0.1:3306/nom_de_la_base"

4. Créer la base de données et exécuter les migrations

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

5. Lancer le serveur de développement

```bash
symfony server:start
```

## 🖼️ Upload d'images

Les images des produits sont stockées dans le dossier public/uploads. Assurez-vous que ce dossier existe et qu'il est accessible en écriture :

```bash
mkdir -p public/uploads
chmod -R 775 public/uploads
```

## 🔐 Gestion des rôles

ROLE_USER : Attribué automatiquement lors de l'inscription d'un nouvel utilisateur.
ROLE_ADMIN : Doit être attribué manuellement via la base de données ou une interface d'administration pour accéder aux fonctionnalités de gestion.

## 🤓 Auteur

Développé par Thanus SHANTHAKUMAR.
