# Task Management REST API (Vanilla PHP + PDO)

## Overview

This project is a **Task Management REST API with a basic browser-based frontend** built using **Vanilla PHP, PDO, and MySQL**.

The application allows users to register, log in, and manage personal tasks. Users can create, view, update, and soft delete tasks. The system also supports filtering, searching, pagination, and JSON API endpoints.

---

# Features

## Authentication

* User registration
* User login
* User logout
* Password hashing using `password_hash()`
* Session-based authentication

## Task Management

* Create task
* View task list
* View single task
* Edit task
* Soft delete task

## Filtering

* Filter tasks by status (`pending`, `in_progress`, `completed`)

## Search

* Search tasks by task title

## Pagination

* Display 5 tasks per page

## REST API

JSON API endpoints for task management.

Example endpoints:

| Method | Endpoint           | Description      |
| ------ | ------------------ | ---------------- |
| GET    | /api/tasks.php     | Get all tasks    |
| POST   | /api/tasks.php     | Create new task  |
| GET    | /api/task.php?id=1 | Get single task  |
| PUT    | /api/task.php?id=1 | Update task      |
| DELETE | /api/task.php?id=1 | Soft delete task |

---

# Tech Stack

* PHP (Vanilla PHP)
* PDO (PHP Data Objects)
* MySQL
* HTML / Bootstrap
* JSON API

---

# Project Setup

Follow these steps to run the project locally.

## 1. Clone the repository

```bash
git clone https://github.com/yourusername/task-manager-api.git
```

## 2. Move the project to your web server directory

Example for XAMPP:

```
C:\xampp\htdocs\task-manager
```

Or on Linux/Mac:

```
/var/www/html/task-manager
```

## 3. Start your web server

Start:

* Apache
* MySQL

Using XAMPP, Laragon, or another local server.

---

# Database Setup

## 1. Create a database

Open phpMyAdmin and create a database called:

```
task_manager
```

---

## 2. Create Users Table

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## 3. Create Tasks Table

```sql
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    status ENUM('pending','in_progress','completed') DEFAULT 'pending',
    due_date DATE NULL,
    deleted_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

---

# Environment Variables

The project uses database configuration variables.

Create a `.env` file or configure these values in `config/database.php`.

Example `.env.example`:

```
DB_HOST=localhost
DB_NAME=Task_Management
DB_USER=root
DB_PASS=

APP_URL=http://localhost/task-manager
```

### Variable Explanation

| Variable | Description                 |
| -------- | --------------------------- |
| DB_HOST  | Database server host        |
| DB_NAME  | MySQL database name         |
| DB_USER  | MySQL username              |
| DB_PASS  | MySQL password              |
| APP_URL  | Base URL of the application |

---

# Running the Application

After configuration, open your browser and visit:

```
http://localhost/task-manager
```

---

# Testing the API

Login through the browser first:

```
http://localhost/task-manager/auth/login.php
```

Then test the API endpoints.

Example:

```
http://localhost/task-manager/api/tasks.php
```

Example response:

```json
{
  "success": true,
  "data": []
}
```

---

# Security Practices

* Prepared statements with PDO
* SQL injection protection
* Password hashing
* Session-based authentication
* Users can only access their own tasks

---

# Assumptions

* Authentication is handled using PHP sessions.
* Tasks belong to the authenticated user.
* Soft delete is implemented using the `deleted_at` column.
* API endpoints require an authenticated session.
* The frontend is intentionally simple to focus on backend functionality.

---

# Author

Nadun Randeera

