<?php
/**
 * Root Flowers Database Setup
 * Student: Neng Yi Chieng
 * 
 * This file handles:
 * - Database connection
 * - Table creation
 * - Sample data insertion
 */

// Database settings
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'RootFlower');

/**
 * Connect to database
 */
function getDBConnection(): mysqli {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
    
    if ($conn->connect_error) {
        die("Cannot connect to database: " . $conn->connect_error);
    }
    
    // Create database if doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
    if (!$conn->query($sql)) {
        die("Error creating database: " . $conn->error);
    }
    
    $conn->select_db(DB_NAME);
    return $conn;
}

/**
 * Create all tables needed for the system
 */
function createTables(): void {
    $conn = getDBConnection();
    
    // User profile table
    $userTable = "CREATE TABLE IF NOT EXISTS user_table (
        email VARCHAR(50) NOT NULL PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        dob DATE NULL,
        gender VARCHAR(6) NOT NULL,
        hometown VARCHAR(50) NOT NULL,
        profile_image VARCHAR(100) NULL,
        resume VARCHAR(100) NULL
    )";
    
    if (!$conn->query($userTable)) {
        die("Error creating user_table: " . $conn->error);
    }
    
    // Login credentials table
    $accountTable = "CREATE TABLE IF NOT EXISTS account_table (
        email VARCHAR(50) NOT NULL PRIMARY KEY,
        password VARCHAR(255) NOT NULL,
        type VARCHAR(5) NOT NULL DEFAULT 'user',
        FOREIGN KEY (email) REFERENCES user_table(email) ON DELETE CASCADE ON UPDATE CASCADE
    )";
    
    if (!$conn->query($accountTable)) {
        die("Error creating account_table: " . $conn->error);
    }
    
    // Flower database table
    $flowerTable = "CREATE TABLE IF NOT EXISTS flower_table (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        Scientific_Name VARCHAR(50) NOT NULL,
        Common_Name VARCHAR(50) NOT NULL,
        Plant_image VARCHAR(100) NULL,
        Description VARCHAR(100) NULL,
        contributor_email VARCHAR(50) NULL,
        contribution_date DATETIME NULL,
        status VARCHAR(20) DEFAULT 'approved',
        FOREIGN KEY (contributor_email) REFERENCES user_table(email) ON DELETE SET NULL ON UPDATE CASCADE
    )";
    
    if (!$conn->query($flowerTable)) {
        die("Error creating flower_table: " . $conn->error);
    }
    
    // Workshop registration table
    $workshopTable = "CREATE TABLE IF NOT EXISTS workshop_table (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(50) NOT NULL,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        date DATE NULL,
        time TIME NULL,
        contact_number VARCHAR(15) NULL,
        status VARCHAR(10) DEFAULT 'pending',
        FOREIGN KEY (email) REFERENCES user_table(email) ON DELETE CASCADE ON UPDATE CASCADE
    )";
    
    if (!$conn->query($workshopTable)) {
        die("Error creating workshop_table: " . $conn->error);
    }
    
    // 5. Create studentwork_table
    $studentworkTable = "CREATE TABLE IF NOT EXISTS studentwork_table (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        workshop_image VARCHAR(100) NULL,
        workshop_title VARCHAR(50) NOT NULL,
        status VARCHAR(10) DEFAULT 'pending',
        FOREIGN KEY (email) REFERENCES user_table(email) ON DELETE CASCADE ON UPDATE CASCADE
    )";
    
    if (!$conn->query($studentworkTable)) {
        die("Error creating studentwork_table: " . $conn->error);
    }
    
    $conn->close();
}

/**
 * Add sample data to database (runs only once)
 */
