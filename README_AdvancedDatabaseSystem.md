# 🗄️ Advanced Database Management System

A **web-based Library Management System** built using HTML, CSS, PHP, and MySQL. This project demonstrates full-stack web development with complete **CRUD (Create, Read, Update, Delete)** operations connected to a live database.

---

## 📌 About the Project

This system is a fully functional web application that manages library operations through a browser. It connects a PHP backend to a MySQL database, allowing users to manage books, members, and transactions in real time.

---

## 🛠️ Tools & Technologies

| Tool | Purpose |
|------|---------|
| HTML | Page structure and layout |
| CSS | Styling and responsive design |
| PHP | Server-side backend logic |
| MySQL | Database for storing all data |
| XAMPP / WAMP | Local server environment |
| phpMyAdmin | Database management interface |

---

## ✨ Features

- 🔐 **Admin Login** — Secure authentication system
- 📚 **Book Management** — Add, edit, delete, and search books
- 👥 **Member Management** — Register and manage library members
- 🔄 **Issue & Return** — Track which books are issued to which member
- 💰 **Fine Calculation** — Auto-calculate fines for overdue books
- 🔍 **Search & Filter** — Find books/members quickly
- 📊 **Dashboard** — Overview of all library activity

---

## 🚀 How to Run

1. Clone the repository:
   ```bash
   git clone https://github.com/sakinahassan568-eng/advance-database-management-system.git
   cd advance-database-management-system
   ```

2. Install **XAMPP** (or WAMP) and start **Apache** and **MySQL**.

3. Copy the project folder to:
   ```
   C:/xampp/htdocs/advance-database-management-system
   ```

4. Open **phpMyAdmin** at `http://localhost/phpmyadmin` and:
   - Create a new database (e.g., `library_db`)
   - Import the provided `.sql` file

5. Update database credentials in `config.php`:
   ```php
   $host = "localhost";
   $user = "root";
   $password = "";
   $database = "library_db";
   ```

6. Open your browser and go to:
   ```
   http://localhost/advance-database-management-system
   ```

---

## 🗃️ Database Schema

```
Tables:
├── books          (id, title, author, category, quantity, available)
├── members        (id, name, email, phone, join_date)
├── issued_books   (id, book_id, member_id, issue_date, return_date, fine)
└── admin          (id, username, password)
```

---

## 📂 Project Structure

```
advance-database-management-system/
├── index.php              # Login page
├── dashboard.php          # Admin dashboard
├── config.php             # Database connection
├── books/
│   ├── add_book.php
│   ├── edit_book.php
│   ├── delete_book.php
│   └── view_books.php
├── members/
│   ├── add_member.php
│   ├── edit_member.php
│   └── view_members.php
├── transactions/
│   ├── issue_book.php
│   └── return_book.php
├── css/
│   └── style.css
├── library_db.sql         # Database file
└── README.md
```

---

## 📖 Key Learning Outcomes

- Full-stack web development with PHP and MySQL
- Connecting frontend (HTML/CSS) to a backend database
- Implementing CRUD operations with SQL queries
- Session management for secure login
- Real-world database schema design

---

## 👩‍💻 Author

**Sakina Hassan**
BSCS Student — Fatima Jinnah Women University
GitHub: [@sakinahassan568-eng](https://github.com/sakinahassan568-eng)
