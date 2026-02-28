# LeadiX CRM

LeadiX est une application CRM moderne construite avec **Laravel 12** pour gérer l’ensemble du cycle commercial et financier d’une organisation, de la prospection jusqu’au paiement.

**Cycle métier principal :**

**Lead → Deal → Invoice → Payment**
**(Prospect) → (Opportunité) → (Facture) → (Paiement)**

L’application repose sur une architecture **multi-tenant**, garantissant l’isolation complète des données entre les différentes organisations.

---

## Aperçu

LeadiX a été conçu pour centraliser et simplifier la gestion commerciale d’une entreprise grâce à :

* la gestion des **leads**
* le suivi du **pipeline de vente**
* la création et le suivi des **factures**
* la gestion de la **trésorerie**
* les **notifications en temps réel**
* le **contrôle d’accès par rôles**
* les **rapports et indicateurs de performance**

---

## Fonctionnalités principales

* **Gestion des leads** : création, qualification, suivi et conversion
* **Pipeline de ventes** : gestion visuelle des opportunités avec Kanban drag & drop
* **Gestion des deals** : suivi des étapes commerciales, statut gagné/perdu
* **Facturation** : création de factures, génération PDF, suivi des statuts
* **Paiements** : enregistrement et suivi des paiements reçus
* **Cashflow** : tableau de bord de trésorerie avec revenus, dépenses et projections
* **Notifications** : alertes pour les événements importants
* **Multi-tenancy** : séparation des données par organisation
* **RBAC** : rôles `admin`, `sales`, `finance`
* **Rapports** : KPIs, analyses de performance et exports

---

## Stack technologique

### Backend

* **PHP 8.2+**
* **Laravel 12**
* **MySQL / SQLite**
* **Composer**

### Frontend

* **Blade**
* **Tailwind CSS 4**
* **Alpine.js 3.13**
* **Vite 7**
* **SortableJS 1.15**

### Packages principaux

* `laravel/breeze` — authentification
* `barryvdh/laravel-dompdf` — génération PDF des factures

---

## Architecture

LeadiX suit une architecture **MVC** enrichie par une couche de services métier et des observers.

### Couches principales

* **Views** : templates Blade et composants réutilisables
* **Controllers** : gestion des requêtes HTTP, validation et orchestration
* **Services** : logique métier complexe
* **Models** : ORM Eloquent et relations métier
* **Database** : migrations, seeders et factories
* **Observers** : automatisation des actions métier
* **Notifications** : alertes en base de données

### Flux général

**Utilisateur → Navigateur → Routes → Middleware Auth/Tenancy → Controllers → Services → Models → Base de données → Views / Notifications**

---

## Structure du projet

```text
leadix-app/
├── app/
│   ├── Http/Controllers/
│   ├── Models/
│   ├── Notifications/
│   ├── Observers/
│   ├── Services/
│   ├── Traits/
│   └── Providers/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── routes/
├── public/
└── storage/
```

---

## Modules fonctionnels

### 1. Dashboard

* Tableau de bord par rôle
* KPIs commerciaux et financiers
* activités récentes
* vues de synthèse

### 2. Lead Management

* création et qualification de leads
* modification et suivi
* conversion en opportunités

### 3. Deal Management

* pipeline Kanban
* drag & drop entre étapes
* marquage `Won` / `Lost`
* génération automatique de facture si deal gagné

### 4. Invoice Management

* gestion des factures
* suivi des statuts
* génération PDF
* gestion des paiements et retards

### 5. Cashflow

* revenus vs dépenses
* évolution de la trésorerie
* prévisions financières

### 6. Reports

* rapports de ventes
* rapports financiers
* performance par utilisateur
* exports CSV/PDF

### 7. Team Management

* invitation de membres
* gestion des rôles
* administration d’équipe

### 8. Notification System

* notifications temps réel
* compteur non lu
* marquage comme lu
* alertes sonores et visuelles

---

## Système multi-tenant

LeadiX implémente un modèle **multi-tenant** pour garantir qu’un utilisateur ne puisse accéder qu’aux données de son organisation.

Le trait `BelongsToOrganization` applique :

* un **global scope** sur les modèles concernés
* l’attribution automatique du `organization_id`
* le filtrage automatique des requêtes par organisation

### Modèles concernés

* Lead
* Deal
* Invoice
* Contact
* Activity
* Expense

---

