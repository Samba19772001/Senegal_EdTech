# 📚 Senegal EdTech — Portail de l'Enseignement Primaire

![Laravel](https://img.shields.io/badge/Laravel-12.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-blue?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?style=flat-square&logo=mysql)
![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-3.x-38bdf8?style=flat-square&logo=tailwindcss)
![License](https://img.shields.io/badge/License-Tous%20droits%20r%C3%A9serv%C3%A9s-red?style=flat-square)

> Solution digitale de gestion pédagogique dédiée aux enseignants du primaire au Sénégal.  
> Chaque enseignant dispose de son propre espace sécurisé pour gérer ses élèves, saisir les notes et générer les bulletins PDF.

---

## 📋 Table des matières

- [Présentation](#-présentation)
- [Fonctionnalités](#-fonctionnalités)
- [Stack technique](#-stack-technique)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Structure du projet](#-structure-du-projet)
- [Règles métier](#-règles-métier)
- [Auteur](#-auteur)
- [Licence](#-licence)

---

## 🎯 Présentation

**Senegal EdTech** est une application web Laravel permettant aux enseignants du primaire de :

- Gérer leurs élèves de manière autonome
- Saisir les notes par matière et par trimestre
- Calculer automatiquement les moyennes (ramenées sur 10)
- Générer des bulletins PDF professionnels
- Suivre les performances de la classe tout au long de l'année

Chaque enseignant dispose d'un **compte indépendant** — les données sont strictement isolées entre utilisateurs.

---

## ✨ Fonctionnalités

### 👤 Gestion des enseignants
- Inscription avec informations personnelles, professionnelles et pédagogiques
- Connexion sécurisée (Laravel Breeze)
- Modification du profil et changement de mot de passe
- Gestion du changement d'année scolaire

### 👥 Gestion des élèves
- Ajout manuel (nom, prénom, sexe, date de naissance, matricule)
- Import en masse via fichier Excel (.xlsx)
- Recherche avec autocomplétion en temps réel
- Fiche élève avec historique des notes et moyennes
- Suppression individuelle ou en masse

### 📖 Gestion des matières
- Matières prédéfinies par niveau (CI, CP, CE1, CE2, CM1, CM2)
- Ajout de matières personnalisées
- Configuration du barème (`note_sur`) par matière
- Toutes les notes sont ramenées sur 10 pour le calcul des moyennes

### ✏️ Saisie des notes
- Saisie par matière avec liste des élèves automatique
- Navigation automatique vers la matière suivante après validation
- Possibilité de marquer un élève absent
- Calcul en temps réel de la note ramenée sur 10
- Mise à jour possible (re-saisie)

### 📊 Calcul automatique
- Moyenne par matière ramenée sur 10 : `note × 10 ÷ note_sur`
- Coefficient = 1 pour toutes les matières
- Classement automatique des élèves
- Mentions : Insuffisant / Passable / Assez Bien / Bien / Très Bien

### 📄 Bulletins PDF
- Génération en un clic pour tous les élèves
- En-tête personnalisé (école, région, classe, année scolaire)
- Tableau des notes avec appréciation par matière
- Moyenne générale, rang, mention, moyenne de classe
- Bilan annuel au 3ème trimestre (moyenne annuelle + décision du conseil)
- Téléchargement individuel ou collectif

### 📅 Bilan annuel (T3)
- Calcul de la moyenne annuelle sur les trimestres effectivement saisis
- Si un trimestre précédent manque : saisie manuelle des moyennes
- Décision du conseil : **Passe en classe supérieure** / **Redouble**
- Rang annuel calculé automatiquement

### 🔔 Autres fonctionnalités
- Alertes (notes incomplètes, bulletins non générés)
- Guide d'aide rapide intégré
- Historique des années scolaires
- Interface responsive (mobile, tablette, desktop)
- Page À propos et Paramètres

---

## 🛠 Stack technique

| Technologie | Version | Rôle |
|-------------|---------|------|
| **Laravel** | 12.x | Backend + Frontend (MVC) |
| **PHP** | 8.2 | Langage serveur |
| **MySQL** | 8.0 | Base de données |
| **Tailwind CSS** | CDN | Design & Interface |
| **Laravel Breeze** | — | Authentification |
| **DomPDF** | barryvdh/laravel-dompdf | Génération PDF |
| **Laravel Excel** | maatwebsite/excel | Import Excel |

---

## ✅ Prérequis

- PHP >= 8.2
- Composer >= 2.x
- Node.js >= 18.x & npm
- MySQL >= 8.0
- XAMPP / Laragon / Wamp (Windows) ou équivalent

---

## 🚀 Installation

### 1. Cloner le projet

```bash
git clone https://github.com/votre-username/Senegal_EdTech.git
cd Senegal_EdTech
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Installer les dépendances JS

```bash
npm install
```

### 4. Copier le fichier d'environnement

```bash
cp .env.example .env
```

### 5. Générer la clé d'application

```bash
php artisan key:generate
```

### 6. Configurer la base de données

Créer une base de données MySQL nommée `senegal_edtech`, puis modifier le fichier `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=senegal_edtech
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Lancer les migrations

```bash
php artisan migrate
```

### 8. Insérer les matières par défaut

```bash
php artisan db:seed --class=MatiereSeeder
```

### 9. Compiler les assets

```bash
npm run dev
```

### 10. Démarrer le serveur

```bash
php artisan serve
```

Accéder à l'application : **http://localhost:8000**

---

## ⚙️ Configuration

### Session (dans `.env`)

```env
SESSION_DRIVER=file
```

### Stockage des bulletins PDF

Les bulletins sont sauvegardés dans `storage/app/bulletins/`.  
Assurez-vous que ce dossier est accessible en écriture.

---

## 📁 Structure du projet

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController (via Breeze)
│   │   ├── DashboardController.php
│   │   ├── ClasseController.php
│   │   ├── EleveController.php
│   │   ├── MatiereController.php
│   │   ├── CompositionController.php
│   │   ├── NoteController.php
│   │   ├── BulletinController.php
│   │   ├── MoyenneManuellController.php
│   │   └── ParametreController.php
│   └── Requests/
├── Models/
│   ├── User.php
│   ├── Classe.php
│   ├── Eleve.php
│   ├── Matiere.php
│   ├── Composition.php
│   ├── Note.php
│   ├── Bulletin.php
│   └── MoyenneManuelle.php
├── Services/
│   ├── MoyenneService.php
│   ├── BulletinService.php
│   └── ImportEleveService.php
└── Imports/
    └── ElevesImport.php

database/
├── migrations/
└── seeders/
    └── MatiereSeeder.php

resources/views/
├── layouts/app.blade.php
├── auth/ (login, register)
├── dashboard.blade.php
├── eleves/ (index, profil)
├── matieres/
├── compositions/ (index, notes, moyennes_manuelles)
├── bulletins/ (index, pdf, pdf_all)
├── notes/
├── profile/
├── parametres/
└── apropos/
```

---

## 📐 Règles métier

| Règle | Détail |
|-------|--------|
| **Coefficients** | Tous égaux à 1 — pas de pondération |
| **Calcul de la note** | `note_ramenee = note × 10 ÷ note_sur` |
| **Moyenne générale** | `Σ(notes_ramenees) ÷ nb_matieres` — toujours sur 10 |
| **CI / CP** | Toutes les matières notées sur 10 |
| **CE1 → CM2** | `note_sur` variable selon la matière |
| **Trimestres** | 3 compositions par an, créées automatiquement |
| **Unicité** | 1 note par (composition × élève × matière) |
| **Isolation** | Chaque enseignant ne voit que ses propres données |
| **Moyenne annuelle** | Calculée sur les trimestres effectivement saisis |
| **Décision T3** | Moyenne ≥ 5 → Passe / < 5 → Redouble |

### Mentions

| Moyenne | Mention |
|---------|---------|
| < 5 | Insuffisant |
| 5 – 6.99 | Passable |
| 7 – 7.99 | Assez Bien |
| 8 – 8.99 | Bien |
| ≥ 9 | Très Bien |

---

## 👨‍💻 Auteur

Ce projet a été entièrement conçu et développé par :

**Pape Samba DOUCOURE**

---

## 🔒 Licence

Copyright © 2025 **Pape Samba DOUCOURE**. Tous droits réservés.

Ce projet et l'ensemble de son code source sont la propriété exclusive de Pape Samba DOUCOURE.  
Toute reproduction, copie, modification, distribution ou utilisation — même partielle — sans autorisation écrite préalable de l'auteur est **strictement interdite**.

Pour toute demande d'utilisation ou de collaboration, veuillez contacter l'auteur directement.

---

> *"L'éducation est l'arme la plus puissante pour changer le monde."* — Nelson Mandela
