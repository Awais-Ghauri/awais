CREATE DATABASE IF NOT EXISTS nfc_student_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE nfc_student_portal;
CREATE TABLE IF NOT EXISTS students (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 roll_number VARCHAR(50) NOT NULL UNIQUE,
 full_name VARCHAR(120) NOT NULL,
 father_name VARCHAR(120) NOT NULL,
 email VARCHAR(190) NULL,
 phone VARCHAR(30) NOT NULL,
 gender VARCHAR(30) NULL,
 date_of_birth DATE NULL,
 department VARCHAR(100) NOT NULL,
 program VARCHAR(50) NOT NULL,
 semester TINYINT UNSIGNED NOT NULL,
 address VARCHAR(1000) NOT NULL,
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 INDEX idx_student_name (full_name),
 INDEX idx_student_roll (roll_number)
) ENGINE=InnoDB;