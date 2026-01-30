-- ==========================================
-- MySQL Initialization Script
-- Opticas-Development
-- ==========================================

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS optica_local
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

-- Create application user
CREATE USER IF NOT EXISTS 'optica_user'@'%' IDENTIFIED BY 'optica_password';

-- Grant privileges
GRANT ALL PRIVILEGES ON optica_local.* TO 'optica_user'@'%';

-- Create test database
CREATE DATABASE IF NOT EXISTS optica_test
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

-- Grant test privileges
GRANT ALL PRIVILEGES ON optica_test.* TO 'optica_user'@'%';

-- Flush privileges
FLUSH PRIVILEGES;

-- ==========================================
-- Initial Data (optional)
-- ==========================================

-- Use production database
USE optica_local;

-- Create admin user table (if not using Shield)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert default admin user (CHANGE PASSWORD IN PRODUCTION!)
INSERT INTO users (email, username, password, active) VALUES
(
    'admin@opticas.local',
    'admin',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    1
)
ON DUPLICATE KEY UPDATE email = email;

-- ==========================================
-- Performance Optimization
-- ==========================================

-- Set query cache (MySQL 8.0 doesn't use this, but kept for reference)
-- SET GLOBAL query_cache_size = 67108864;
-- SET GLOBAL query_cache_type = ON;

-- Set innodb buffer pool (1GB for production, adjust as needed)
SET GLOBAL innodb_buffer_pool_size = 1073741824;

-- Set max connections
SET GLOBAL max_connections = 200;

-- Enable slow query log
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 2;

-- ==========================================
-- Done
-- ==========================================
