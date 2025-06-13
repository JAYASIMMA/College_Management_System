# 🎓 College Management System (PHP + MySQL)

A modern, role-based **College Management System** built using **PHP**, **MySQL**, **HTML5**, and **CSS3**, with a responsive and attractive UI. The system supports admin, faculty, and student roles with key academic and administrative functionalities.

---

## 🚀 Features

### 👨‍💼 Admin Panel
- Admin login with dashboard
- Manage students, faculty, courses, and subjects
- Assign subjects to faculty
- Post notices and announcements
- Monitor attendance and performance

### 👨‍🏫 Faculty Panel
- Faculty login with dashboard
- Mark student attendance
- Enter student marks per subject
- View personal assigned subjects and classes

### 🎓 Student Panel
- Student login with dashboard
- View personal profile
- View attendance records
- Check academic marks
- Read notice board messages

### 📌 Additional Highlights
- Modern and clean UI design
- Fully responsive layout
- Session-based authentication
- Password hashing for security
- Organized folder structure
- SQL schema included

---

## 🖼️ UI Preview

> _Add screenshots of your dashboard and pages here_  
> Example: ![Dashboard Preview
![Screenshot 2025-06-13 125436](https://github.com/user-attachments/assets/09d652ee-06a5-4996-a478-ebe155d7fa01)
![Screenshot 2025-06-13 125450](https://github.com/user-attachments/assets/2529f39b-c337-4113-97fd-3626c55f30fa)
![Screenshot 2025-06-13 125508](https://github.com/user-attachments/assets/1647c165-2f8b-4c25-a783-735526438809)
![Screenshot 2025-06-13 130721](https://github.com/user-attachments/assets/d4e9c2ae-3c2e-4dfb-a504-2f7b59270102)
![Screenshot 2025-06-13 130738](https://github.com/user-attachments/assets/ff6696ba-2a6a-4e80-a94c-7ed6d369e959)


---

## 🛠️ Tech Stack

| Tech           | Description              |
|----------------|--------------------------|
| PHP            | Backend development      |
| MySQL          | Relational database      |
| HTML5/CSS3     | Structure & styling      |
| JavaScript     | Front-end interactivity  |
| Font Awesome   | Icons in UI              |
| Google Fonts   | 'Poppins' typeface       |
| PDO            | Secure DB connection     |

---

## 🗂️ Folder Structure

```

college-management/
├── dashboard/         # Role-based dashboards
├── modules/           # Functional modules (course, marks, attendance)
├── includes/          # DB connection and session handler
├── assets/
│   ├── css/           # Custom stylesheets
│   └── js/            # JavaScript files
├── database/
│   └── college.sql    # MySQL DB structure
├── login.php
├── register.php
├── index.php
└── README.md

````

---

## ⚙️ Installation & Setup

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/yourusername/college-management-system.git
   cd college-management-system
``

2. **Setup Database:**

   * Import `college.sql` into your local MySQL server using PHPMyAdmin or CLI.

3. **Configure Database Connection:**

   * Open `/includes/db.php` and update the following:

     ```php
     $host = "localhost";
     $user = "root";
     $password = "";
     $dbname = "college_db";
     ```

4. **Run in Browser:**

   * Start Apache and MySQL (using XAMPP/WAMP/LAMP)
   * Navigate to: `http://localhost/college-management/`

---

## 🔐 Default Login Credentials (for testing)

| Role    | Username                                       | Password   |
| ------- | ---------------------------------------------- | ---------- |
| Admin   | [admin1@college.com](mailto:admin1@college.com)| admin123   |
| Faculty | [john@faculty.com](mailto:john@faculty.com)    | faculty123 |
| Student | [jane@student.com](mailto:jane@student.com)    | student123 |

> You can update or add users through the database or admin dashboard.

---

## 🎨 Color Palette

| Element    | Color Code  |
| ---------- | ----------- |
| Background | `#f9fbfd`   |
| Primary    | `#1e3a8a`   |
| Secondary  | `#3b82f6`   |
| Accent     | `#facc15`   |
| Font       | `'Poppins'` |

---

## 📌 Project Goals

* Simplify academic workflows
* Improve data accessibility for faculty and students
* Enhance admin control over academic and communication tasks
* Build with clean UI and scalable backend code

---

## 👨‍💻 Developer Notes

* Clean and modular code with comments
* Responsive UI using Flexbox/Grid
* Use of secure database interactions with PDO
* Passwords are hashed before storing

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

---

## ✨ Developed By

**Jayasimma D**
🔗 [LinkedIn](https://www.linkedin.com/in/jayasimma-d-4057ab27b/) • [GitHub](https://github.com/JAYASIMMA)

---

*Thank you for using this project! Contributions, feedback, and forks are welcome.*

