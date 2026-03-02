# EasyColoc

EasyColoc est une application web de gestion de colocation qui permet de suivre les dépenses communes et de répartir automatiquement les dettes entre membres.  
Objectif : éviter les calculs manuels et donner une vue claire de **« qui doit quoi à qui »**.

## Fonctionnalités

### Utilisateurs
- Inscription / Connexion / Profil
- Premier utilisateur inscrit promu **Admin global** automatiquement
- Blocage des utilisateurs bannis (déconnexion automatique + refus d’accès)

### Colocations
- Création d’une colocation (owner automatique)
- Invitation par email/token
- Une seule colocation active par utilisateur
- Départ d’un membre (`left_at`)
- Retrait d’un membre par l’owner
- Transfert du rôle **Owner**
- Annulation de colocation (`status = cancelled`)

### Dépenses
- Ajout, modification, suppression
- Montant, date, payeur, catégorie
- Filtre par mois sur la vue colocation

### Soldes & Dettes
- Calcul automatique des soldes individuels
- Vue simplifiée « qui doit à qui »
- Paiements simples via **“Marquer payé”**

### Réputation
- Départ / annulation avec dette : **-1**
- Départ / annulation sans dette : **+1**
- Si un owner retire un membre avec dette : dette imputée à l’owner

### Administration globale
- Stats globales (colocations, utilisateurs, dépenses, bannis)
- CRUD utilisateurs
- Bannir / débannir

## Stack technique
- **Laravel (MVC monolithique)**
- **MySQL / PostgreSQL** via migrations
- **Eloquent** (`hasMany`, `belongsToMany`)
- **Authentification** : Laravel Breeze

## Installation

1. **Cloner le projet**
```bash
git clone <repo>
cd FacilColoc
```

2. **Installer les dépendances**
```bash
composer install
npm install
```

3. **Configurer l’environnement**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurer la base**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=FacilColoc
DB_USERNAME=root
DB_PASSWORD=
```

5. **Migrer**
```bash
php artisan migrate
```

6. **Lancer**
```bash
php artisan serve
npm run dev
```

## Configuration Email (Invitations)

### Gmail SMTP (réel)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=ton_email@gmail.com
MAIL_PASSWORD="APP_PASSWORD"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="ton_email@gmail.com"
MAIL_FROM_NAME="FacileColoc"
```

> Utilise un **App Password Gmail** (pas le mot de passe normal).

### Mailpit (local)
```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="no-reply@easycoloc.test"
MAIL_FROM_NAME="FacileColoc"
```

Puis :
```bash
php artisan config:clear
```

## Rôles
- **Member** : membre d’une colocation
- **Owner** : créateur de la colocation, peut inviter/retirer/transférer le rôle
- **Admin global** : stats globales, modération utilisateurs

## Routes principales

### Utilisateur
- `/dashboard` : mes colocations
- `/colocations/{id}` : détails colocation
- `/profile` : profil

### Admin
- `/admin/dashboard`
- `/admin/users`

## Notes
- Le bouton **“Marquer payé”** est disponible pour tous les membres.
- Les dettes sont recalculées automatiquement après paiement.

---

Si tu veux ajouter Stripe, notifications temps réel, calendrier ou export, ces fonctionnalités sont prévues comme bonus.
