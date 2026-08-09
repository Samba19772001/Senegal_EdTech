# 📚 Senegal EdTech — Portail de l'Enseignement Primaire

![Laravel](https://img.shields.io/badge/Laravel-12.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-blue?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?style=flat-square&logo=mysql)
![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-CDN-38bdf8?style=flat-square&logo=tailwindcss)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

> Solution digitale de gestion pédagogique dédiée aux enseignants du primaire au Sénégal.  
> Chaque enseignant dispose de son propre espace sécurisé pour gérer ses élèves, saisir les notes et générer les bulletins PDF officiels.

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
- [Équipe](#-équipe)

---

## 🎯 Présentation

**Senegal EdTech** est une application web Laravel permettant aux enseignants du primaire de :

- Gérer leurs élèves de manière autonome
- Saisir les notes par matière et par trimestre
- Calculer automatiquement les moyennes, rangs et mentions
- Générer des bulletins PDF professionnels conformes aux normes sénégalaises
- Suivre les performances de la classe via des statistiques détaillées
- Produire les documents officiels de fin d'année (classement, proposition de passage)

Chaque enseignant dispose d'un **compte indépendant** — les données sont strictement isolées entre utilisateurs.

---

## ✨ Fonctionnalités

### 👤 Authentification & Accès
- Inscription sécurisée avec **clé d'accès** obligatoire
- Connexion sécurisée via Laravel Breeze
- Isolation totale des données par enseignant

### 👥 Gestion des élèves
- Ajout manuel (nom, prénom, sexe, date de naissance, matricule)
- Import en masse via fichier Excel (.xlsx)
- Recherche avec autocomplétion en temps réel depuis le header
- Fiche élève complète avec historique des notes par trimestre
- Suppression individuelle ou en masse
- Transfert automatique lors du changement d'année scolaire

### 📖 Gestion des matières
- Matières prédéfinies par niveau : CI, CP, CE1, CE2, CM1, CM2
- Ajout de matières personnalisées par l'enseignant
- Configuration du barème (`note_sur`) par matière
- Chaque niveau a ses propres matières indépendantes

### ✏️ Saisie des notes
- Interface par matière avec liste des élèves automatique
- **Navigation clavier** : flèches ↑↓ pour passer d'un élève à l'autre
- Possibilité de marquer un élève **absent** (exclu du calcul de moyenne)
- Passage automatique à la matière suivante après validation
- Mise à jour possible (re-saisie) à tout moment
- Bouton "Tout à 0" pour mettre zéro à tous les élèves en un clic

### 📊 Calcul automatique
- Moyenne par élève calculée sur les matières effectivement saisies
- Les élèves absents sont exclus du calcul sans affecter les autres
- Classement automatique des élèves par trimestre
- Mentions : Insuffisant / Passable / Assez Bien / Bien / Très Bien
- Moyenne annuelle calculée sur les trimestres effectivement saisis

### 📄 Bulletins PDF officiels
- En-tête **République du Sénégal** avec drapeau, IA, IEF et école
- Notes par matière avec barème et appréciation
- Moyenne générale, rang, mention, effectif et moyenne de classe
- **Bilan annuel au T3** : récapitulatif des 3 trimestres + décision du conseil
- Téléchargement individuel ou collectif (tous les bulletins en un PDF)

### 📅 Bilan annuel (T3)
- Calcul de la moyenne annuelle sur les trimestres effectivement saisis
- Si un trimestre précédent manque : **saisie manuelle des moyennes** disponible
- Décision du conseil : **Passe en classe supérieure** (≥ 5/10) / **Redouble**
- Rang annuel calculé automatiquement

### 🏅 Classement par ordre de mérite
- Tableau de classement complet avec notes par matière, total, moyenne, mention
- Noms de matières en oblique pour une meilleure lisibilité
- Colonne sexe incluse
- Téléchargement PDF en format paysage avec en-tête officiel (IA, IEF, école)

### 📋 Proposition de passage
- Liste complète des élèves avec moyennes T1, T2, T3 et annuelle
- Rang annuel par ordre de mérite
- Observation : **Admis** ou **Redouble** calculé automatiquement
- Statistiques : effectif, admis, redoublants, taux de réussite
- Téléchargement PDF officiel pour le conseil des maîtres

### 📈 Statistiques détaillées
- Analyse par trimestre et par matière
- **Garçons ayant la moyenne** (≥ 5/10) et **garçons sans la moyenne**
- **Filles ayant la moyenne** et **filles sans la moyenne**
- Absents par genre
- Note maximum et minimum avec nom de l'élève
- Taux de réussite par matière avec code couleur
- Répartition des mentions (barres visuelles)
- Meilleur élève et élève en difficulté du trimestre

### 🔔 Interface & UX
- Sidebar responsive avec hamburger sur mobile
- Recherche autocomplete dans le header
- **Notifications & alertes** : compositions incomplètes, bulletins non générés
- **Guide d'aide rapide** intégré (4 étapes)
- Interface entièrement responsive (mobile, tablette, desktop)
- Classement avec scroll horizontal isolé sur mobile (sticky colonnes)

### ⚙️ Paramètres
- Changement d'année scolaire et de classe
- Création automatique de 3 nouvelles compositions
- Transfert automatique des élèves dans la nouvelle classe
- Historique des années scolaires

---

## 🛠 Stack technique

| Technologie | Version | Rôle |
|-------------|---------|------|
| **Laravel** | 12.x | Backend + Routing (MVC) |
| **PHP** | 8.2 | Langage serveur |
| **MySQL** | 8.0 | Base de données relationnelle |
| **Tailwind CSS** | CDN | Design & Interface utilisateur |
| **Laravel Breeze** | — | Authentification |
| **DomPDF** | barryvdh/laravel-dompdf | Génération des bulletins PDF |
| **Laravel Excel** | maatwebsite/excel | Import des listes élèves (.xlsx) |

---

## ✅ Prérequis

- PHP >= 8.2
- Composer >= 2.x
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

### 3. Copier le fichier d'environnement

```bash
cp .env.example .env
```

### 4. Générer la clé d'application

```bash
php artisan key:generate
```

### 5. Configurer la base de données

Créer une base de données MySQL nommée `senegal_edtech`, puis modifier le fichier `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=senegal_edtech
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Lancer les migrations

```bash
php artisan migrate
```

### 7. Insérer les matières par défaut

```bash
php artisan db:seed --class=MatiereSeeder
```

### 8. Créer une clé d'accès pour l'inscription

```bash
php artisan tinker
```

```php
App\Models\AccessKey::create(['cle' => 'VOTRE-CLE-ICI', 'est_utilisee' => false]);
exit
```

### 9. Démarrer le serveur

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
│   │   ├── Auth/ (via Breeze)
│   │   ├── DashboardController.php
│   │   ├── EleveController.php
│   │   ├── MatiereController.php
│   │   ├── CompositionController.php
│   │   ├── NoteController.php
│   │   ├── BulletinController.php
│   │   ├── MoyenneManuellController.php
│   │   ├── StatistiqueController.php
│   │   └── ParametreController.php
│   └── Requests/
│       └── ProfileUpdateRequest.php
├── Models/
│   ├── User.php
│   ├── Classe.php
│   ├── Eleve.php
│   ├── Matiere.php
│   ├── Composition.php
│   ├── Note.php
│   ├── Bulletin.php
│   ├── MoyenneManuelle.php
│   └── AccessKey.php
└── Services/
    ├── MoyenneService.php
    └── BulletinService.php

database/
├── migrations/
├── factories/
│   └── UserFactory.php
└── seeders/
    └── MatiereSeeder.php

resources/views/
├── layouts/app.blade.php
├── auth/ (login, register)
├── dashboard.blade.php
├── eleves/ (index, profil)
├── matieres/ (index)
├── compositions/ (index, notes, moyennes_manuelles)
├── bulletins/
│   ├── index.blade.php
│   ├── pdf.blade.php
│   ├── pdf_all.blade.php
│   ├── classement.blade.php
│   ├── classement_pdf.blade.php
│   ├── proposition_passage.blade.php
│   └── proposition_passage_pdf.blade.php
├── notes/ (index)
├── statistiques/ (index)
├── profile/ (edit)
├── parametres/ (index)
└── apropos/ (index)
```

---

## 📐 Règles métier

| Règle | Détail |
|-------|--------|
| **Coefficients** | Tous égaux à 1 — pas de pondération |
| **Calcul de la note** | Note brute conservée, affichée avec son barème |
| **Moyenne générale** | `(totalObtenu / totalMax * 10, 2)` — toujours sur 10 |
| **Absents** | Exclus du calcul de moyenne, sans affecter les autres |
| **CI / CP** | Toutes les matières notées sur 10 |
| **CE1 → CM2** | `note_sur` variable selon la matière (10, 20, 40...) |
| **Trimestres** | 3 compositions par an, créées automatiquement à l'inscription |
| **Unicité** | 1 note par (composition × élève × matière) |
| **Isolation** | Chaque enseignant ne voit que ses propres données |
| **Moyenne annuelle** | Calculée sur les trimestres effectivement saisis (1, 2 ou 3) |
| **Moyennes manuelles** | Si T1/T2 manquent, saisie manuelle avant génération T3 |
| **Décision T3** | Moyenne annuelle ≥ 5 → Passe / < 5 → Redouble |
| **Changement d'année** | Nouvelle classe + 3 compositions créées, élèves transférés |

### Mentions

| Moyenne | Mention |
|---------|---------|
| < 5 | Insuffisant |
| 5 – 6.99 | Passable |
| 7 – 7.99 | Assez Bien |
| 8 – 8.99 | Bien |
| ≥ 9 | Très Bien |

### Appréciations par matière

| Note /10 | Appréciation |
|----------|-------------|
| ≥ 9.5 | Excellent |
| ≥ 8 | Très Bien |
| ≥ 7 | Bien |
| ≥ 6 | Assez Bien |
| ≥ 5 | Passable |
| < 5 | Insuffisant |

---

## 🖼 Pages principales

| Page | Description |
|------|-------------|
| **Dashboard** | Vue d'ensemble : stats, activités récentes, performance |
| **Élèves** | Liste avec recherche, filtres, fiche détaillée par élève |
| **Matières** | Matières prédéfinies et personnalisées par niveau |
| **Compositions** | 3 trimestres avec progression de saisie |
| **Saisie des notes** | Interface par matière avec navigation clavier |
| **Bulletins** | Génération et téléchargement PDF par trimestre |
| **Classement** | Tableau de mérite avec toutes les notes (web + PDF) |
| **Proposition de passage** | Document officiel de fin d'année (web + PDF) |
| **Statistiques** | Analyse par matière, trimestre et genre |
| **Notes** | Vue globale de toutes les notes avec filtres |
| **Profil** | Modification des infos personnelles et professionnelles |
| **Paramètres** | Changement d'année scolaire et historique des classes |
| **À propos** | Présentation de la plateforme |

---

## 👨‍💻 Équipe

Projet développé :

| Membre | Rôle |
|--------|------|
| **Pape Samba Doucoure** | Développeur Full-Stack (Backend + Frontend) |

---

## 📄 Licence

Ce projet est sous licence **MIT**.
Libre d'utilisation, modification et distribution.

---

> *"L'éducation est l'arme la plus puissante pour changer le monde."* — Nelson Mandela
