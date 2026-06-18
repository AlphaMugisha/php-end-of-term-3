# 🚗 Magerwa Vehicle Tracking Management System

> A web-based system built for **Magerwa Public Bonded Warehouse** — Rwanda's leading cargo handling facility — to register, manage, and track vehicles and their associated clients.

---

## 📌 Table of Contents

- [Project Overview](#project-overview)
- [Business Context](#business-context)
- [System Features](#system-features)
- [Tech Stack](#tech-stack)
- [Database Design](#database-design)
- [Project Structure](#project-structure)
- [API Endpoints](#api-endpoints)
- [Setup & Installation](#setup--installation)
- [Usage Guide](#usage-guide)
- [Responsiveness](#responsiveness)
- [Author](#author)

---

## Project Overview

The **Magerwa Vehicle Tracking Management System** is a full-stack web application designed to digitize and streamline how Magerwa records vehicle and client information. The system allows an authenticated administrator to register clients, register vehicles, link vehicles to clients, and assign unique plate numbers — all through a clean, responsive web interface.

---

## Business Context

**Magerwa** (Magasins Généraux du Rwanda) is a public bonded warehouse with extensive experience in handling diverse cargo across Rwanda. As their operations grow, managing vehicle records manually becomes inefficient and error-prone. This system solves that by providing:

- A secure, admin-only access portal
- Structured client and vehicle records
- A clear vehicle-to-client linkage with unique plate numbers
- Paginated, easy-to-read data display

---

## System Features

### ✅ Task 1 — Admin Authentication

- Admin can **sign up** with:
  - Full Name
  - Email Address
  - Phone Number
  - National ID
  - Password
- Admin can **log in** with email and password
- All system routes are **protected** — only authenticated admins can access them
- Token-based authentication using **Laravel Sanctum**

---

### ✅ Task 2 — Client Management

Admins can perform full CRUD operations on clients:

| Field | Description |
|---|---|
| Names | Full name of the client |
| National ID | Client's Rwanda national identification number |
| Telephone | Contact phone number |
| Address | Physical or postal address |

- View all clients in a paginated table
- Edit or delete client records

---

### ✅ Task 3 — Vehicle Management

Admins can perform full CRUD operations on vehicles:

| Field | Description |
|---|---|
| Chassis Number | Unique identifier stamped on the vehicle frame (VIN) |
| Manufacture Company | Brand/maker (e.g., Toyota, Mercedes) |
| Manufacture Year | Year the vehicle was manufactured |
| Price | Declared or estimated value of the vehicle |
| Model Name | Specific model (e.g., Land Cruiser, C-Class) |

- View all vehicles in a paginated table
- Edit or delete vehicle records

---

### ✅ Task 4 — Linkage & Display

- Admin can **link a vehicle to a client**
- System assigns a **unique plate number** to each linked vehicle
- Linked records are displayed in a **paginated table** showing:
  - Client details
  - Vehicle details
  - Assigned plate number
  - Date of registration

---

## Tech Stack

| Layer | Technology |
|---|---|
| **Frontend** | HTML5, CSS3, Bootstrap 5 |
| **Backend** | PHP 8.x — Laravel Framework |
| **Database** | MySQL |
| **Authentication** | Laravel Sanctum (token-based) |
| **API Testing** | Postman |
| **Version Control** | Git & GitHub |

---

## Database Design

### `admins` table

| Column | Type | Notes |
|---|---|---|
| id | BIGINT | Primary key, auto-increment |
| name | VARCHAR(255) | Full name |
| email | VARCHAR(255) | Unique |
| phone | VARCHAR(20) | |
| national_id | VARCHAR(50) | Unique |
| password | VARCHAR(255) | Hashed (bcrypt) |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |

---

### `clients` table

| Column | Type | Notes |
|---|---|---|
| id | BIGINT | Primary key, auto-increment |
| name | VARCHAR(255) | |
| national_id | VARCHAR(50) | Unique |
| telephone | VARCHAR(20) | |
| address | TEXT | |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |

---

### `vehicles` table

| Column | Type | Notes |
|---|---|---|
| id | BIGINT | Primary key, auto-increment |
| chassis_number | VARCHAR(100) | Unique (VIN) |
| manufacture_company | VARCHAR(100) | |
| manufacture_year | YEAR | |
| price | DECIMAL(15,2) | |
| model_name | VARCHAR(100) | |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |

---

### `vehicle_client` (Linkage table)

| Column | Type | Notes |
|---|---|---|
| id | BIGINT | Primary key, auto-increment |
| vehicle_id | BIGINT | Foreign key → vehicles.id |
| client_id | BIGINT | Foreign key → clients.id |
| plate_number | VARCHAR(20) | Unique, system-generated |
| linked_at | TIMESTAMP | Date of linkage |

---

### Entity Relationship Summary

```
admins
  └── manages everything (auth-protected)

clients ──────────────────┐
                          │ (many-to-many via vehicle_client)
vehicles ─────────────────┘
                          │
                    plate_number (unique per linkage)
```

---

## Project Structure

```
magerwa-vtms/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── ClientController.php
│   │   │   ├── VehicleController.php
│   │   │   └── LinkageController.php
│   │   └── Middleware/
│   │       └── AuthenticateAdmin.php
│   └── Models/
│       ├── Admin.php
│       ├── Client.php
│       ├── Vehicle.php
│       └── VehicleClient.php
├── database/
│   └── migrations/
│       ├── create_admins_table.php
│       ├── create_clients_table.php
│       ├── create_vehicles_table.php
│       └── create_vehicle_client_table.php
├── routes/
│   └── api.php
├── public/
│   └── (frontend HTML/CSS/JS files)
├── resources/
│   └── views/
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── clients/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       ├── vehicles/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       └── linkage/
│           ├── index.blade.php
│           └── create.blade.php
├── .env
├── composer.json
└── README.md
```

---

## API Endpoints

> All endpoints below (except auth) require a valid Bearer token in the `Authorization` header.

### Authentication

| Method | Endpoint | Description |
|---|---|---|
| POST | `/api/auth/register` | Admin sign up |
| POST | `/api/auth/login` | Admin login, returns token |
| POST | `/api/auth/logout` | Invalidate token |

### Clients

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/clients` | List all clients (paginated) |
| POST | `/api/clients` | Register a new client |
| GET | `/api/clients/{id}` | View a specific client |
| PUT | `/api/clients/{id}` | Update client record |
| DELETE | `/api/clients/{id}` | Delete a client |

### Vehicles

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/vehicles` | List all vehicles (paginated) |
| POST | `/api/vehicles` | Register a new vehicle |
| GET | `/api/vehicles/{id}` | View a specific vehicle |
| PUT | `/api/vehicles/{id}` | Update vehicle record |
| DELETE | `/api/vehicles/{id}` | Delete a vehicle |

### Linkage

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/linkages` | List all linked records (paginated) |
| POST | `/api/linkages` | Link a vehicle to a client |
| GET | `/api/linkages/{id}` | View a specific linkage |
| DELETE | `/api/linkages/{id}` | Remove a linkage |

---

## Setup & Installation

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL
- Node.js (for frontend assets if using Vite)
- Git

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/your-username/magerwa-vtms.git
cd magerwa-vtms

# 2. Install PHP dependencies
composer install

# 3. Copy environment file and configure it
cp .env.example .env

# 4. Edit .env — set your database credentials
DB_DATABASE=magerwa_vtms
DB_USERNAME=root
DB_PASSWORD=your_password

# 5. Generate application key
php artisan key:generate

# 6. Run database migrations
php artisan migrate

# 7. (Optional) Seed the database with test data
php artisan db:seed

# 8. Install Sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

# 9. Serve the application
php artisan serve
```

The app will be accessible at: `http://127.0.0.1:8000`

---

## Usage Guide

1. **Register as Admin** — Navigate to `/register` and fill in your details
2. **Log in** — Go to `/login` and use your credentials
3. **Add Clients** — Go to the Clients section and register client profiles
4. **Add Vehicles** — Go to the Vehicles section and register vehicle details
5. **Link Vehicles to Clients** — In the Linkage section, select a client and a vehicle; the system will generate a unique plate number
6. **View Records** — All records are displayed in paginated tables for easy browsing

---

## Responsiveness

The system is designed to work seamlessly across devices:

| Device | Breakpoint | Layout |
|---|---|---|
| Mobile | < 576px | Single column, stacked cards |
| Tablet | 576px – 992px | Two-column layout, collapsible nav |
| Laptop/Desktop | > 992px | Full sidebar navigation, data tables |

Bootstrap 5's grid system and utility classes are used throughout to ensure a consistent, professional appearance on all screen sizes.

---

## Author

**Developed for:** Magerwa Public Bonded Warehouse, Kigali, Rwanda  
**Framework:** Laravel (PHP)  
**Academic Context:** Full-Stack Web Development Project  
**Year:** 2025–2026

---

> _"Digitizing vehicle records for a smarter, more efficient Magerwa."_