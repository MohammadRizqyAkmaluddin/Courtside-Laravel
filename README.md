# Courtside (Back-End)
Court Booking & Venue Management Platform

A full-stack web application for booking sports courts with real-time scheduling, integrated payment gateway, and venue management dashboard.

---

## Preview

![Courtside Preview](https://raw.githubusercontent.com/MohammadRizqyAkmaluddin/Readme-Assets/blob/main/Courtside/asset1.png)

---

## Features

- Real-time court booking system
- Venue management dashboard for administrators
- Midtrans payment gateway integration
- AI assistant for user interaction
- Mobile-first responsive design with modern bottom-sheet modal UI

---

## Tech Stack

**Frontend**
- Nuxt.js
- Tailwind CSS

**Backend**
- Laravel
- MySQL

**Deployment**
- Ubuntu VPS
- Nginx

---

## System Highlights

- Built with a scalable full-stack architecture (Nuxt.js + Laravel)
- Implemented secure payment workflow using Midtrans
- Designed modular and maintainable backend structure
- Deployed and managed on a production-ready VPS environment

---

## Database Design

The application uses a structured relational database to handle booking, transactions, and user management efficiently.

![ERD](your-erd-image-link)

- Designed normalized schema for scalability
- Managed complex relationships between users, bookings, and payments
- Ensured data consistency for real-world usage

---

## Installation

```bash
git clone https://github.com/MohammadRizqyAkmaluddin/Courtside-Laravel.git
cd Courtside-Laravel

composer install
php artisan migrate:fresh --seed
php artisan key:generate
php artisan serve
