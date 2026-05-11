-- GramBazar Premium Admin Panel Database Structure

-- Admin Table
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    profile_pic VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories Table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    icon VARCHAR(100),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Vendors Table
CREATE TABLE IF NOT EXISTS vendors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    address TEXT,
    shop_name VARCHAR(100),
    certificate_number VARCHAR(50) UNIQUE,
    profile_pic VARCHAR(255),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Delivery Boys Table
CREATE TABLE IF NOT EXISTS delivery_boys (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    address TEXT,
    id_card_number VARCHAR(50) UNIQUE,
    profile_pic VARCHAR(255),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Customers Table
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    address TEXT,
    profile_pic VARCHAR(255),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products Table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    discount_price DECIMAL(10,2) DEFAULT 0.00,
    category_id INT,
    vendor_id INT,
    image VARCHAR(255),
    stock INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (vendor_id) REFERENCES vendors(id) ON DELETE SET NULL
);

-- Orders Table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    customer_id INT,
    vendor_id INT,
    delivery_boy_id INT,
    total_amount DECIMAL(10,2) NOT NULL,
    shipping_charge DECIMAL(10,2) DEFAULT 0.00,
    status ENUM('new', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'new',
    payment_status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    payment_method VARCHAR(50),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    delivery_date DATE,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL,
    FOREIGN KEY (vendor_id) REFERENCES vendors(id) ON DELETE SET NULL,
    FOREIGN KEY (delivery_boy_id) REFERENCES delivery_boys(id) ON DELETE SET NULL
);

-- Order Items Table
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT,
    product_name VARCHAR(200) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

-- Banners Table
CREATE TABLE IF NOT EXISTS banners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    image_url VARCHAR(500),
    link_url VARCHAR(500),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Default Admin (Username: GramBazar, Password: GramBazar123)
INSERT INTO admin (username, password, full_name) VALUES 
('GramBazar', '$2y$10$lDYrPhb4tNznMCIctmlssOQ5YTmzUWYbddcMdrh4J6ckfpW58N4Tu', 'GramBazar Admin');

-- Insert Sample Data for Analytics
INSERT INTO categories (name, description) VALUES ('Electronics', 'Electronic gadgets'), ('Groceries', 'Daily essentials');
INSERT INTO vendors (name, shop_name, email, certificate_number) VALUES ('John Doe', 'John Electronics', 'john@example.com', 'VEND-001');
INSERT INTO delivery_boys (name, id_card_number, email) VALUES ('Fast Mike', 'DEL-001', 'mike@example.com');
INSERT INTO customers (name, email, phone) VALUES ('Alice Smith', 'alice@example.com', '1234567890');
INSERT INTO products (name, price, category_id, vendor_id, stock) VALUES ('Smartphone', 599.99, 1, 1, 50), ('Bread', 2.50, 2, 1, 100);

-- Insert Sample Orders for Today, Weekly, Monthly Analysis
INSERT INTO orders (order_number, customer_id, total_amount, status, order_date) VALUES 
('ORD-001', 1, 602.49, 'delivered', CURRENT_TIMESTAMP),
('ORD-002', 1, 5.00, 'shipped', DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 2 DAY)),
('ORD-003', 1, 1200.00, 'delivered', DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 10 DAY));
