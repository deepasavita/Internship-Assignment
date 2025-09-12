-- Create the database
CREATE DATABASE IF NOT EXISTS product_catalog;
USE product_catalog;

-- Create the products table
CREATE TABLE IF NOT EXISTS products (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert 5 sample products
INSERT INTO products (name, price, category) VALUES
('Wireless Headphones', 7999.00, 'Electronics'),
('Running Shoes', 12999.00, 'Sports'),
('Coffee Maker', 4999.00, 'Home Appliances'),
('Python Programming Book', 399.00, 'Books'),
('Stainless Steel Water Bottle', 249.00, 'Kitchen');