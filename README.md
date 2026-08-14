# VeltrixCRM

![VeltrixCRM](https://img.shields.io/badge/Veltrix-CRM-4F46E5?style=for-the-badge&logo=laravel)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-316192?style=for-the-badge&logo=postgresql&logoColor=white)
![Render](https://img.shields.io/badge/Render-%46E3B7?style=for-the-badge&logo=render&logoColor=white)

**VeltrixCRM** is a modern, high-performance Customer Relationship Management (CRM) platform built on the robust Laravel framework. Designed with user experience in mind, it provides businesses with an elegant interface to manage customers, tasks, and workflows seamlessly.

---

## 🌟 Key Features

- **Advanced Authentication:** Secure credential-based login alongside seamless Google OAuth integration.
- **Role-Based Access Control (RBAC):** Distinct workspace experiences for Administrators and Staff/Managers.
- **Interactive & Dynamic UI:** Premium user interface featuring micro-animations, glassmorphism, and instant visual feedback (powered by GSAP and Tailwind CSS).
- **Cloud-Native Database:** Fully integrated with Neon's serverless PostgreSQL for infinite scalability and zero downtime.
- **Activity & Task Tracking:** Built-in activity logs and task management tailored for enterprise productivity.

## 🛠️ Technology Stack

- **Backend:** Laravel 11.x / PHP 8.2+
- **Frontend:** Blade Templates, Tailwind CSS, GSAP (Animations)
- **Database:** PostgreSQL (Neon Serverless)
- **Hosting / Deployment:** Render

---

## 🚀 Getting Started (Local Development)

To get a local copy up and running, follow these simple steps.

### Prerequisites
* PHP >= 8.2
* Composer
* PostgreSQL or MySQL

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Balaji-Sri-Ram/VeltrixCRM.git
   cd VeltrixCRM
   ```

2. **Install Composer Dependencies**
   ```bash
   composer install
   ```

3. **Configure Environment Variables**
   ```bash
   cp .env.example .env
   ```
   *Update the `.env` file with your database credentials and Google OAuth keys.*

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations & Seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Start the Development Server**
   ```bash
   php artisan serve
   ```
   *Visit `http://localhost:8000` in your browser.*

---

## ☁️ Deployment (Render & Neon)

VeltrixCRM is optimized for deployment on [Render](https://render.com) using [Neon PostgreSQL](https://neon.tech).

**Important Environment Variables for Production:**
Ensure the following variables are strictly set in your production environment to bypass SNI driver limitations and ensure secure connections:

```env
DB_CONNECTION=pgsql
DB_HOST=ep-your-neon-host.aws.neon.tech
DB_PORT=5432
DB_DATABASE=neondb
DB_USERNAME=neondb_owner
DB_PASSWORD="endpoint=ep-your-neon-endpoint;your_actual_password"
DB_SSLMODE=require
QUEUE_CONNECTION=sync
```

*(Note: The `endpoint=...;` prefix in the password is required for local Windows development or outdated `libpq` drivers. On modern Linux containers like Render, you may just use the raw password).*

---

## 🛡️ License

The VeltrixCRM source code is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
