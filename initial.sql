CREATE DATABASE IF NOT EXISTS buddy;
USE buddy;

-- Drop tables if they exist
DROP TABLE IF EXISTS user_assignments;
DROP TABLE IF EXISTS control_status;
DROP TABLE IF EXISTS evidence;
DROP TABLE IF EXISTS assessment_objectives;
DROP TABLE IF EXISTS questions;
DROP TABLE IF EXISTS company_framework;
DROP TABLE IF EXISTS control_framework;
DROP TABLE IF EXISTS frameworks;
DROP TABLE IF EXISTS control_evidence_request;
DROP TABLE IF EXISTS evidence_requests;
DROP TABLE IF EXISTS controls;
DROP TABLE IF EXISTS domains;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS companies;

-- Create companies table
CREATE TABLE companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255),
    company_id INT,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    UNIQUE KEY (`email`)
);

-- Create domains table
CREATE TABLE domains (
    id INT AUTO_INCREMENT PRIMARY KEY,
    identifier VARCHAR(50) NOT NULL,
    name VARCHAR(255) NOT NULL,
    principles TEXT,
    intent TEXT
);

-- Create controls table
CREATE TABLE controls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    domain_id INT NOT NULL,
    identifier VARCHAR(50) NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    weight TINYINT,
    methods TEXT,
    pptdf_applicability ENUM('People', 'Process', 'Technology', 'Data', 'Facility'),
    nist_csf_function_grouping ENUM('Govern', 'Identify', 'Protect', 'Detect', 'Respond', 'Recover'),
    FOREIGN KEY (domain_id) REFERENCES domains(id)
);

-- Create evidence_requests table
CREATE TABLE evidence_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    identifier VARCHAR(50) NOT NULL,
    area VARCHAR(255),
    artifact VARCHAR(255),
    description TEXT
);

-- Create control_evidence_request table (many-to-many relationship)
CREATE TABLE control_evidence_request (
    id INT AUTO_INCREMENT PRIMARY KEY,
    control_id INT NOT NULL,
    evidence_request_id INT NOT NULL,
    FOREIGN KEY (control_id) REFERENCES controls(id),
    FOREIGN KEY (evidence_request_id) REFERENCES evidence_requests(id)
);

-- Create frameworks table
CREATE TABLE frameworks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    short_name VARCHAR(100) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    source VARCHAR(255),
    geography VARCHAR(100),
    version VARCHAR(50),
    url TEXT,
    identifier VARCHAR(100) NOT NULL,
    UNIQUE KEY (`short_name`),
    KEY (`full_name`, `version`)
);

-- Create control_framework table (many-to-many relationship)
CREATE TABLE control_framework (
    id INT AUTO_INCREMENT PRIMARY KEY,
    control_id INT NOT NULL,
    framework_id INT NOT NULL,
    framework_references JSON,
    FOREIGN KEY (control_id) REFERENCES controls(id),
    FOREIGN KEY (framework_id) REFERENCES frameworks(id)
);

-- Create company_framework table (many-to-many relationship)
CREATE TABLE company_framework (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    framework_id INT NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (framework_id) REFERENCES frameworks(id)
);

-- Create questions table
CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    control_id INT NOT NULL,
    question TEXT,
    level_0 TEXT,
    level_1 TEXT,
    level_2 TEXT,
    level_3 TEXT,
    level_4 TEXT,
    level_5 TEXT,
    FOREIGN KEY (control_id) REFERENCES controls(id)
);

-- Create assessment_objectives table
CREATE TABLE assessment_objectives (
    id INT AUTO_INCREMENT PRIMARY KEY,
    control_id INT NOT NULL,
    identifier VARCHAR(50),
    description TEXT,
    FOREIGN KEY (control_id) REFERENCES controls(id)
);

-- Create evidence table
CREATE TABLE evidence (
    id INT AUTO_INCREMENT PRIMARY KEY,
    control_id INT,
    title VARCHAR(255),
    description TEXT,
    added_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (control_id) REFERENCES controls(id),
    FOREIGN KEY (added_by) REFERENCES users(id)
);

-- Create control_status table
CREATE TABLE control_status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    control_id INT,
    status ENUM('pending', 'complete', 'in_progress'),
    updated_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (control_id) REFERENCES controls(id),
    FOREIGN KEY (updated_by) REFERENCES users(id)
);

-- Create user_assignments table
CREATE TABLE user_assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    assigned_by INT,
    assignment_type ENUM('control', 'evidence_request'),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (assigned_by) REFERENCES users(id)
);
