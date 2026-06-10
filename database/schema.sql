-- Nice Coffee POS Database Schema
-- Create database
CREATE DATABASE IF NOT EXISTS nicecoffee_pos;
USE nicecoffee_pos;

-- =====================================================
-- TABLE: users (Kasir/Admin)
-- =====================================================
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    role ENUM('admin', 'cashier') DEFAULT 'cashier',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_role (role)
);

-- =====================================================
-- TABLE: categories (Kategori Menu)
-- =====================================================
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    icon VARCHAR(50),
    color VARCHAR(10),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_active (is_active)
);

-- =====================================================
-- TABLE: products (Menu Item)
-- =====================================================
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    cost DECIMAL(10, 2),
    stock INT DEFAULT 0,
    image_url VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    INDEX idx_category (category_id),
    INDEX idx_active (is_active),
    INDEX idx_name (name)
);

-- =====================================================
-- TABLE: customers (Pelanggan/Member)
-- =====================================================
CREATE TABLE customers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) UNIQUE,
    email VARCHAR(100),
    address TEXT,
    points INT DEFAULT 0,
    total_spent DECIMAL(12, 2) DEFAULT 0,
    is_member BOOLEAN DEFAULT FALSE,
    member_level ENUM('bronze', 'silver', 'gold') DEFAULT 'bronze',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_phone (phone),
    INDEX idx_member (is_member)
);

-- =====================================================
-- TABLE: orders (Transaksi/Order)
-- =====================================================
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    user_id INT NOT NULL,
    customer_id INT,
    subtotal DECIMAL(12, 2) NOT NULL,
    tax DECIMAL(12, 2) DEFAULT 0,
    discount DECIMAL(12, 2) DEFAULT 0,
    total DECIMAL(12, 2) NOT NULL,
    payment_method ENUM('cash', 'card', 'transfer', 'other') DEFAULT 'cash',
    payment_status ENUM('pending', 'paid', 'refunded') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    INDEX idx_order_number (order_number),
    INDEX idx_user (user_id),
    INDEX idx_created (created_at),
    INDEX idx_payment_status (payment_status)
);

-- =====================================================
-- TABLE: order_items (Detail Order)
-- =====================================================
CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(12, 2) NOT NULL,
    notes VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id),
    INDEX idx_order (order_id),
    INDEX idx_product (product_id)
);

-- =====================================================
-- TABLE: stock_logs (Log Inventory)
-- =====================================================
CREATE TABLE stock_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    quantity_change INT NOT NULL,
    reason ENUM('initial', 'purchase', 'sale', 'adjustment', 'damage', 'return') DEFAULT 'adjustment',
    notes TEXT,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX idx_product (product_id),
    INDEX idx_created (created_at)
);

-- =====================================================
-- TABLE: settings (Pengaturan Aplikasi)
-- =====================================================
CREATE TABLE settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    key_name VARCHAR(100) UNIQUE NOT NULL,
    value LONGTEXT,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =====================================================
-- INSERT Default Data
-- =====================================================

-- Default Admin User
INSERT INTO users (username, password, full_name, email, phone, role, is_active) 
VALUES ('admin', SHA2('admin123', 256), 'Administrator', 'admin@nicecoffee.com', '081234567890', 'admin', TRUE);

-- Default Categories
INSERT INTO categories (name, description, color) VALUES
('Coffee', 'Berbagai pilihan kopi', '#8B4513'),
('Non-Coffee', 'Minuman tanpa kopi', '#FF69B4'),
('Food', 'Makanan dan snack', '#FFA500'),
('Dessert', 'Kue dan dessert', '#FFB6C1');

-- Default Products
INSERT INTO products (category_id, name, description, price, cost, stock) VALUES
(1, 'Espresso', 'Kopi espresso murni', 25000, 8000, 50),
(1, 'Americano', 'Kopi dengan air panas', 30000, 10000, 50),
(1, 'Cappuccino', 'Kopi dengan susu', 40000, 15000, 50),
(1, 'Latte', 'Kopi dengan banyak susu', 45000, 16000, 50),
(2, 'Teh Panas', 'Teh pilihan premium', 20000, 5000, 50),
(2, 'Jus Jeruk', 'Jus jeruk segar', 35000, 12000, 50),
(3, 'Roti Bakar', 'Roti bakar dengan selai', 28000, 10000, 30),
(4, 'Cake Cokelat', 'Kue cokelat homemade', 50000, 20000, 20);

-- Default Settings
INSERT INTO settings (key_name, value, description) VALUES
('outlet_name', 'Nice Coffee', 'Nama outlet'),
('outlet_address', 'Jl. Contoh No. 123, Jakarta', 'Alamat outlet'),
('outlet_phone', '021-1234567', 'Nomor telepon'),
('outlet_tax_id', 'NPWP: xxxxx', 'Nomor NPWP'),
('currency', 'IDR', 'Mata uang'),
('tax_percentage', '10', 'Persentase pajak (%)'),
('receipt_width', '80', 'Lebar kertas struk (mm)');
