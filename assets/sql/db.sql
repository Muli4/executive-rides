CREATE DATABASE car_rental;

USE car_rental;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('customer', 'admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Cars Table
CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    model VARCHAR(100),
    brand VARCHAR(100),
    year INT,
    price_per_day DECIMAL(10,2),
    availability BOOLEAN DEFAULT TRUE,
    image VARCHAR(255)
);

-- Bookings Table
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    car_id INT,
    start_date DATE,
    end_date DATE,
    total_price DECIMAL(10,2),
    status ENUM('pending', 'confirmed', 'canceled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (car_id) REFERENCES cars(id)
);
