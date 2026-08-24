-- Clinic Management System database installer
-- Target: MariaDB/MySQL
-- This script intentionally does not access or modify the legacy `hospital` database.

CREATE DATABASE IF NOT EXISTS `hospital_rebuilt`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `hospital_rebuilt`;

CREATE TABLE IF NOT EXISTS `doctors` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `phone_number` VARCHAR(30) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_doctors_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `pharmacists` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `phone_number` VARCHAR(30) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_pharmacists_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `admins` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_admins_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `patients` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `age` TINYINT UNSIGNED NULL,
    `gender` VARCHAR(20) NULL,
    `problem` TEXT NULL,
    `entrance_date` DATE NULL,
    `phone_number` VARCHAR(30) NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_patients_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `drugs` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(200) NOT NULL,
    `dosage` VARCHAR(100) NOT NULL,
    `production_date` DATE NULL,
    `expiry_date` DATE NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_drugs_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `patients_doctor` (
    `patient_id` INT UNSIGNED NOT NULL,
    `doc_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`patient_id`, `doc_id`),
    KEY `idx_patients_doctor_doc_id` (`doc_id`),
    CONSTRAINT `fk_patients_doctor_patient`
        FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT `fk_patients_doctor_doctor`
        FOREIGN KEY (`doc_id`) REFERENCES `doctors` (`id`)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `patients_drugs` (
    `patient_id` INT UNSIGNED NOT NULL,
    `drug_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`patient_id`, `drug_id`),
    KEY `idx_patients_drugs_drug_id` (`drug_id`),
    CONSTRAINT `fk_patients_drugs_patient`
        FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT `fk_patients_drugs_drug`
        FOREIGN KEY (`drug_id`) REFERENCES `drugs` (`id`)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Demo accounts. Passwords are PHP password_hash() values.
INSERT IGNORE INTO `doctors` (`id`, `name`, `email`, `password`, `phone_number`) VALUES
    (1, 'Dr. Lina Ahmad', 'doctor.demo@clinic.test', '$2y$10$1YzCpfagwmDUnQi1zDJdHOM3EoH.r8rYWrGeyyWGUPVVQ1SU7q1e.', '0599001001');

INSERT IGNORE INTO `pharmacists` (`id`, `name`, `email`, `password`, `phone_number`) VALUES
    (1, 'Omar Khalil', 'pharmacist.demo@clinic.test', '$2y$10$MeVK7HEeLpi8cHDC0IxXy.JBJHkPEoNQGpc4oLeEcr6kS3tACrEHq', '0599002001');

INSERT IGNORE INTO `admins` (`id`, `name`, `email`, `password`) VALUES
    (1, 'Clinic Admin', 'admin.demo@clinic.test', '$2y$10$mSfcCl3dHt.rxFRnjGDnlulB4ERHkMYkEzDe9mUHVUWiS0EXZCB02');

INSERT IGNORE INTO `patients` (`id`, `name`, `email`, `password`, `age`, `gender`, `problem`, `entrance_date`, `phone_number`) VALUES
    (1, 'Maya Saleh', 'patient.demo@clinic.test', '$2y$10$bF6ADN/zSd/gbDWfUqYB8OHblrwMu64ZAX5Ijgg2RGCaIvZ0mEKma', 29, 'Female', 'Seasonal allergies', '2026-08-20', '0599003001'),
    (2, 'Yousef Nasser', 'patient2.demo@clinic.test', '$2y$10$bF6ADN/zSd/gbDWfUqYB8OHblrwMu64ZAX5Ijgg2RGCaIvZ0mEKma', 42, 'Male', 'Mild hypertension', '2026-08-21', '0599003002');

INSERT IGNORE INTO `drugs` (`id`, `name`, `dosage`, `production_date`, `expiry_date`) VALUES
    (1, 'Cetirizine', '10 mg once daily', '2026-01-15', '2028-01-15'),
    (2, 'Paracetamol', '500 mg as needed', '2026-02-10', '2029-02-10'),
    (3, 'Amlodipine', '5 mg once daily', '2026-03-05', '2028-03-05');

INSERT IGNORE INTO `patients_doctor` (`patient_id`, `doc_id`) VALUES
    (1, 1),
    (2, 1);

INSERT IGNORE INTO `patients_drugs` (`patient_id`, `drug_id`) VALUES
    (1, 1),
    (1, 2),
    (2, 3);
