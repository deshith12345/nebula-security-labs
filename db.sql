-- db.sql - Updated for ezyro.com hosting
CREATE DATABASE IF NOT EXISTS ezyro_40038148_vulnweb;
USE ezyro_40038148_vulnweb;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  password VARCHAR(50),
  flag VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password, flag) VALUES
('admin', 'admin123', 'FLAG{ADMIN_ACCESS}'),
('alice', 'alice123', 'FLAG{IDOR_ALICE_PROFILE}'),
('bob', 'bob123', 'FLAG{IDOR_BOB_PROFILE}');

INSERT INTO messages (name, message) VALUES
('system', 'Welcome to Nebula Security Labs contact page!');