function populateDummyData(): void {
    $conn = getDBConnection();
    
    // Check if admin already exists - don't duplicate data
    $checkAdmin = $conn->query("SELECT email FROM user_table WHERE email = 'admin@swin.edu.my'");
    
    if ($checkAdmin && $checkAdmin->num_rows === 0) {
        // Insert admin into user_table
        $stmt = $conn->prepare("INSERT INTO user_table (email, first_name, last_name, dob, gender, hometown) VALUES (?, ?, ?, NULL, ?, ?)");
        $email = 'admin@swin.edu.my';
        $fname = 'Admin';
        $lname = 'User';
        $gender = 'Male';
        $hometown = 'Melbourne';
        $stmt->bind_param("sssss", $email, $fname, $lname, $gender, $hometown);
        $stmt->execute();
        $stmt->close();
        
        // Insert admin into account_table
        $stmt = $conn->prepare("INSERT INTO account_table (email, password, type) VALUES (?, ?, ?)");
        $email = 'admin@swin.edu.my';
        $password = password_hash('admin', PASSWORD_DEFAULT);
        $type = 'admin';
        $stmt->bind_param("sss", $email, $password, $type);
        $stmt->execute();
        $stmt->close();
    }
    
    // Add 4+ dummy users
    $dummyUsers = [
        ['email' => 'john@example.com', 'first_name' => 'John', 'last_name' => 'Doe', 'gender' => 'Male', 'hometown' => 'Sydney', 'password' => 'Test@123'],
        ['email' => 'jane@example.com', 'first_name' => 'Jane', 'last_name' => 'Smith', 'gender' => 'Female', 'hometown' => 'Brisbane', 'password' => 'Test@123'],
        ['email' => 'bob@example.com', 'first_name' => 'Bob', 'last_name' => 'Wilson', 'gender' => 'Male', 'hometown' => 'Perth', 'password' => 'Test@123'],
        ['email' => 'alice@example.com', 'first_name' => 'Alice', 'last_name' => 'Brown', 'gender' => 'Female', 'hometown' => 'Adelaide', 'password' => 'Test@123']
    ];
    
    foreach ($dummyUsers as $user) {
        $checkUser = $conn->query("SELECT email FROM user_table WHERE email = '{$user['email']}'");
        if ($checkUser && $checkUser->num_rows === 0) {
            // Insert into user_table
            $stmt = $conn->prepare("INSERT INTO user_table (email, first_name, last_name, dob, gender, hometown) VALUES (?, ?, ?, NULL, ?, ?)");
            $stmt->bind_param("sssss", $user['email'], $user['first_name'], $user['last_name'], $user['gender'], $user['hometown']);
            $stmt->execute();
            $stmt->close();
            
            // Insert into account_table
            $stmt = $conn->prepare("INSERT INTO account_table (email, password, type) VALUES (?, ?, 'user')");
            $hashedPwd = password_hash($user['password'], PASSWORD_DEFAULT);
            $stmt->bind_param("ss", $user['email'], $hashedPwd);
            $stmt->execute();
            $stmt->close();
        }
    }
    
    // Add sample flower data (at least 4)
    $flowers = [
        ['scientific' => 'Rosa', 'common' => 'Rose', 'image' => 'img/products/product_1.jpg', 'desc' => 'flower_description/rose.pdf'],
        ['scientific' => 'Gerbera jamesonii', 'common' => 'Gerbera Daisy', 'image' => 'img/products/product_2.jpg', 'desc' => 'flower_description/gerbera.pdf'],
        ['scientific' => 'Hydrangea', 'common' => 'Hydrangea', 'image' => 'img/products/product_4.jpg', 'desc' => 'flower_description/hydrangea.pdf'],
        ['scientific' => 'Dianthus caryophyllus', 'common' => 'Carnation', 'image' => 'img/products/product_3.jpg', 'desc' => 'flower_description/carnation.pdf']
    ];
    
    foreach ($flowers as $flower) {
        $checkFlower = $conn->query("SELECT id FROM flower_table WHERE Scientific_Name = '{$flower['scientific']}'");
        if ($checkFlower && $checkFlower->num_rows === 0) {
            $stmt = $conn->prepare("INSERT INTO flower_table (Scientific_Name, Common_Name, Plant_image, Description) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $flower['scientific'], $flower['common'], $flower['image'], $flower['desc']);
            $stmt->execute();
            $stmt->close();
        }
    }
    
    // Add dummy workshop registrations (at least 4)
    $workshops = [
        ['email' => 'john@example.com', 'first_name' => 'John', 'last_name' => 'Doe', 'date' => '2025-12-15', 'time' => '10:00:00', 'contact' => '0412345678'],
        ['email' => 'jane@example.com', 'first_name' => 'Jane', 'last_name' => 'Smith', 'date' => '2025-12-20', 'time' => '14:00:00', 'contact' => '0423456789'],
        ['email' => 'bob@example.com', 'first_name' => 'Bob', 'last_name' => 'Wilson', 'date' => '2025-12-22', 'time' => '11:00:00', 'contact' => '0434567890'],
        ['email' => 'alice@example.com', 'first_name' => 'Alice', 'last_name' => 'Brown', 'date' => '2025-12-25', 'time' => '15:00:00', 'contact' => '0445678901']
    ];
    
    foreach ($workshops as $ws) {
        $checkWS = $conn->query("SELECT id FROM workshop_table WHERE email = '{$ws['email']}' LIMIT 1");
        if ($checkWS && $checkWS->num_rows === 0) {
            $stmt = $conn->prepare("INSERT INTO workshop_table (email, first_name, last_name, date, time, contact_number, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
            $stmt->bind_param("ssssss", $ws['email'], $ws['first_name'], $ws['last_name'], $ws['date'], $ws['time'], $ws['contact']);
            $stmt->execute();
            $stmt->close();
        }
    }
    
    // Add dummy student works (at least 4)
    $studentWorks = [
        ['first_name' => 'John', 'last_name' => 'Doe', 'email' => 'john@example.com', 'image' => 'img/products/product_5.jpg', 'title' => 'Spring Bouquet Workshop'],
        ['first_name' => 'Jane', 'last_name' => 'Smith', 'email' => 'jane@example.com', 'image' => 'img/products/product_6.jpg', 'title' => 'Wedding Arrangement Course'],
        ['first_name' => 'Bob', 'last_name' => 'Wilson', 'email' => 'bob@example.com', 'image' => 'img/products/product_7.jpg', 'title' => 'Ikebana Basics'],
        ['first_name' => 'Alice', 'last_name' => 'Brown', 'email' => 'alice@example.com', 'image' => 'img/products/product_8.jpg', 'title' => 'Modern Floral Design']
    ];
    
    foreach ($studentWorks as $work) {
        $checkWork = $conn->query("SELECT id FROM studentwork_table WHERE email = '{$work['email']}' AND workshop_title = '{$work['title']}' LIMIT 1");
        if ($checkWork && $checkWork->num_rows === 0) {
            $stmt = $conn->prepare("INSERT INTO studentwork_table (first_name, last_name, email, workshop_image, workshop_title, status) VALUES (?, ?, ?, ?, ?, 'pending')");
            $stmt->bind_param("sssss", $work['first_name'], $work['last_name'], $work['email'], $work['image'], $work['title']);
            $stmt->execute();
            $stmt->close();
        }
    }
    
    $conn->close();
}

/**
 * Execute a prepared statement and return the result
 */
function executeQuery(string $sql, array $params = [], string $types = ''): mixed {
    $conn = getDBConnection();
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        $conn->close();
        return false;
    }
    
    if (!empty($params) && !empty($types)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $result = $stmt->execute();
    
    if (strpos(strtoupper($sql), 'SELECT') === 0) {
        $data = $stmt->get_result();
        $stmt->close();
        $conn->close();
        return $data;
    }
    
    $stmt->close();
    $conn->close();
    return $result;
}

// Automatically create database and tables when file is loaded
// Creates everything needed on first visit
createTables();
populateDummyData();
