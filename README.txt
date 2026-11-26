NFC STUDENT PORTAL — SETUP

1. Install XAMPP and start Apache + MySQL.
2. Copy all project files to C:\\xampp\\htdocs\\nfc_student_portal\\
3. Open http://localhost/phpmyadmin/ and choose SQL.
4. Open setup.sql in a text editor, copy all SQL, paste it in phpMyAdmin and click Go.
5. Check db.php credentials. Default XAMPP is root with blank password.
6. Open http://localhost/nfc_student_portal/index.html
7. Search records at http://localhost/nfc_student_portal/students.php

HTML cannot save to MySQL on its own. index.html is the frontend; PHP files handle database operations. Never open index.html by double-clicking it; use localhost.

Security included: prepared statements, CSRF token validation, server-side validation, output escaping, unique roll numbers, basic security headers and secure session cookie flags. This is NOT fully production secure: it has no login/access roles. Do not expose it to the internet or store real sensitive student records until authentication, authorization, HTTPS, backups and deployment hardening are added.
