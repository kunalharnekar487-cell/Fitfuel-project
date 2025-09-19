-- FitFuel Database Schema
CREATE DATABASE IF NOT EXISTS fitfuel_db;
USE fitfuel_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    original_price DECIMAL(10,2),
    category_id INT,
    image_url VARCHAR(255),
    stock_quantity INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    lab_report_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE IF NOT EXISTS cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_product (user_id, product_id)
);

-- Wishlist table
CREATE TABLE IF NOT EXISTS wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_product (user_id, product_id)
);

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'confirmed', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    payment_method ENUM('wallet', 'cod', 'online') NOT NULL,
    shipping_address TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Order items table
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Wallet transactions table
CREATE TABLE IF NOT EXISTS wallet_transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    type ENUM('credit', 'debit') NOT NULL,
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert sample categories
INSERT INTO categories (name, description) VALUES
('Protein', 'Whey protein, casein, and other protein supplements'),
('Creatine', 'Creatine monohydrate and other creatine variants'),
('Pre-Workout', 'Energy and focus supplements for workouts'),
('Mass Gainers', 'High-calorie supplements for muscle mass'),
('BCAA', 'Branched-chain amino acids for recovery'),
('Vitamins', 'Essential vitamins and minerals');

-- Insert sample products
INSERT INTO products (name, description, price, original_price, category_id, image_url, stock_quantity, lab_report_url) VALUES
('FitFuel Whey Protein Isolate', 'Premium whey isolate for muscle growth and recovery. 25g protein per serving.', 1899.00, 2599.00, 1, 'img/FITFUEL WHEY.jpg', 50, 'lab-pdf/whey protien lab reeport.png'),
('FitFuel Creatine Monohydrate', 'Pure creatine monohydrate for strength and power. 5g per serving.', 899.00, 1299.00, 2, 'img/creatine.png', 30, 'lab-pdf/creatine lab reports.png'),
('FitFuel Pre-Workout Blast', 'High-energy pre-workout formula with caffeine and beta-alanine.', 1299.00, 1799.00, 3, 'img/preworkout.png', 25, 'lab-pdf/preworkout reports.png'),
('FitFuel Mass Gainer Pro', 'High-calorie mass gainer with 50g protein and complex carbs.', 2499.00, 3299.00, 4, 'img/mass-gainer.png', 20, NULL),
('FitFuel BCAA Recovery', 'Essential amino acids for muscle recovery and endurance.', 999.00, 1499.00, 5, 'img/BCAA.png', 40, NULL),
('FitFuel Multivitamin', 'Complete daily vitamin and mineral supplement.', 599.00, 899.00, 6, 'img/multivitamin.png', 60, NULL);

-- Admin seeding handled by setup_database.php and migrate_users_table.php