## Contrôle d’accès (RBAC)

LeadiX utilise trois rôles principaux :

### Admin

* accès complet à toute l’application
* gestion d’équipe
* accès cashflow, settings, reports

### Sales

* accès aux leads, deals, dashboard, contacts
* pas d’accès aux invoices ni au cashflow

### Finance

* accès aux invoices, cashflow, reports, dashboard
* pas d’accès aux leads ni aux deals

---

## Flux métier principal

### Lead → Deal

1. Un lead est créé
2. Il est qualifié
3. Il est converti en deal
4. Une notification est envoyée

### Deal → Invoice

1. Le deal progresse dans le pipeline
2. Lorsqu’il est marqué comme gagné
3. Une facture est générée automatiquement
4. Des notifications sont envoyées aux équipes concernées

### Invoice → Payment

1. La facture est envoyée
2. Le paiement est reçu et enregistré
3. Le statut est mis à jour
4. En cas de retard, une notification d’overdue est déclenchée

---

## Services métier

### `DealService`

Responsable de :

* la logique de transition des étapes
* les probabilités de closing
* les statistiques commerciales
* les règles métier liées aux deals

### `FilterService`

Responsable de :

* la construction de filtres avancés
* les requêtes dynamiques
* l’application de scopes personnalisés

### `InvoicePdfService`

Responsable de :

* la génération des PDFs
* le formatage des montants
* les templates de factures

---

## Notifications

Le système de notifications couvre notamment :

* création de lead
* création de deal
* deal gagné ou perdu
* changement d’étape
* création de facture
* paiement reçu
* facture en retard

Chaque notification peut être :

* stockée en base
* affichée en interface
* marquée comme lue
* accompagnée d’un son ou d’un toast

---

## Interface utilisateur

LeadiX adopte un design system moderne appelé **Dark Nebula** :

* mode sombre par défaut
* glassmorphism
* dégradés orange / violet
* micro-animations
* interface responsive
* boards Kanban interactifs

### Composants réutilisables

* alert
* modal
* stat-card
* table
* form-input
* kanban-card

---

## Installation

### 1. Cloner le projet

```bash
git clone https://github.com/aliharti2004/Leadix-App.git
cd Leadix-App
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Installer les dépendances frontend

```bash
npm install
```

### 4. Configurer l’environnement

```bash
copy .env.example .env
php artisan key:generate
```

### 5. Configurer la base de données

Modifie le fichier `.env` avec tes paramètres MySQL ou SQLite.

### 6. Lancer les migrations et seeders

```bash
php artisan migrate --seed
```

### 7. Démarrer le projet

```bash
php artisan serve
npm run dev
```

---

## Routes principales

### Authentification

* `GET /login`
* `POST /login`
* `GET /register`
* `POST /register`
* `POST /logout`

### Dashboard

* `GET /dashboard`

### Leads

* `GET /leads`
* `POST /leads`
* `POST /leads/{id}/convert`

### Deals

* `GET /deals/kanban`
* `POST /deals/{id}/update-stage`
* `POST /deals/{id}/mark-won`
* `POST /deals/{id}/mark-lost`

### Invoices

* `GET /invoices/kanban`
* `GET /invoices/{id}/pdf`
* `POST /invoices/{id}/update-status`

### Cashflow

* `GET /cashflow`

### Reports

* `GET /reports`

### Notifications

* `GET /notifications/unread-count`
* `GET /notifications/latest`
* `POST /notifications/{id}/read`

---

## Déploiement

L’application est prévue pour un déploiement sur **Railway.app** avec :

* **Nixpacks**
* **MySQL** en production
* **Vite** pour la compilation des assets
* **caching Laravel** pour les performances

---

## Forces de l’architecture

* architecture claire et modulaire
* séparation nette des responsabilités
* système multi-tenant robuste
* contrôle d’accès simple et efficace
* forte automatisation via observers
* interface moderne et premium
* extensibilité pour de futurs modules

---

## Extensibilité

L’architecture permet facilement :

* l’ajout de nouveaux rôles
* de nouveaux types de notifications
* de nouveaux modules (devis, produits, abonnements, etc.)
* des intégrations API / webhooks
* des personnalisations par organisation

---

## Version

* **Nom** : LeadiX CRM
* **Version** : `v1.0`
* **Date de documentation** : `21 janvier 2026`

---

## Auteur

**Ali Harti**
