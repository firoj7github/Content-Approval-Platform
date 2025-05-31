# 📄 Content Approval Platform with Media Handling and Automation

A Laravel 11-based content management system where users can submit content, and admins can approve or reject them. The system supports media uploads imageswith automatic thumbnail generation, queue processing, and scheduled automation.

---

## 🚀 Features

- ✅ User content submission & admin approval system
- 🖼️ Media upload with automatic thumbnail generation
- 📁 Organized file structure with Laravel Storage
- ⏱️ Scheduled tasks for automated approvals/rejections
- 🧵 Queue jobs for background processing
- 🧰 Service Layer pattern for clean business logic
- 👥 Role-based access (User & Admin)

---

## 🛠️ Tech Stack

- Laravel 11
- MySQL
- Laravel Storage (public disk)
- Queues with `database` driver
- Scheduler (Laravel cron)
- Optional: `Intervention/image` or native image handling for thumbnails

---

## 📦 Installation & also add database name

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/content-approval-platform.git
cd content-approval-platform


```bash
composer install

```bash
cp .env.example .env

```bash
php artisan key:generate

```bash
php artisan migrate:fresh --seed

```bash
php artisan storage:link

```bash
php artisan queue:work

```bash
php artisan serve



