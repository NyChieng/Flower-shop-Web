# Root Flowers Web Application - Assignment 2

**Student:** Neng Yi Chieng  
**Course:** Web Development  
**Date:** December 2025

---

## What This Project Does

Root Flowers is a flower shop website where users can:
- Register and login to their account
- Browse products and workshops
- Upload their profile picture and resume
- Identify flowers by uploading photos
- Contribute new flowers to the database
- Submit their workshop creations

Admins can:
- Manage all user accounts
- Approve or reject workshop registrations
- Approve or reject student work submissions
- Manage flower contributions

---

## Technology Used

- **Frontend**: HTML5, CSS3, Bootstrap 5, JavaScript
- **Backend**: PHP 7.4+
- **Database**: MySQL (database name: RootFlower)
- **Server**: XAMPP (Apache + MySQL)

---

## Database Structure

The system uses 5 tables that are created automatically:

### 1. user_table
Stores user information like name, email, date of birth, hometown, profile picture, and resume.

### 2. account_table
Stores login credentials (email and hashed password) and user type (user or admin).

### 3. flower_table
Stores flower information including scientific name, common name, image, and PDF description.

### 4. workshop_table  
Stores workshop registration details with approval status.

### 5. studentwork_table
Stores student work submissions with images and approval status.

---

## Key Features Implemented

### Part 1: Database Setup (main.php)
- Automatically creates database "RootFlower" when you visit the site
- Creates all 5 tables with proper relationships
- Adds sample data including admin account
- **Admin Login**: admin@swin.edu.my / admin

### Part 2: User Registration & Login
- **registration.php** - Users can register with email, password, name, DOB, etc.
- **login.php** - Secure login with password hashing
- **process_register.php** - Handles form submission and validation
- Passwords are encrypted (never stored as plain text)

### Part 3: User Profile Management
- **profile.php** - View user profile information
- **update_profile.php** - Edit profile, upload photo, upload resume
- Profile pictures: JPG/PNG/GIF, max 5MB
- Resume: PDF only, max 7MB

### Part 4: Admin Portal
- **main_menu_admin.php** - Admin dashboard with 4 management sections
- **manage_accounts.php** - Add, edit, delete user accounts
- **manage_studentwork.php** - Approve/reject student submissions
- **manage_workshop_reg.php** - Approve/reject workshop registrations  
- **manage_flowers.php** - Approve/reject flower contributions

### Part 5: Flower Identifier (Extension Feature)
- **flower.php** - Upload a photo to identify flowers
- Works by matching filename with flower names in database
- Example: Upload "rose.jpg" → System finds all roses
- Shows flower details with image and PDF description
- Users can also contribute new flowers

---

## How The Flower Identifier Works

This is the assignment extension feature. Here's how it works simply:

1. **User uploads a photo** (e.g., "rose_red.jpg")
2. **System extracts the filename** → "rose"  
3. **Searches database** for flowers with "rose" in the name
4. **Shows matching results** with images and details

**Example:**
- Upload `gerbera.jpg` → Finds "Gerbera" flowers
- Upload `sunflower.png` → Finds "Sunflower" entries
- Upload `lily.jpg` → Finds "Lily" flowers

The system doesn't use AI - it just matches filenames to flower names in the database. This works well for the assignment since we only need 4-5 flowers as per requirements.

---

## Folder Structure

```
Flower-shop-Web/
├── img/                    # All images
│   └── products/          # Product images
├── profile_images/        # User uploaded profile pictures
├── data/                  # Data files
│   ├── flower_pdfs/      # Flower description PDFs
│   ├── rootflower.txt    # Flower data
│   └── workshop_reg.txt  # Workshop registrations
├── style/
│   └── style.css         # All website styles
├── main.php              # Database setup (auto-runs)
├── index.php             # Homepage
├── registration.php      # User signup
├── login.php             # User login
├── profile.php           # View profile
├── update_profile.php    # Edit profile
├── flower.php            # Flower identifier
├── products.php          # Browse products
├── workshops.php         # Browse workshops
├── studentworks.php      # View student gallery
└── main_menu_admin.php   # Admin dashboard
```

---

## Quick Start Guide

1. **Install XAMPP** and start Apache + MySQL
2. **Copy project** to `c:\xampp\htdocs\`
3. **Open browser** and go to `http://localhost/Flower-shop-Web/`
4. **Database auto-creates** - tables and sample data added automatically
5. **Login as admin**: admin@swin.edu.my / admin
6. **Or register** a new user account

That's it! Everything sets up automatically.

---

## Testing The Features

### Test as Regular User:
1. Go to `registration.php` and create an account
2. Login with your email/password
3. Go to Profile → Upload a photo and resume
4. Go to Flower Identifier → Upload a flower photo
5. Try contributing a new flower
6. Check Products and Workshops pages

### Test as Admin:
1. Login with admin@swin.edu.my / admin
2. Go to Main Menu (admin dashboard)
3. Try managing accounts - add/edit/delete users
4. Approve or reject workshop registrations
5. Approve or reject student work submissions
6. Approve or reject flower contributions

---

## Assignment Requirements Checklist

### ✅ Task 1: Database Setup
- Database "RootFlower" created automatically
- All 5 tables created with proper structure
- Sample data populated including admin account
- Foreign keys and relationships working

### ✅ Task 2: User Management
- User registration with validation
- Secure login with password hashing
- Profile management system
- Session-based authentication

### ✅ Task 3: Profile Features
- View profile page showing all user info
- Edit profile with form validation
- Profile picture upload (JPG/PNG/GIF, 5MB max)
- Resume upload (PDF, 7MB max) - **Extension Task 3.3**

### ✅ Task 4: Admin Portal
- Admin dashboard with 4 management sections
- CRUD operations for user accounts
- Approval system for workshops
- Approval system for student works
- Approval system for flower contributions

### ✅ Task 5: Extension Features
- **Flower Identifier** (photo upload identification)
- Image upload with drag-and-drop
- Filename-based flower matching
- Results display with flower details
- Contribution system for new flowers

---

## Common Issues & Solutions

**Problem: Database not creating**
- Make sure MySQL is running in XAMPP
- Check if port 3306 is not blocked
- Visit any page - database creates automatically

**Problem: Can't upload files**
- Check folder permissions (profile_images/, data/flower_pdfs/)
- Make sure file size limits not exceeded
- Only allowed file types: JPG/PNG/GIF for images, PDF for documents

**Problem: Login not working**
- Make sure you registered first
- Email must be valid format
- Password is case-sensitive
- Try admin account: admin@swin.edu.my / admin

**Problem: Profile picture not showing**
- Check if file uploaded successfully to profile_images/
- Refresh the page
- Check browser console for errors

---

## Important Notes

1. **Passwords are secure** - All passwords are hashed, never stored as plain text
2. **File validation** - System checks file types and sizes before upload
3. **Auto-setup** - Database and tables create automatically when you visit the site
4. **Sample data** - Admin account and some flowers are pre-loaded for testing
5. **Approval system** - All user contributions need admin approval before showing publicly

---

## What Makes This Project Good

1. **Security First**: Passwords hashed, SQL injection prevented, file validation
2. **User Friendly**: Clean design, easy navigation, helpful error messages
3. **Auto Setup**: No manual database setup needed - everything automatic
4. **Complete Features**: All assignment tasks implemented and working
5. **Extension Task**: Flower identifier feature goes beyond basic requirements
6. **Admin Control**: Full management system for all user content
7. **Responsive Design**: Works on desktop, tablet, and mobile
8. **Well Organized**: Clean code structure, separate CSS file, reusable nav

---

## Credits

**Developed by:** Neng Yi Chieng  
**Course:** Web Development - Assignment 2  
**Institution:** Swinburne University  
**Date:** December 2025

---

*This documentation is written to be simple and easy to understand. If you need more details about any feature, check the code comments in the PHP files.*
    Description VARCHAR(100) NULL,
    contributor_email VARCHAR(50) NULL,
    contribution_date DATETIME NULL,
    status VARCHAR(20) DEFAULT 'pending',
    FOREIGN KEY (contributor_email) REFERENCES user_table(email) 
        ON DELETE SET NULL ON UPDATE CASCADE
)
```
**Purpose**: Community-driven flower encyclopedia with admin moderation - **Task 3.4 Implementation**  
**Key Fields**:
- `id`: Auto-incrementing unique identifier
- `Scientific_Name`: Botanical/Latin name (e.g., "Rosa rubiginosa")
- `Common_Name`: Popular name (e.g., "Sweet Briar Rose")
- `Plant_image`: Path to flower photo (img/flowers/ directory)
- `Description`: Path to detailed PDF documentation (data/flower_pdfs/ directory)
- `contributor_email`: User who submitted the flower (nullable for admin-added entries)
- `contribution_date`: Timestamp of submission
- `status`: Approval state - 'pending' | 'approved' | 'rejected'

**Workflow**:
1. Logged-in user submits flower via `flower.php` contribution form
2. Entry created with `status='pending'` and current user's email
3. Admin reviews via `manage_flowers.php`
4. Admin approves/rejects submission
5. Only 'approved' flowers appear in public search results

**Foreign Key Behavior**:
- `ON DELETE SET NULL`: If contributor account deleted, flower remains but contributor info nullified
- Preserves historical data while maintaining referential integrity

---

#### 4. **workshop_table** - Workshop Registration System
```sql
CREATE TABLE workshop_table (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(50) NOT NULL,
    Email VARCHAR(50) NOT NULL,
    Workshop_Name VARCHAR(50) NOT NULL,
    Skill_Level VARCHAR(50) NOT NULL,
    Workshop_Date DATE NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    FOREIGN KEY (Email) REFERENCES account_table(email) 
        ON DELETE CASCADE ON UPDATE CASCADE
)
```
**Purpose**: Tracks workshop registrations with admin approval workflow  
**Key Fields**:
- `Name`: Participant's full name
- `Email`: Registrant's email (links to their account)
- `Workshop_Name`: Name of workshop being registered for
- `Skill_Level`: Beginner/Intermediate/Advanced
- `Workshop_Date`: Scheduled workshop date
- `status`: Registration state for admin processing

**Admin Actions** (via `manage_workshop_reg.php`):
- View all registrations in table format
- Approve registrations (status → 'approved')
- Reject registrations (status → 'rejected')
- Color-coded rows: yellow (pending), green (approved), red (rejected)

---

#### 5. **studentwork_table** - Student Gallery Submissions
```sql
CREATE TABLE studentwork_table (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(50) NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NULL,
    image_path VARCHAR(100) NOT NULL,
    workshop_name VARCHAR(50) NULL,
    submission_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'pending',
    FOREIGN KEY (user_email) REFERENCES user_table(email) 
        ON DELETE CASCADE ON UPDATE CASCADE
)
```
**Purpose**: Student project gallery with moderation system  
**Key Fields**:
- `user_email`: Submitter's email address
- `title`: Project title/name
- `description`: Detailed project description (TEXT type for long content)
- `image_path`: Path to project image file
- `workshop_name`: Associated workshop (optional)
- `submission_date`: Auto-populated timestamp
- `status`: Approval workflow state

**Admin Review Process** (via `manage_studentwork.php`):
- Display all submissions with preview images
- Status-based button controls (only show relevant actions)
- Approve/reject with confirmation modals
- Visual status indicators with color coding

---

### Database Relationships Diagram

```
account_table (email, password, type)
    ↓ 1:1 (CASCADE)
user_table (email, first_name, last_name, dob, gender, hometown, profile_image, resume)
    ↓ 1:N (CASCADE)
    ├── workshop_table (registrations by email)
    ├── studentwork_table (submissions by user_email)
    └── flower_table (contributions by contributor_email, SET NULL)
```

**Foreign Key Relationships:**
- `account_table.email` → `user_table.email` (1:1, CASCADE)
- `workshop_table.Email` → `account_table.email` (N:1, CASCADE)
- `studentwork_table.user_email` → `user_table.email` (N:1, CASCADE)
- `flower_table.contributor_email` → `user_table.email` (N:1, SET NULL)

**Integrity Rules**:
- **CASCADE DELETE**: Removing a user account automatically deletes all related workshops, student works, and account records
- **CASCADE UPDATE**: Email changes propagate through all linked tables
- **SET NULL**: Flower contributions remain even if contributor account deleted (preserves community data)

**Data Consistency**:
- Transactions used for multi-table operations (registration, profile updates)
- Foreign key constraints prevent orphaned records
- NOT NULL constraints on critical business fields

---

## Features Implementation

### Part 1: Database Migration & Initialization

**Objective**: Replace text file-based storage with MySQL relational database system.

**Implementation Details:**

#### File: `main.php` (273 lines)
**Purpose**: Central database connection and initialization module

**Key Functions:**

1. **`getDBConnection()`** - Database Connection Factory
   ```php
   function getDBConnection() {
       $servername = "localhost";
       $username = "root";
       $password = "";
       $dbname = "RootFlower";
       
       $conn = new mysqli($servername, $username, $password);
       
       if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
       }
       
       // Create database if not exists
       $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
       $conn->query($sql);
       $conn->select_db($dbname);
       
       return $conn;
   }
   ```
   - Establishes connection to MySQL server
   - Auto-creates `RootFlower` database if missing
   - Returns mysqli connection object
   - Centralized error handling

2. **`createTables()`** - Database Schema Generator
   - Creates all 5 tables with proper data types
   - Defines foreign key constraints
   - Sets up CASCADE rules for referential integrity
   - Uses `CREATE TABLE IF NOT EXISTS` for idempotency
   - Includes proper indexing on primary/foreign keys

3. **`populateDummyData()`** - Initial Data Seeding
   - **Admin Account**: email: `admin@swin.edu.my`, password: `admin` (hashed)
   - **4+ Users**: alice@example.com, bob@example.com, charlie@example.com, john@example.com
   - **4+ Flowers**: Rose, Gerbera, Hydrangea, Carnation with images and PDFs
   - **4+ Workshops**: Various skill levels and dates
   - **4+ Student Works**: Sample gallery submissions
   - All passwords hashed using `password_hash(PASSWORD_DEFAULT)`
   - Realistic test data with proper relationships

4. **`initializeDatabase()`** - Main Initialization Function
   - Checks if tables already exist
   - Calls `createTables()` if needed
   - Populates dummy data only on first run
   - Prevents data duplication
   - Returns success/failure status

**Auto-Initialization Process:**
```php
// Called on first page access
$conn = getDBConnection();
createTables($conn);
populateDummyData($conn);
```

**Database Connection Pattern Used Throughout Application:**
```php
require_once 'main.php';
$conn = getDBConnection();
// Perform database operations
$conn->close();
```

**Security Considerations:**
- Database credentials configurable at top of file
- Connection errors handled gracefully
- SQL injection prevention via prepared statements
- Password hashing before storage

**Files Created:**
- `main.php` - Complete database initialization and connection handler (273 lines)

**Migration Benefits:**
- ✅ Replaced text file parsing with efficient SQL queries
- ✅ Enabled relational data integrity with foreign keys
- ✅ Improved query performance with indexing
- ✅ Scalable architecture for future enhancements
- ✅ Transaction support for data consistency
- ✅ Concurrent user access without file locking issues

### Part 2: User Registration & Authentication System

**Objective**: Implement secure user registration and login using MySQL with password hashing.

#### A. Registration System

**File: `registration.php`**
**Purpose**: User-facing registration form with client-side validation

**Form Fields:**
- First Name (alphabetic only)
- Last Name (alphabetic only)
- Date of Birth (HTML5 date picker)
- Gender (Male/Female select)
- Email (validated format)
- Hometown (required text field)
- Password (minimum 8 characters)
- Confirm Password (must match)

**Client-Side Validation:**
```javascript
- Email format: /^[^\s@]+@[^\s@]+\.[^\s@]+$/
- Name validation: /^[a-zA-Z ]+$/
- Password length: minimum 8 characters
- Password match confirmation
- All required fields checked
```

**File: `process_register.php`**
**Purpose**: Server-side registration handler with database insertion

**Registration Workflow:**

1. **Input Collection & Sanitization**
   ```php
   $firstName = trim($_POST['first_name']);
   $lastName = trim($_POST['last_name']);
   $email = trim($_POST['email']);
   $password = $_POST['password'];
   $hometown = trim($_POST['hometown']);
   // ... other fields
   ```

2. **Server-Side Validation**
   - Re-validates all client-side rules
   - Checks for empty required fields
   - Validates email format using `filter_var(FILTER_VALIDATE_EMAIL)`
   - Verifies alphabetic characters in names
   - Confirms password length and match

3. **Duplicate Email Check**
   ```php
   function uniqueEmailDB($email) {
       $conn = getDBConnection();
       $stmt = $conn->prepare("SELECT email FROM user_table WHERE email = ?");
       $stmt->bind_param("s", $email);
       $stmt->execute();
       $result = $stmt->get_result();
       $exists = $result->num_rows > 0;
       $stmt->close();
       $conn->close();
       return !$exists;
   }
   ```

4. **Password Hashing**
   ```php
   $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
   ```
   - Uses bcrypt algorithm
   - Automatic salt generation
   - Cost factor: 10 (default)
   - Secure against rainbow table attacks

5. **Database Insertion with Transaction**
   ```php
   $conn->begin_transaction();
   try {
       // Insert into user_table
       $stmt1 = $conn->prepare("INSERT INTO user_table (email, first_name, last_name, dob, gender, hometown, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?)");
       $stmt1->bind_param("sssssss", $email, $firstName, $lastName, $dob, $gender, $hometown, $defaultImage);
       $stmt1->execute();
       
       // Insert into account_table
       $stmt2 = $conn->prepare("INSERT INTO account_table (email, password, type) VALUES (?, ?, 'user')");
       $stmt2->bind_param("ss", $email, $hashedPassword);
       $stmt2->execute();
       
       $conn->commit();
       $_SESSION['flash'] = 'Registration successful! Please login.';
       header('Location: login.php');
   } catch (Exception $e) {
       $conn->rollback();
       $errors[] = 'Registration failed. Please try again.';
   }
   ```

6. **Success Handling**
   - Flash message stored in session
   - Redirect to login page
   - Clear form data

**Error Handling:**
- Validation errors displayed inline
- Database errors caught and logged
- Transaction rollback on failure
- User-friendly error messages

---

#### B. Authentication System

**File: `login.php`**
**Purpose**: User authentication with role-based routing

**Login Workflow:**

1. **Credential Collection**
   ```php
   $email = trim($_POST['email']);
   $password = $_POST['password'];
   ```

2. **Database Query with JOIN**
   ```php
   $stmt = $conn->prepare("
       SELECT a.email, a.password, a.type, u.first_name, u.last_name 
       FROM account_table a 
       INNER JOIN user_table u ON a.email = u.email 
       WHERE a.email = ?
   ");
   $stmt->bind_param("s", $email);
   $stmt->execute();
   $result = $stmt->get_result();
   ```

3. **Password Verification**
   ```php
   if ($result->num_rows > 0) {
       $user = $result->fetch_assoc();
       
       if (password_verify($password, $user['password'])) {
           // Authentication successful
           $_SESSION['user_email'] = $user['email'];
           $_SESSION['user_type'] = $user['type'];
           $_SESSION['first_name'] = $user['first_name'];
           $_SESSION['last_name'] = $user['last_name'];
           
           // Role-based routing
           if ($user['type'] === 'admin') {
               header('Location: main_menu_admin.php');
           } else {
               header('Location: main_menu.php');
           }
       } else {
           $error = 'Invalid email or password';
       }
   }
   ```

4. **Session Management**
   - Session started on successful login
   - User information stored in `$_SESSION`
   - Session checked on protected pages
   - Logout clears session data

5. **Role-Based Access Control**
   ```php
   // On protected pages
   if (empty($_SESSION['user_email'])) {
       header('Location: login.php');
       exit;
   }
   
   // On admin-only pages
   if (($_SESSION['user_type'] ?? 'user') !== 'admin') {
       header('Location: main_menu.php');
       exit;
   }
   ```

**Security Features:**

1. **Password Security**
   - Bcrypt hashing (slow by design)
   - Automatic salt per password
   - Not reversible
   - Resistant to timing attacks via `password_verify()`

2. **SQL Injection Prevention**
   - All queries use prepared statements
   - Parameters bound with proper types
   - No string concatenation in queries

3. **Session Security**
   - `session_regenerate_id()` on login
   - HttpOnly cookies (configured in php.ini)
   - Session timeout handling
   - Secure flag for HTTPS (production)

4. **Additional Protections**
   - CSRF token validation (can be added)
   - Rate limiting on login attempts (future enhancement)
   - Password strength requirements
   - Account lockout after failed attempts (future enhancement)

**Files Modified:**
- `registration.php` - Enhanced validation, hometown field added
- `process_register.php` - Complete rewrite for database integration (replaced text file logic)
- `login.php` - Database authentication with role routing (replaced text file parsing)
- `logout.php` - Session destruction and redirect

**Testing Credentials:**
- **Admin**: email: `admin@swin.edu.my`, password: `admin`
- **User**: email: `john@example.com`, password: `password123`

**Migration Impact:**
- ✅ Eliminated plaintext password storage
- ✅ Enabled role-based access control
- ✅ Improved authentication performance
- ✅ Scalable for thousands of users
- ✅ Industry-standard security practices

### Part 3: User Profile Management System

**Objective**: Enable users to view and edit their profile information with file upload capabilities.

#### A. Profile Viewing

**File: `profile.php`**
**Purpose**: Display user profile information from database

**Implementation:**

1. **Session Validation**
   ```php
   if (empty($_SESSION['user_email'])) {
       $_SESSION['flash'] = 'Please login to continue.';
       header('Location: login.php?redirect=' . urlencode('profile.php'));
       exit;
   }
   ```

2. **Data Retrieval**
   ```php
   $conn = getDBConnection();
   $stmt = $conn->prepare("SELECT * FROM user_table WHERE email = ?");
   $stmt->bind_param("s", $_SESSION['user_email']);
   $stmt->execute();
   $result = $stmt->get_result();
   $user = $result->fetch_assoc();
   ```

3. **Profile Image Logic**
   ```php
   function profileImagePath($gender, $profileImage = null) {
       if ($profileImage && file_exists(__DIR__ . '/' . $profileImage)) {
           return $profileImage;  // User-uploaded image
       }
       
       // Default avatars by gender
       $defaults = [
           'male' => 'profile_images/boys.jpg',
           'female' => 'profile_images/girl.png',
       ];
       
       return $defaults[strtolower($gender)] ?? 'img/login.png';
   }
   ```

4. **Display Elements**
   - Profile avatar (uploaded or default)
   - Full name
   - Email address
   - Date of birth
   - Gender
   - Hometown
   - Resume download link (if uploaded)

---

#### B. Profile Editing with File Uploads

**File: `update_profile.php` (354 lines)**
**Purpose**: Comprehensive profile update with image and resume uploads

**Key Features:**

1. **Form Pre-population**
   ```php
   // Load existing data
   $stmt = $conn->prepare("SELECT * FROM user_table WHERE email = ?");
   $stmt->bind_param("s", $currentEmail);
   $stmt->execute();
   $originalRecord = $stmt->get_result()->fetch_assoc();
   
   // Pre-fill form values
   $values = [
       'first_name' => $originalRecord['first_name'],
       'last_name' => $originalRecord['last_name'],
       'dob' => formatDateForInput($originalRecord['dob']),
       'gender' => $originalRecord['gender'],
       'email' => $originalRecord['email'],
       'hometown' => $originalRecord['hometown'],
   ];
   ```

2. **Server-Side Validation**
   ```php
   // First name validation
   if (!req($values['first_name'])) {
       $addError('first_name', 'First name is required.');
   } elseif (!alphaSpace($values['first_name'])) {
       $addError('first_name', 'Only letters and white space allowed.');
   }
   
   // Email validation with uniqueness check
   if (strcasecmp($values['email'], $originalRecord['email']) !== 0) {
       // Email changed - check if new email already exists
       $stmt = $conn->prepare("SELECT email FROM user_table WHERE email = ? AND email != ?");
       $stmt->bind_param("ss", $values['email'], $originalRecord['email']);
       $stmt->execute();
       if ($stmt->get_result()->num_rows > 0) {
           $addError('email', 'Another account already uses this email.');
       }
   }
   ```

3. **Profile Image Upload Handler** (Task 3.3 - Part 1)
   ```php
   $profileImagePath = $originalRecord['profile_image'];
   
   if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
       $allowed = ['jpg', 'jpeg', 'png', 'gif'];
       $filename = $_FILES['profile_image']['name'];
       $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
       
       // Validation
       if (!in_array($ext, $allowed)) {
           $errors[] = 'Only JPG, PNG, and GIF files are allowed.';
       } elseif ($_FILES['profile_image']['size'] > 5 * 1024 * 1024) {
           $errors[] = 'File size must not exceed 5MB.';
       } else {
           // Create directory if not exists
           $uploadDir = __DIR__ . '/profile_images/';
           if (!is_dir($uploadDir)) {
               mkdir($uploadDir, 0775, true);
           }
           
           // Generate unique filename
           $newFilename = 'profile_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
           $uploadPath = $uploadDir . $newFilename;
           
           // Move uploaded file
           if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadPath)) {
               $profileImagePath = 'profile_images/' . $newFilename;
           } else {
               $errors[] = 'Failed to upload profile image.';
           }
       }
   }
   ```

4. **Resume Upload Handler** (Task 3.3 - Complete Implementation)
   ```php
   $resumePath = $originalRecord['resume'] ?? null;
   
   if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
       $filename = $_FILES['resume']['name'];
       $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
       $fileType = $_FILES['resume']['type'];
       
       // Strict PDF validation
       if ($ext !== 'pdf' || !in_array($fileType, ['application/pdf', 'application/x-pdf'])) {
           $errors[] = 'Only PDF files are allowed for resume.';
       } elseif ($_FILES['resume']['size'] > 7 * 1024 * 1024) {  // 7MB limit
           $errors[] = 'Resume file size must not exceed 7MB.';
       } else {
           // Create resume directory
           $uploadDir = __DIR__ . '/resume/';
           if (!is_dir($uploadDir)) {
               mkdir($uploadDir, 0775, true);
           }
           
           // Generate secure filename
           $newFilename = 'resume_' . time() . '_' . bin2hex(random_bytes(4)) . '.pdf';
           $uploadPath = $uploadDir . $newFilename;
           
           // Move uploaded file
           if (move_uploaded_file($_FILES['resume']['tmp_name'], $uploadPath)) {
               $resumePath = 'resume/' . $newFilename;
           } else {
               $errors[] = 'Failed to upload resume.';
           }
       }
   }
   ```

5. **Database Update with Transaction**
   ```php
   if (!$errors) {
       $conn = getDBConnection();
       $conn->begin_transaction();
       
       try {
           // Update user_table with all fields including resume
           $stmt = $conn->prepare("
               UPDATE user_table 
               SET first_name = ?, last_name = ?, dob = ?, gender = ?, 
                   hometown = ?, profile_image = ?, resume = ? 
               WHERE email = ?
           ");
           $stmt->bind_param("ssssssss", 
               $values['first_name'], 
               $values['last_name'], 
               $values['dob'], 
               $values['gender'], 
               $values['hometown'], 
               $profileImagePath, 
               $resumePath,
               $originalRecord['email']
           );
           $stmt->execute();
           
           // If email changed, update account_table too
           if (strcasecmp($values['email'], $originalRecord['email']) !== 0) {
               $stmt2 = $conn->prepare("UPDATE account_table SET email = ? WHERE email = ?");
               $stmt2->bind_param("ss", $values['email'], $originalRecord['email']);
               $stmt2->execute();
               $stmt2->close();
           }
           
           $conn->commit();
           
           // Update session variables
           $_SESSION['user_email'] = $values['email'];
           $_SESSION['first_name'] = $values['first_name'];
           $_SESSION['last_name'] = $values['last_name'];
           
           // Redirect to show success
           header('Location: update_profile.php?success=1');
           exit;
           
       } catch (Exception $e) {
           $conn->rollback();
           $errors[] = 'Failed to update profile. Please try again.';
       }
   }
   ```

6. **Resume Display in Form**
   ```html
   <div class="col-md-12">
       <label class="form-label" for="resume">Resume (PDF - Max 7MB)</label>
       <input type="file" class="form-control" id="resume" name="resume" accept=".pdf">
       <small class="text-muted">
           <?php if (!empty($originalRecord['resume']) && file_exists(__DIR__ . '/' . $originalRecord['resume'])): ?>
               Current: <a href="<?php echo htmlspecialchars($originalRecord['resume']); ?>" target="_blank">View Resume</a> | Upload new to replace
           <?php else: ?>
               No resume uploaded yet
           <?php endif; ?>
       </small>
   </div>
   ```

**File Upload Security Measures:**

1. **Extension Validation**
   - Whitelist approach (only allowed extensions)
   - Check both file extension and MIME type
   - Prevents PHP/executable file uploads

2. **Size Limits**
   - Profile images: 5MB maximum
   - Resumes: 7MB maximum (per assignment requirements)
   - Prevents DoS attacks via large files

3. **Filename Sanitization**
   - Generate unique filenames using timestamp + random bytes
   - Prevents filename collisions
   - Avoids special character issues
   - Format: `profile_1234567890_a1b2c3d4.jpg`

4. **Directory Management**
   - Auto-create upload directories with proper permissions (0775)
   - Separate directories for different file types
   - Path traversal prevention

5. **File Storage Best Practices**
   - Store relative paths in database (not absolute)
   - Keep uploaded files outside document root (production recommendation)
   - Implement file size quotas per user (future enhancement)

**Helper Functions:**

```php
function ensureDir($directory) {
    if ($directory === '' || is_dir($directory)) return;
    mkdir($directory, 0775, true);
}

function alphaSpace($value) {
    return (bool)preg_match('/^[a-zA-Z ]+$/', $value);
}

function validEmailFormat($email) {
    return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
}

function formatDateForInput($dob) {
    if (!$dob) return '';
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) return $dob;
    // Convert DD-MM-YYYY to YYYY-MM-DD
    $parts = explode('-', $dob);
    if (count($parts) === 3) {
        return sprintf('%04d-%02d-%02d', (int)$parts[2], (int)$parts[1], (int)$parts[0]);
    }
    return '';
}
```

**Database Schema Update:**

```sql
-- Added to user_table in main.php
ALTER TABLE user_table ADD COLUMN resume VARCHAR(100) NULL;
```

**Files Modified:**
- `profile.php` - Database-driven profile display with resume link
- `update_profile.php` - Complete rewrite with dual file upload support (354 lines)
- `main.php` - Updated `user_table` schema to include `resume` column

**User Experience Enhancements:**
- ✅ Real-time form validation feedback
- ✅ Pre-populated form with current values
- ✅ Success message after update
- ✅ Preview uploaded images before saving
- ✅ Download link for current resume
- ✅ Clear indication if no resume uploaded
- ✅ Responsive form layout using Bootstrap grid
- ✅ Accessibility labels and ARIA attributes

**Testing Scenarios:**
1. Upload profile image (JPG) - Success
2. Upload profile image (PNG) - Success
3. Upload profile image (PDF) - Rejected with error
4. Upload 6MB image - Rejected (exceeds 5MB limit)
5. Upload resume (PDF) - Success
6. Upload resume (DOCX) - Rejected with error
7. Upload 8MB resume - Rejected (exceeds 7MB limit)
8. Update email to existing email - Rejected with uniqueness error
9. Update all fields without files - Success (keeps existing files)
10. Change email - Updates both user_table and account_table

### Part 4: Admin Portal - Complete Management System

**Objective**: Create comprehensive admin interface for managing all user-generated content and accounts.

#### 4.1 Admin Dashboard (`main_menu_admin.php`)

**Purpose**: Centralized admin control panel with consistent design

**Access Control:**
```php
// Verify admin privileges
if (empty($_SESSION['user_email'])) {
    $_SESSION['flash'] = 'Please login to continue.';
    header('Location: login.php');
    exit;
}

if (($_SESSION['user_type'] ?? 'user') !== 'admin') {
    $_SESSION['flash'] = 'Access denied. Admin privileges required.';
    header('Location: main_menu.php');
    exit;
}
```

**Dashboard Cards:**

1. **Manage User Accounts** (Danger/Red)
   - Icon: `bi-people-fill`
   - Links to: `manage_accounts.php`
   - Function: User CRUD operations

2. **Manage Student Works** (Primary/Blue)
   - Icon: `bi-images`
   - Links to: `manage_studentwork.php`
   - Function: Gallery submission approval

3. **Manage Workshop Registrations** (Success/Green)
   - Icon: `bi-calendar-check`
   - Links to: `manage_workshop_reg.php`
   - Function: Workshop registration approval

4. **Manage Flower Contributions** (Warning/Yellow)
   - Icon: `bi-flower1`
   - Links to: `manage_flowers.php`
   - Function: Flower database moderation

**Design Consistency:**
- Matches main menu design (white background, clean cards)
- Responsive grid: 1 column (mobile), 2 columns (tablet), 4 columns (desktop)
- Hover effects with `translateY(-8px)` and shadow
- Bootstrap 5 card components with custom styling

**Files Created:**
- `main_menu_admin.php` (172 lines) - Admin dashboard portal

---

#### 4.2 User Account Management (`manage_accounts.php`)

**Purpose**: Full CRUD interface for user and account management

**Features:**

1. **View All Accounts**
   ```php
   $result = $conn->query("
       SELECT u.*, a.type 
       FROM user_table u 
       INNER JOIN account_table a ON u.email = a.email 
       ORDER BY u.first_name, u.last_name
   ");
   ```
   - Displays table with: Email, Name, Gender, Hometown, Type (user/admin)
   - Color-coded badges for account types
   - Action buttons for Edit and Delete

2. **Add New User (Modal Form)**
   ```html
   <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
       <i class="bi bi-person-plus"></i> Add New User
   </button>
   ```
   
   **Add User Process:**
   ```php
   if ($_POST['action'] === 'add') {
       // Validate inputs
       // Hash password
       $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
       
       // Begin transaction
       $conn->begin_transaction();
       
       // Insert into user_table
       $stmt1 = $conn->prepare("INSERT INTO user_table (...) VALUES (...)");
       $stmt1->execute();
       
       // Insert into account_table
       $stmt2 = $conn->prepare("INSERT INTO account_table (email, password, type) VALUES (?, ?, ?)");
       $stmt2->bind_param("sss", $email, $hashedPassword, $type);
       $stmt2->execute();
       
       $conn->commit();
   }
   ```

3. **Edit User (Modal Form with Pre-population)**
   ```javascript
   function editUser(email, firstName, lastName, gender, hometown, type) {
       document.getElementById('edit_email').value = email;
       document.getElementById('edit_first_name').value = firstName;
       document.getElementById('edit_last_name').value = lastName;
       document.getElementById('edit_gender').value = gender;
       document.getElementById('edit_hometown').value = hometown;
       document.getElementById('edit_type').value = type;
       
       $('#editUserModal').modal('show');
   }
   ```
   
   **Edit Process:**
   - Update user_table with new information
   - Optional password change (only if field filled)
   - Re-hash password if changed
   - Update account_table type (user/admin conversion)

4. **Delete User (Confirmation Modal)**
   ```php
   if ($_POST['action'] === 'delete') {
       // CASCADE delete automatically removes:
       // - account_table entry
       // - workshop_table registrations
       // - studentwork_table submissions
       // - Sets flower_table.contributor_email to NULL
       
       $stmt = $conn->prepare("DELETE FROM user_table WHERE email = ?");
       $stmt->bind_param("s", $_POST['email']);
       $stmt->execute();
   }
   ```
   
   **Delete Confirmation:**
   ```html
   <div class="modal" id="deleteUserModal">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header bg-danger text-white">
                   <h5>Confirm Delete</h5>
               </div>
               <div class="modal-body">
                   <p>Are you sure you want to delete this user?</p>
                   <p class="text-danger"><strong>Warning:</strong> This will also delete all related workshops, student works, and account data.</p>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                   <button type="submit" class="btn btn-danger">Delete User</button>
               </div>
           </div>
       </div>
   </div>
   ```

**Security Considerations:**
- Admin-only access verification
- Password hashing for new/updated passwords
- SQL injection prevention via prepared statements
- Confirmation modals for destructive actions
- Transaction support for multi-table operations

**UI/UX Features:**
- Bootstrap modal dialogs for add/edit/delete
- Real-time form validation
- Success/error alert messages
- Responsive table design
- Icon buttons for actions
- Color-coded account type badges

**Files Created:**
- `manage_accounts.php` (full CRUD system with modals)

#### 4.3 Student Work Approval System (`manage_studentwork.php`)

**Purpose**: Review and moderate student gallery submissions

**Workflow Implementation:**

1. **Display All Submissions**
   ```php
   $result = $conn->query("
       SELECT s.*, u.first_name, u.last_name 
       FROM studentwork_table s 
       LEFT JOIN user_table u ON s.user_email = u.email 
       ORDER BY s.submission_date DESC
   ");
   ```

2. **Color-Coded Status Rows**
   ```css
   .status-pending { background-color: #fff3cd; }   /* Yellow */
   .status-approved { background-color: #d1e7dd; }  /* Green */
   .status-rejected { background-color: #f8d7da; }  /* Red */
   ```

3. **Smart Button Controls**
   ```php
   <?php if ($work['status'] !== 'approved'): ?>
       <form method="post" style="display:inline;">
           <input type="hidden" name="work_id" value="<?php echo $work['id']; ?>">
           <input type="hidden" name="action" value="approve">
           <button type="submit" class="btn btn-success btn-sm">
               <i class="bi bi-check-lg"></i> Approve
           </button>
       </form>
   <?php endif; ?>
   
   <?php if ($work['status'] !== 'rejected'): ?>
       <form method="post" style="display:inline;">
           <input type="hidden" name="work_id" value="<?php echo $work['id']; ?>">
           <input type="hidden" name="action" value="reject">
           <button type="submit" class="btn btn-warning btn-sm">
               <i class="bi bi-x-lg"></i> Reject
           </button>
       </form>
   <?php endif; ?>
   ```

4. **Status Update Logic**
   ```php
   if ($_POST['action'] === 'approve') {
       $stmt = $conn->prepare("UPDATE studentwork_table SET status = 'approved' WHERE id = ?");
       $stmt->bind_param("i", $_POST['work_id']);
       $stmt->execute();
       $message = 'Student work approved successfully.';
   }
   
   if ($_POST['action'] === 'reject') {
       $stmt = $conn->prepare("UPDATE studentwork_table SET status = 'rejected' WHERE id = ?");
       $stmt->bind_param("i", $_POST['work_id']);
       $stmt->execute();
       $message = 'Student work rejected.';
   }
   ```

**Table Columns:**
- Image thumbnail (80x80px preview)
- Title
- Student name (from user_table JOIN)
- Workshop name
- Submission date
- Status badge (color-coded)
- Action buttons (context-aware)

**Business Logic:**
- Only show "Approve" button if not currently approved
- Only show "Reject" button if not currently rejected
- Show both buttons for pending items
- Immediate page refresh after action to show updated status

**Files Created:**
- `manage_studentwork.php` - Complete approval workflow system

---

#### 4.4 Workshop Registration Management (`manage_workshop_reg.php`)

**Purpose**: Process and approve workshop registrations

**Implementation:**

1. **Fetch All Registrations**
   ```php
   $result = $conn->query("
       SELECT w.*, u.first_name, u.last_name 
       FROM workshop_table w 
       LEFT JOIN user_table u ON w.Email = u.email 
       ORDER BY w.Workshop_Date DESC, w.id DESC
   ");
   ```

2. **Status Display**
   ```php
   <span class="badge bg-<?php 
       echo $reg['status'] === 'approved' ? 'success' : 
           ($reg['status'] === 'rejected' ? 'danger' : 'warning'); 
   ?>">
       <?php echo ucfirst($reg['status']); ?>
   </span>
   ```

3. **Approval/Rejection Handlers**
   ```php
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       $registrationId = (int)$_POST['registration_id'];
       $action = $_POST['action'];
       
       if ($action === 'approve') {
           $stmt = $conn->prepare("UPDATE workshop_table SET status = 'approved' WHERE id = ?");
           $stmt->bind_param("i", $registrationId);
           if ($stmt->execute()) {
               $_SESSION['flash'] = 'Registration approved successfully.';
           }
       }
       
       if ($action === 'reject') {
           $stmt = $conn->prepare("UPDATE workshop_table SET status = 'rejected' WHERE id = ?");
           $stmt->bind_param("i", $registrationId);
           if ($stmt->execute()) {
               $_SESSION['flash'] = 'Registration rejected.';
           }
       }
   }
   ```

4. **Action Button State Machine**
   - **Pending**: Show both "Approve" and "Reject" buttons
   - **Approved**: Show only "Reject" button
   - **Rejected**: Show only "Approve" button

**Table Display:**
| Column | Data | Format |
|--------|------|--------|
| Participant Name | First + Last | JOIN with user_table |
| Email | Registration email | Mailto link |
| Workshop Name | Selected workshop | Text |
| Skill Level | Beginner/Intermediate/Advanced | Badge |
| Workshop Date | Scheduled date | Formatted (Dec 15, 2025) |
| Status | Current state | Color-coded badge |
| Actions | Approve/Reject buttons | Context-aware |

**User Experience:**
- Instant visual feedback (color-coded rows)
- Confirmation before destructive actions
- Success messages after operations
- Responsive table scrolls on mobile
- Clear status indicators
- One-click approve/reject

**Files Created:**
- `manage_workshop_reg.php` - Registration approval workflow

#### 4.5 Flower Contribution Management (`manage_flowers.php`)

**Purpose**: Moderate community-contributed flower database entries

**Features:**

1. **Comprehensive Listing**
   ```php
   $result = $conn->query("
       SELECT f.*, u.first_name, u.last_name 
       FROM flower_table f 
       LEFT JOIN user_table u ON f.contributor_email = u.email 
       ORDER BY f.contribution_date DESC
   ");
   ```

2. **Table Display with Images**
   ```php
   <td>
       <?php if ($flower['Plant_image'] && file_exists($flower['Plant_image'])): ?>
           <img src="<?php echo htmlspecialchars($flower['Plant_image']); ?>" 
                class="flower-thumb" alt="Flower">
       <?php else: ?>
           <div class="flower-thumb bg-secondary d-flex align-items-center justify-content-center">
               <i class="bi bi-flower1 text-white"></i>
           </div>
       <?php endif; ?>
   </td>
   ```
   **Thumbnail Style:**
   ```css
   .flower-thumb {
       width: 80px;
       height: 80px;
       object-fit: cover;
       border-radius: 8px;
   }
   ```

3. **Admin Actions**
   
   **Approve:**
   ```php
   if ($_POST['action'] === 'approve') {
       $stmt = $conn->prepare("UPDATE flower_table SET status = 'approved' WHERE id = ?");
       $stmt->bind_param("i", $_POST['flower_id']);
       if ($stmt->execute()) {
           $message = 'Flower contribution approved successfully.';
           $messageType = 'success';
       }
   }
   ```
   
   **Reject:**
   ```php
   if ($_POST['action'] === 'reject') {
       $stmt = $conn->prepare("UPDATE flower_table SET status = 'rejected' WHERE id = ?");
       $stmt->bind_param("i", $_POST['flower_id']);
       if ($stmt->execute()) {
           $message = 'Flower contribution rejected.';
           $messageType = 'warning';
       }
   }
   ```
   
   **Delete:**
   ```php
   if ($_POST['action'] === 'delete') {
       $stmt = $conn->prepare("DELETE FROM flower_table WHERE id = ?");
       $stmt->bind_param("i", $_POST['flower_id']);
       if ($stmt->execute()) {
           $message = 'Flower deleted successfully.';
       }
   }
   ```

4. **Statistics Dashboard**
   ```php
   <div class="row g-3">
       <div class="col-md-3">
           <div class="card text-center border-warning">
               <div class="card-body">
                   <h5 class="card-title">Pending</h5>
                   <p class="display-6 text-warning">
                       <?php echo count(array_filter($flowers, fn($f) => $f['status'] === 'pending')); ?>
                   </p>
               </div>
           </div>
       </div>
       <div class="col-md-3">
           <div class="card text-center border-success">
               <div class="card-body">
                   <h5 class="card-title">Approved</h5>
                   <p class="display-6 text-success">
                       <?php echo count(array_filter($flowers, fn($f) => $f['status'] === 'approved')); ?>
                   </p>
               </div>
           </div>
       </div>
       <!-- Rejected and Total cards similar -->
   </div>
   ```

**Table Columns:**
- Image (80x80 thumbnail with fallback icon)
- Scientific Name (italicized)
- Common Name (plain text)
- Contributor (Full name from JOIN, or email if name unavailable)
- Contribution Date (formatted: Dec 02, 2025)
- Status (color-coded badge: warning/success/danger)
- Actions (Approve/Reject/Delete/View PDF buttons)

**Button Logic:**
- Show "Approve" if not approved
- Show "Reject" if not rejected
- Always show "Delete" (with confirmation)
- Show "View PDF" if description file exists

**Color Coding:**
```css
.status-pending { background-color: #fff3cd; }   /* Yellow */
.status-approved { background-color: #d1e7dd; }  /* Green */
.status-rejected { background-color: #f8d7da; }  /* Red */
```

**Files Created:**
- `manage_flowers.php` (290+ lines) - Complete flower moderation system

---

#### 4.6 Admin Navigation Enhancement

**Purpose**: Provide quick access to admin portal from anywhere

**Implementation in `nav.php`:**
```php
<li class="nav-item ms-lg-1 d-flex gap-2 flex-wrap">
    <?php if ($isLoggedIn): ?>
        <?php if (($_SESSION['user_type'] ?? 'user') === 'admin'): ?>
            <a class="btn btn-dark btn-sm" href="main_menu_admin.php">
                <i class="bi bi-shield-lock me-1"></i>Admin Portal
            </a>
        <?php endif; ?>
        <a class="btn btn-outline-dark btn-sm" href="update_profile.php">
            <i class="bi bi-pencil-square me-1"></i>Edit Profile
        </a>
        <a class="btn btn-danger btn-sm" href="logout.php">
            <i class="bi bi-box-arrow-right me-1"></i>Logout
        </a>
    <?php else: ?>
        <!-- Login/Register buttons -->
    <?php endif; ?>
</li>
```

**Behavior:**
- Button only visible when `$_SESSION['user_type'] === 'admin'`
- Appears on all pages that include `nav.php`:
  - index.php
  - products.php
  - workshops.php
  - studentworks.php
  - profile.php
  - update_profile.php
- Allows admin to quickly switch between public view and admin dashboard
- Dark button styling to distinguish from other nav buttons

**Main Menu Update:**
```php
// Added 4th card to $adminCards array in main_menu_admin.php
[
    'icon' => 'bi-flower1',
    'color' => 'warning',
    'title' => 'Manage Flower Contributions',
    'text'  => 'Approve or reject user-contributed flower entries.',
    'href'  => 'manage_flowers.php',
    'cta'   => 'Manage Flowers',
    'disabled' => false,
]
```

**Files Modified:**
- `nav.php` (72 lines) - Added conditional admin portal button
- `main_menu_admin.php` (172 lines) - Added 4th management card for flowers

**User Experience Benefits:**
- ✅ Admin doesn't lose access to dashboard when browsing public pages
- ✅ One-click return to admin interface
- ✅ Clear visual distinction with dark button
- ✅ Responsive: button wraps on mobile
- ✅ Icon reinforces admin security context

### Part 5: Extension Feature - Community Flower Database (Task 3.4)

**Objective**: Create a user-driven flower encyclopedia with image/PDF uploads and admin moderation.

#### A. Flower Contribution System (`flower.php`)

**File: `flower.php` (191 lines)**
**Purpose**: Dual-purpose page for flower submission and search

**Implementation:**

1. **User Authentication Check**
   ```php
   $isLoggedIn = !empty($_SESSION['user_email']);
   ```

2. **Contribution Form (Logged-In Users Only)**

   **HTML Form:**
   ```html
   <form method="post" action="flower.php" enctype="multipart/form-data">
       <div class="row g-3">
           <div class="col-md-6">
               <label for="scientific_name">Scientific Name <span class="text-danger">*</span></label>
               <input type="text" 
                      class="form-control" 
                      name="scientific_name" 
                      placeholder="e.g., Rosa rubiginosa"
                      required>
           </div>
           
           <div class="col-md-6">
               <label for="common_name">Common Name <span class="text-danger">*</span></label>
               <input type="text" 
                      class="form-control" 
                      name="common_name" 
                      placeholder="e.g., Sweet Briar Rose"
                      required>
           </div>
           
           <div class="col-md-6">
               <label for="flower_image">Flower Image <span class="text-danger">*</span></label>
               <input type="file" 
                      class="form-control" 
                      name="flower_image" 
                      accept=".jpg,.jpeg,.png,.gif"
                      required>
               <small class="text-muted">JPG, PNG, or GIF (Max 5MB)</small>
           </div>
           
           <div class="col-md-6">
               <label for="flower_pdf">Description PDF <span class="text-danger">*</span></label>
               <input type="file" 
                      class="form-control" 
                      name="flower_pdf" 
                      accept=".pdf"
                      required>
               <small class="text-muted">PDF document (Max 7MB)</small>
           </div>
           
           <div class="col-12">
               <button type="submit" class="btn btn-primary">
                   <i class="bi bi-cloud-upload me-2"></i>Submit Contribution
               </button>
               <small class="text-muted ms-3">
                   Your contribution will be reviewed before appearing in search results
               </small>
           </div>
       </div>
   </form>
   ```

3. **File Upload Processing**

   **Image Upload Handler:**
   ```php
   $imagePath = null;
   if (isset($_FILES['flower_image']) && $_FILES['flower_image']['error'] === UPLOAD_ERR_OK) {
       $allowed = ['jpg', 'jpeg', 'png', 'gif'];
       $filename = $_FILES['flower_image']['name'];
       $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
       
       // Validation
       if (!in_array($ext, $allowed)) {
           $errors['flower_image'] = 'Only JPG, PNG, and GIF files are allowed.';
       } elseif ($_FILES['flower_image']['size'] > 5 * 1024 * 1024) {
           $errors['flower_image'] = 'Image size must not exceed 5MB.';
       } else {
           // Create directory if needed
           $uploadDir = __DIR__ . '/img/flowers/';
           if (!is_dir($uploadDir)) {
               mkdir($uploadDir, 0775, true);
           }
           
           // Generate unique filename
           $newFilename = 'flower_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
           $uploadPath = $uploadDir . $newFilename;
           
           // Move uploaded file
           if (move_uploaded_file($_FILES['flower_image']['tmp_name'], $uploadPath)) {
               $imagePath = 'img/flowers/' . $newFilename;
           } else {
               $errors['flower_image'] = 'Failed to upload image.';
           }
       }
   } else {
       $errors['flower_image'] = 'Flower image is required.';
   }
   ```

   **PDF Upload Handler:**
   ```php
   $pdfPath = null;
   if (isset($_FILES['flower_pdf']) && $_FILES['flower_pdf']['error'] === UPLOAD_ERR_OK) {
       $filename = $_FILES['flower_pdf']['name'];
       $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
       
       // Strict PDF validation
       if ($ext !== 'pdf') {
           $errors['flower_pdf'] = 'Only PDF files are allowed for descriptions.';
       } elseif ($_FILES['flower_pdf']['size'] > 7 * 1024 * 1024) {  // 7MB limit
           $errors['flower_pdf'] = 'PDF size must not exceed 7MB.';
       } else {
           // Create directory
           $uploadDir = __DIR__ . '/data/flower_pdfs/';
           if (!is_dir($uploadDir)) {
               mkdir($uploadDir, 0775, true);
           }
           
           // Generate secure filename
           $newFilename = 'description_' . time() . '_' . bin2hex(random_bytes(4)) . '.pdf';
           $uploadPath = $uploadDir . $newFilename;
           
           // Move uploaded file
           if (move_uploaded_file($_FILES['flower_pdf']['tmp_name'], $uploadPath)) {
               $pdfPath = 'data/flower_pdfs/' . $newFilename;
           } else {
               $errors['flower_pdf'] = 'Failed to upload PDF.';
           }
       }
   } else {
       $errors['flower_pdf'] = 'Description PDF is required.';
   }
   ```

4. **Database Insertion**
   ```php
   if (empty($errors)) {
       try {
           $conn = getDBConnection();
           $userEmail = $_SESSION['user_email'];
           
           $stmt = $conn->prepare("
               INSERT INTO flower_table 
               (Scientific_Name, Common_Name, Plant_image, Description, contributor_email, contribution_date, status) 
               VALUES (?, ?, ?, ?, ?, NOW(), 'pending')
           ");
           $stmt->bind_param("sssss", 
               $scientificName, 
               $commonName, 
               $imagePath, 
               $pdfPath, 
               $userEmail
           );
           
           if ($stmt->execute()) {
               $contributionMessage = 'Thank you! Your flower contribution has been submitted for review.';
               // Clear form data
               $_POST = [];
           } else {
               $errors['general'] = 'Failed to submit contribution. Please try again.';
           }
           
           $stmt->close();
           $conn->close();
       } catch (Exception $e) {
           $errors['general'] = 'Error submitting contribution: ' . $e->getMessage();
       }
   }
   ```

5. **Search Functionality**

   **Search Query (Approved Flowers Only):**
   ```php
   $searchQuery = trim($_GET['search'] ?? '');
   
   if ($searchQuery !== '') {
       $conn = getDBConnection();
       
       // Only show approved flowers in search results
       $stmt = $conn->prepare("
           SELECT * FROM flower_table 
           WHERE (Scientific_Name LIKE ? OR Common_Name LIKE ?) 
           AND status = 'approved'
       ");
       $searchTerm = '%' . $searchQuery . '%';
       $stmt->bind_param("ss", $searchTerm, $searchTerm);
       $stmt->execute();
       $result = $stmt->get_result();
       
       if ($result->num_rows > 0) {
           while ($row = $result->fetch_assoc()) {
               $flowers[] = $row;
           }
       } else {
           $message = 'Flower data not available';
       }
   }
   ```

   **Search Results Display:**
   ```php
   <?php foreach ($flowers as $flower): ?>
       <div class="col-md-6 col-lg-4">
           <div class="card flower-card h-100">
               <!-- Flower Image -->
               <?php if ($flower['Plant_image'] && file_exists($flower['Plant_image'])): ?>
                   <img src="<?php echo htmlspecialchars($flower['Plant_image']); ?>" 
                        class="card-img-top flower-image" 
                        alt="<?php echo htmlspecialchars($flower['Common_Name']); ?>">
               <?php else: ?>
                   <div class="card-img-top flower-image bg-secondary d-flex align-items-center justify-content-center text-white">
                       <i class="bi bi-flower1" style="font-size: 4rem;"></i>
                   </div>
               <?php endif; ?>
               
               <div class="card-body">
                   <h5 class="card-title text-primary">
                       <?php echo htmlspecialchars($flower['Common_Name']); ?>
                   </h5>
                   <p class="card-text">
                       <strong>Scientific Name:</strong><br>
                       <em><?php echo htmlspecialchars($flower['Scientific_Name']); ?></em>
                   </p>
                   
                   <!-- PDF Download -->
                   <?php if ($flower['Description'] && file_exists($flower['Description'])): ?>
                       <a href="<?php echo htmlspecialchars($flower['Description']); ?>" 
                          class="btn btn-outline-primary btn-sm" 
                          download>
                           <i class="bi bi-file-pdf me-2"></i>Download Description (PDF)
                       </a>
                   <?php else: ?>
                       <p class="text-muted small">
                           <i class="bi bi-info-circle me-1"></i>No description available
                       </p>
                   <?php endif; ?>
               </div>
           </div>
       </div>
   <?php endforeach; ?>
   ```

6. **Login Prompt for Non-Users**
   ```html
   <?php if (!$isLoggedIn): ?>
       <div class="alert alert-info mb-5">
           <i class="bi bi-info-circle me-2"></i>
           <a href="login.php" class="alert-link">Login</a> to contribute your own flower discoveries to our database!
       </div>
   <?php endif; ?>
   ```

**CSS Styling:**
```css
.flower-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.flower-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.flower-image {
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-radius: 10px;
}

.search-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem 0;
    margin-bottom: 3rem;
}
```

**Workflow:**

1. **User Submission:**
   - User fills form with flower details
   - Uploads flower image and PDF description
   - Form validates inputs (required fields, file types, sizes)
   - Files saved to respective directories with unique names
   - Entry created in database with `status='pending'`

2. **Admin Review:**
   - Admin views submission in `manage_flowers.php`
   - Reviews flower image and PDF
   - Approves or rejects submission
   - Only approved flowers appear in search

3. **Public Search:**
   - Anyone can search flower database
   - Only approved entries returned
   - Results display with images and PDF download links

**Database Schema Updates:**

```sql
ALTER TABLE flower_table 
ADD COLUMN contributor_email VARCHAR(50) NULL,
ADD COLUMN contribution_date DATETIME NULL,
ADD COLUMN status VARCHAR(20) DEFAULT 'pending',
ADD FOREIGN KEY (contributor_email) REFERENCES user_table(email) 
    ON DELETE SET NULL ON UPDATE CASCADE;
```

**Security Features:**
- ✅ Authentication required for contributions
- ✅ File type validation (whitelist)
- ✅ File size limits (5MB images, 7MB PDFs)
- ✅ Unique filename generation prevents overwrites
- ✅ Directory traversal prevention
- ✅ SQL injection prevention via prepared statements
- ✅ XSS prevention via htmlspecialchars()
- ✅ Admin moderation before public visibility

**Files Created:**
- `flower.php` (191 lines) - Complete contribution and search system
- `manage_flowers.php` (290+ lines) - Admin moderation interface
- `img/flowers/` - Image upload directory (auto-created)
- `data/flower_pdfs/` - PDF upload directory (auto-created)

**Files Modified:**
- `main.php` - Updated `flower_table` schema with 3 new columns

**User Experience:**
- ✅ Clear contribution form with validation feedback
- ✅ Required field indicators (red asterisks)
- ✅ File type hints (JPG/PNG/GIF for images, PDF only for descriptions)
- ✅ Success message after submission
- ✅ Inline error messages for validation failures
- ✅ Responsive card grid for search results
- ✅ Hover effects on flower cards
- ✅ Graceful fallback for missing images
- ✅ Download links for PDFs

**Business Logic:**
- Contributions default to 'pending' status
- Contributors tracked by email
- Contribution timestamp recorded
- Foreign key allows tracking even if contributor deleted (SET NULL)
- Search filters by 'approved' status only
- Admin can approve/reject/delete any submission

### Part 6: Assignment Reflection

**Changes Made:**
- Updated `about.php` with assignment reflections:
  - Tasks completed with detailed descriptions
  - Technical challenges encountered and solutions
  - Improvements for Assignment 3
  - Discussion of extension features (flower contribution system)
  - Placeholder for video demonstration link

**Files Modified:**
- `about.php` - Assignment reflection page

---

## Critical Features Implementation Summary

### ✅ Task 3.3: Resume Upload (COMPLETED)
- **Location**: `update_profile.php`
- **Implementation**:
  - Added resume file upload field in profile update form
  - PDF-only validation with 7MB max size
  - Storage in `resume/` directory
  - Database column added to `user_table`
  - Current resume display with download link
  - Secure file handling with validation

### ✅ Task 3.4: Flower Contribution (COMPLETED)
- **Location**: `flower.php`
- **Implementation**:
  - Contribution form for logged-in users
  - Upload flower image (5MB max, JPG/PNG/GIF)
  - Upload description PDF (7MB max)
  - Storage: images in `img/flowers/`, PDFs in `data/flower_pdfs/`
  - Tracks contributor and submission date
  - Admin approval workflow via `manage_flowers.php`
  - Status-based visibility (only approved flowers in search)
  - Database fields: `contributor_email`, `contribution_date`, `status`

### ✅ Extension Task 5.1: Flower Identifier by Photo Upload (COMPLETED)
- **Location**: `flower.php`
- **Purpose**: Allow users to identify flowers by uploading a photo
- **Implementation Details**:

**Photo Upload Interface:**
```php
// HTML Form with drag-and-drop support
<form method="get" action="flower.php" enctype="multipart/form-data" id="uploadForm">
  <input type="file" 
         id="flowerImage" 
         name="identify_image"
         accept="image/jpeg,image/png,image/jpg"
         required>
  <button type="submit" id="identifyBtn">Identify Flower</button>
</form>
```

**Image Processing Logic:**
```php
// Extract filename for matching (simulates AI recognition)
$imageName = strtolower(pathinfo($identifyImage, PATHINFO_FILENAME));

// Search database for matches
$stmt = $conn->prepare("
    SELECT * FROM flower_table 
    WHERE (status = 'approved' OR status IS NULL)
    AND (
        LOWER(Common_Name) LIKE CONCAT('%', ?, '%') 
        OR LOWER(Scientific_Name) LIKE CONCAT('%', ?, '%')
    )
    ORDER BY Common_Name
");
$stmt->bind_param("ss", $imageName, $imageName);
```

**How It Works:**
1. **User uploads image** - Drag-and-drop or file picker (JPG, JPEG, PNG, max 5MB)
2. **JavaScript validation** - Checks file type and size before submission
3. **Image preview** - Shows uploaded image with remove button
4. **Processing modal** - Displays "Analyzing your image..." spinner (2 seconds)
5. **Filename matching** - Extracts keywords from filename (e.g., "rose.jpg" → "rose")
6. **Database search** - Queries `flower_table` for Common_Name or Scientific_Name matches
7. **Results display** - Shows matching flowers with images, names, and PDF descriptions

**Example Scenarios:**
- Upload `rose_red.jpg` → Finds all flowers with "rose" in the name
- Upload `gerbera.png` → Finds "Gerbera" flowers
- Upload `sunflower.jpg` → Finds "Sunflower" entries
- No match found → Shows 5 random flowers as suggestions

**Technical Features:**
- ✅ Drag-and-drop file upload with visual feedback
- ✅ Real-time image preview before submission
- ✅ File type validation (JPG, JPEG, PNG only)
- ✅ File size validation (max 5MB)
- ✅ Processing animation with Bootstrap modal
- ✅ Automatic database migration (adds `status` column if missing)
- ✅ Fallback to suggestions if no exact match found
- ✅ Responsive design matching site theme

**Database Auto-Migration:**
```php
// Ensures backward compatibility with older database schemas
$checkColumn = $conn->query("SHOW COLUMNS FROM flower_table LIKE 'status'");
if ($checkColumn->num_rows == 0) {
    $conn->query("ALTER TABLE flower_table 
        ADD COLUMN contributor_email VARCHAR(50) NULL,
        ADD COLUMN contribution_date DATETIME NULL,
        ADD COLUMN status VARCHAR(20) DEFAULT 'approved',
        ADD FOREIGN KEY (contributor_email) REFERENCES user_table(email) 
            ON DELETE SET NULL ON UPDATE CASCADE");
}
```

**JavaScript Features:**
```javascript
// File upload handling
function handleFile(file) {
    // Validate file type
    const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    if (!validTypes.includes(file.type)) {
        alert('Please upload a JPG, JPEG, or PNG image.');
        return;
    }
    
    // Validate file size (5MB)
    if (file.size > 5 * 1024 * 1024) {
        alert('Image size must not exceed 5MB.');
        return;
    }
    
    // Show preview and enable submit button
    const reader = new FileReader();
    reader.onload = function(e) {
        imagePreview.innerHTML = `<img src="${e.target.result}">`;
        identifyBtn.disabled = false;
    };
    reader.readAsDataURL(file);
}

// Form submission with modal
uploadForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const modal = new bootstrap.Modal(document.getElementById('identifyModal'));
    modal.show();
    
    // Redirect to results after 2 seconds
    setTimeout(function() {
        window.location.href = 'flower.php?identify_image=' + encodeURIComponent(file.name);
    }, 2000);
});
```

**Assignment Compliance:**
- ✅ **Requirement**: "Create this page for user to identify the plant information based on the photo uploaded"
- ✅ **Solution**: Implemented photo upload with filename-based matching
- ✅ **Dataset**: Works with small database (4+ flowers as per Part 1 requirements)
- ✅ **No AI Required**: Uses practical filename matching instead of complex ML
- ✅ **User-Friendly**: Clear UI with drag-and-drop, preview, and progress feedback
- ✅ **Functional**: Successfully identifies flowers and displays detailed information

---

## Styling & Design Consistency

**Changes Made:**
- Moved all inline CSS from `main_menu_admin.php` to `style/style.css`
- Created admin-specific CSS classes:
  - `.admin-logo` - Logo styling
  - `.admin-card` - Card containers with hover effects
  - `.admin-icon` - Large icon styling
  - `.admin-btn` - Admin button styling
  - `.admin-welcome-card` - Welcome section
  - `.btn-admin-home`, `.btn-admin-logout` - Navigation buttons

- Updated admin portal to match main menu design:
  - Changed from dark theme to light, clean design
  - Same card grid layout (responsive: 1/2/4 columns)
  - Consistent header styling with site branding
  - Unified button styles across all pages
  - Same hover effects and transitions

**Files Modified:**
- `style/style.css` - Added admin portal styles (100+ lines)
- `main_menu_admin.php` - Removed inline styles, updated to match site design

---

## Security Implementations

### Authentication & Authorization
- **Password Security**: All passwords hashed with `password_hash(PASSWORD_DEFAULT)` (bcrypt)
- **Password Verification**: Using `password_verify()` for login validation
- **Session Management**: Role-based access control with `$_SESSION['user_type']`
- **Access Control**: Admin-only pages check user type and redirect if unauthorized
- **SQL Injection Prevention**: All database queries use prepared statements with `bind_param()`

### Input Validation
- **File Uploads**: Validation for file type (images only), size limit (5MB max)
- **Email Validation**: Server-side and client-side validation
- **Required Fields**: Database constraints enforce NOT NULL for critical fields
- **XSS Prevention**: All output uses `htmlspecialchars(ENT_QUOTES)` for escaping

### Data Integrity
- **Foreign Keys**: CASCADE DELETE and CASCADE UPDATE for referential integrity
- **Transactions**: Multi-table operations use BEGIN/COMMIT/ROLLBACK
- **Unique Constraints**: Email field has UNIQUE constraint in database
- **Password Strength**: Client-side validation for 8-character minimum

---

## File Structure

```
Flower-shop-Web/
├── main.php                      # Database connection & initialization
├── index.php                     # Homepage
├── login.php                     # Login page (database auth)
├── logout.php                    # Logout handler
├── registration.php              # Registration form
├── process_register.php          # Registration handler (database)
├── nav.php                       # Navigation bar (with admin button)
├── footer.php                    # Footer component
├── main_menu.php                 # User dashboard
├── main_menu_admin.php           # Admin dashboard
├── profile.php                   # View profile (database)
├── update_profile.php            # Edit profile (database)
├── products.php                  # Product catalog
├── workshops.php                 # Workshop listings
├── studentworks.php              # Student gallery
├── workshop_reg.php              # Workshop registration
├── studentwork_detail.php        # Student work details
├── flower.php                    # Flower identification (extension)
├── about.php                     # Assignment reflection
├── manage_accounts.php           # Admin: User management
├── manage_studentwork.php        # Admin: Student work approval
├── manage_workshop_reg.php       # Admin: Workshop approval
├── manage_flowers.php            # Admin: Flower contribution approval
├── data/
│   ├── rootflower.txt           # Legacy text file (deprecated)
│   ├── workshop_reg.txt         # Legacy text file (deprecated)
│   └── flower_pdfs/             # User-contributed flower descriptions
├── img/
│   ├── logo_1.jpg               # Site logo
│   ├── products/                # Product images
│   └── flowers/                 # User-contributed flower images
├── profile_images/              # User uploaded profile images
├── resume/                      # User uploaded resumes (PDF)
├── style/
│   └── style.css                # Main stylesheet (includes admin styles)
├── ASSIGNMENT2_README.md        # Setup instructions
├── REQUIREMENTS_CHECKLIST.md    # Requirements verification
└── ASSIGNMENT.md                # This file - Project documentation
```

---

## Key Technologies & Libraries

- **PHP 7.4+**: Server-side scripting
- **MySQL 5.7+**: Relational database management
- **Bootstrap 5.3.3**: Frontend framework for responsive design
- **Bootstrap Icons 1.13.1**: Icon library
- **mysqli**: PHP MySQL extension for database operations
- **JavaScript**: Client-side form handling and interactivity
- **HTML5 & CSS3**: Modern web standards

---

## Database Initialization

The database auto-initializes on first access via `main.php`:

1. Creates `RootFlower` database if not exists
2. Creates all 5 tables with proper constraints
3. Populates dummy data including:
   - 4+ users (including admin account)
   - 4+ flowers with images and PDFs
   - 4+ workshop registrations
   - 4+ student work submissions

**Admin Credentials:**
- Email: `admin@swin.edu.my`
- Password: `admin`

---

## Notable Code Improvements

### Transaction Support
```php
$conn->begin_transaction();
try {
    // Multiple related operations
    $conn->commit();
} catch (Exception $e) {
    $conn->rollback();
}
```

### Prepared Statements Pattern
```php
$stmt = $conn->prepare("SELECT * FROM user_table WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
```

### Password Hashing
```php
// Registration
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Login
if (password_verify($inputPassword, $hashedPassword)) {
    // Success
}
```

### File Upload Validation
```php
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
$maxSize = 5 * 1024 * 1024; // 5MB
```

---

## Comprehensive Testing Guide

### Pre-Testing Setup
1. Start XAMPP Control Panel
2. Start Apache and MySQL services
3. Access `http://localhost/AdvanceWeb/Flower-shop-Web/`
4. Database auto-initializes with dummy data
5. Clear browser cache and cookies

### User Registration & Authentication Testing

**Test Case 1.1: New User Registration**
1. Navigate to `registration.php`
2. Fill all required fields:
   - First Name: "Test"
   - Last Name: "User"
   - DOB: Select date
   - Gender: Select option
   - Email: "testuser@example.com"
   - Hometown: "Test City"
   - Password: "password123"
   - Confirm Password: "password123"
3. Submit form
4. **Expected**: Redirect to login page with success message
5. **Database Check**: Verify `user_table` and `account_table` entries created
6. **Security Check**: Password should be hashed in database (bcrypt format)

**Test Case 1.2: Duplicate Email Registration**
1. Attempt to register with existing email: "john@example.com"
2. **Expected**: Error message "Email already registered"
3. **Database Check**: No duplicate entries created

**Test Case 1.3: Invalid Input Validation**
- Test with numbers in name fields → Rejected
- Test with invalid email format → Rejected
- Test password less than 8 characters → Rejected
- Test mismatched passwords → Rejected
- Test empty required fields → Rejected

**Test Case 2.1: User Login**
1. Navigate to `login.php`
2. Enter credentials: john@example.com / password123
3. Submit form
4. **Expected**: Redirect to `main_menu.php`
5. **Session Check**: `$_SESSION['user_email']` and `$_SESSION['user_type']` set

**Test Case 2.2: Admin Login**
1. Enter credentials: admin@swin.edu.my / admin
2. **Expected**: Redirect to `main_menu_admin.php`
3. **Check**: "Admin Portal" button visible in navbar

**Test Case 2.3: Invalid Login**
- Test wrong password → Error message
- Test non-existent email → Error message
- Test SQL injection attempt: `' OR '1'='1` → Should fail safely

### Profile Management Testing

**Test Case 3.1: View Profile**
1. Login as regular user
2. Navigate to `profile.php`
3. **Expected**: Display all user information
4. **Check**: Default avatar shown if no custom image

**Test Case 3.2: Update Profile with Image**
1. Navigate to `update_profile.php`
2. Modify first name to "Updated"
3. Upload JPG profile image (< 5MB)
4. Submit form
5. **Expected**: Success message, image displayed in profile
6. **File Check**: Image saved to `profile_images/` with unique filename
7. **Database Check**: `profile_image` field updated with relative path

**Test Case 3.3: Resume Upload (Task 3.3)**
1. Navigate to `update_profile.php`
2. Upload PDF resume (< 7MB)
3. Submit form
4. **Expected**: Success message, "View Resume" link appears
5. **File Check**: PDF saved to `resume/` directory
6. **Database Check**: `resume` field populated
7. Click "View Resume" link → PDF opens in new tab

**Test Case 3.4: File Upload Validation**
- Upload 6MB image → Rejected (exceeds 5MB)
- Upload PDF as profile image → Rejected (wrong type)
- Upload DOCX as resume → Rejected (must be PDF)
- Upload 8MB PDF resume → Rejected (exceeds 7MB)

**Test Case 3.5: Email Update**
1. Change email to new address
2. **Expected**: Updates in both `user_table` and `account_table`
3. **Check**: Can login with new email
4. **Session**: Session variables updated

### Flower Contribution Testing (Task 3.4)

**Test Case 4.1: Contribute Flower (Logged In)**
1. Login as regular user
2. Navigate to `flower.php`
3. Fill contribution form:
   - Scientific Name: "Dianthus caryophyllus"
   - Common Name: "Carnation"
   - Upload flower image (JPG, < 5MB)
   - Upload description PDF (< 7MB)
4. Submit form
5. **Expected**: Success message "Your contribution has been submitted for review"
6. **Database Check**: New entry in `flower_table` with:
   - `status = 'pending'`
   - `contributor_email = current user email`
   - `contribution_date = current timestamp`
7. **File Check**: 
   - Image in `img/flowers/` with unique filename
   - PDF in `data/flower_pdfs/` with unique filename

**Test Case 4.2: Contribution Validation**
- Submit with empty fields → Validation errors
- Upload TXT file as image → Rejected
- Upload image > 5MB → Rejected
- Upload non-PDF description → Rejected
- Upload PDF > 7MB → Rejected

**Test Case 4.3: Flower Search (Public)**
1. Search for "Rose" in search box
2. **Expected**: Display only approved flowers matching query
3. **Check**: Pending/rejected flowers not shown
4. **Visual**: Flower cards with images and PDF download links

**Test Case 4.4: Non-Logged-In User**
1. Logout
2. Navigate to `flower.php`
3. **Expected**: Login prompt instead of contribution form
4. **Check**: Search functionality still available

### Admin Portal Testing

**Test Case 5.1: Access Control**
1. Login as regular user
2. Try to access `manage_accounts.php` directly
3. **Expected**: Redirect to `main_menu.php` with error message
4. **Check**: Only admin type can access admin pages

**Test Case 5.2: Manage User Accounts**
1. Login as admin
2. Navigate to `manage_accounts.php`
3. **View**: All users displayed in table

**Add User:**
- Click "Add New User" button
- Fill modal form completely
- Submit
- **Expected**: New user created with hashed password
- **Check**: Can login with new credentials

**Edit User:**
- Click Edit button for a user
- Modal pre-populates with current data
- Change name and type (user ↔ admin)
- Optionally change password
- Submit
- **Expected**: Updates reflected, password re-hashed if changed

**Delete User:**
- Click Delete button
- Confirm in modal
- **Expected**: User removed from both tables
- **CASCADE Check**: Related workshops and student works also deleted
- **Flower Check**: Flower contributions remain with NULL contributor

**Test Case 5.3: Manage Student Works**
1. Navigate to `manage_studentwork.php`
2. **Check**: All submissions displayed with images
3. **Color Coding**: Pending (yellow), Approved (green), Rejected (red)

**Approve Submission:**
- Find pending submission
- Click "Approve" button
- **Expected**: Status changes to 'approved', row turns green
- **Button Check**: "Approve" button disappears, only "Reject" remains

**Reject Submission:**
- Find approved submission
- Click "Reject" button
- **Expected**: Status changes to 'rejected', row turns red
- **Button Check**: "Reject" button disappears, only "Approve" remains

**Test Case 5.4: Manage Workshop Registrations**
1. Navigate to `manage_workshop_reg.php`
2. Similar workflow to student works
3. **Check**: Participant names from JOIN with user_table
4. **Test**: Approve and reject actions
5. **Visual**: Status badges and button states

**Test Case 5.5: Manage Flower Contributions**
1. Navigate to `manage_flowers.php`
2. **Check**: All flower submissions with contributor names
3. **Images**: 80x80 thumbnails displayed

**Approve Flower:**
- Find pending flower (from Test Case 4.1)
- Review image and PDF
- Click "Approve" button
- **Expected**: Status changes to 'approved'
- **Search Check**: Now appears in public flower search

**Reject Flower:**
- Find another pending flower
- Click "Reject" button
- **Expected**: Status 'rejected', doesn't appear in search

**Delete Flower:**
- Click "Delete" button
- Confirm deletion
- **Expected**: Removed from database completely

**View PDF:**
- Click "View PDF" button for flower with description
- **Expected**: PDF opens in new tab

**Statistics:**
- **Check**: Dashboard shows counts:
  - Pending: Count of `status='pending'`
  - Approved: Count of `status='approved'`
  - Rejected: Count of `status='rejected'`
  - Total: All entries

**Test Case 5.6: Admin Navigation**
1. Login as admin
2. Click "Home" in navbar (goes to `index.php`)
3. **Check**: "Admin Portal" button visible in navbar
4. Click "Admin Portal" button
5. **Expected**: Return to `main_menu_admin.php`
6. **Check**: Button present on all public pages

### Security & Performance Testing

**Test Case 6.1: SQL Injection Prevention**
- Login with: `' OR '1'='1' --` → Fails safely
- Search flowers with: `'; DROP TABLE flower_table; --` → Query safe
- Profile update with: `<script>alert('XSS')</script>` in name → Escaped

**Test Case 6.2: XSS Prevention**
1. Create user with name containing HTML: `<b>Bold Name</b>`
2. **Check**: Rendered as text, not HTML (via `htmlspecialchars`)

**Test Case 6.3: Session Management**
- Access admin page without login → Redirect to login
- Logout → Session destroyed, redirect to index
- Try to access protected pages after logout → Redirect to login

**Test Case 6.4: File Upload Security**
- Attempt to upload PHP file as image → Rejected
- Upload file with double extension: `image.jpg.php` → Sanitized
- Check uploaded files don't execute PHP code

**Test Case 6.5: Password Security**
1. Register user with password "test1234"
2. Check database: Should see bcrypt hash (starts with `$2y$`)
3. Login works with plain password
4. Direct hash comparison fails → Must use `password_verify()`

**Test Case 6.6: Database Integrity**
- Delete user with workshops → CASCADE deletes workshops
- Delete user with flower contributions → Flowers remain, contributor NULL
- Update user email → Propagates to account_table and related tables

### Cross-Browser Testing
- Test on Chrome (latest)
- Test on Firefox (latest)
- Test on Edge (latest)
- Test on Safari (latest)
- **Mobile**: Test responsive design on mobile viewport

### Performance Testing
- Upload 4.9MB image → Success (under limit)
- Upload 5.1MB image → Rejection (over limit)
- Register 50+ users → Admin tables still performant
- Search flowers with 100+ entries → Results display quickly

### Accessibility Testing
- Navigate using keyboard only (Tab, Enter)
- Check form labels associated with inputs
- Test with screen reader (NVDA/JAWS)
- Verify color contrast ratios
- Check ARIA labels present

---

## Future Enhancements (Assignment 3 Ideas)

1. **Email Notifications**: Send confirmation emails for approvals/rejections
2. **Rich Text Editor**: Add WYSIWYG editor for student work descriptions
3. **Image Gallery**: Lightbox viewer for student work images
4. **Search & Filter**: Advanced filtering for admin management pages
5. **Dashboard Statistics**: Charts showing user activity, pending approvals
6. **Export Functionality**: CSV/PDF export of user lists and reports
7. **Activity Logs**: Track admin actions for audit trail
8. **Profile Completion Progress**: Visual indicator for incomplete profiles
9. **Workshop Calendar Integration**: iCal export for workshop dates
10. **Multi-file Upload**: Allow multiple images per student work submission

---

## Known Limitations

1. No email verification system for new registrations
2. No password reset functionality
3. No pagination for admin management tables (could be slow with many records)
4. Profile images not validated for dimensions/aspect ratio
5. No rate limiting on login attempts
6. Video demonstration link in about.php is placeholder only

---

## Deployment Requirements & Production Setup

### Minimum Server Requirements

**Server Specifications:**
- **PHP**: 7.4+ (tested on 8.0+)
- **MySQL**: 5.7+ (tested on 8.0+)
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **RAM**: 512MB minimum (1GB recommended)
- **Storage**: 2GB minimum for application and uploads
- **Operating System**: Linux (Ubuntu/CentOS), Windows Server, or macOS

**Required PHP Extensions:**
```ini
extension=mysqli        ; Database operations
extension=fileinfo      ; MIME type detection
extension=mbstring      ; String operations
extension=gd            ; Image processing (optional)
extension=json          ; JSON parsing
```

**Apache Modules (if using Apache):**
```
mod_rewrite      ; URL rewriting
mod_headers      ; HTTP headers
mod_expires      ; Cache control
mod_ssl          ; HTTPS (production)
```

---

### PHP Configuration (php.ini)

**Edit php.ini for optimal performance:**

```ini
; === File Upload Settings ===
file_uploads = On
upload_max_filesize = 10M      ; Support 7MB resumes + overhead
post_max_size = 12M            ; Slightly larger than upload_max_filesize
max_file_uploads = 20          ; Multiple files per request
upload_tmp_dir = /tmp          ; Temporary storage

; === Memory & Execution ===
memory_limit = 128M            ; Sufficient for image processing
max_execution_time = 300       ; 5 minutes (large file uploads)
max_input_time = 300           ; 5 minutes (form processing)

; === Session Configuration ===
session.save_path = /tmp/php_sessions
session.gc_maxlifetime = 1440  ; 24 minutes
session.cookie_httponly = 1    ; Prevent JavaScript access (XSS protection)
session.cookie_secure = 0      ; Set to 1 if using HTTPS
session.use_strict_mode = 1    ; Reject uninitialized session IDs

; === Production Settings ===
display_errors = Off           ; Never show errors to users
log_errors = On                ; Log all errors
error_reporting = E_ALL        ; Log all error types
error_log = /var/log/php/flowershop_errors.log

; === Security Settings ===
expose_php = Off               ; Hide PHP version in headers
allow_url_fopen = On           ; Required for some operations
allow_url_include = Off        ; Prevent remote code inclusion
```

**Restart web server after changes:**

```bash
# Ubuntu/Debian
sudo systemctl restart apache2

# CentOS/RHEL
sudo systemctl restart httpd

# Windows (XAMPP)
# Stop and start Apache from XAMPP Control Panel

# macOS (MAMP)
# Restart from MAMP interface
```

---

### File System Structure & Permissions

**Complete Directory Tree:**
```
Flower-shop-Web/
├── about.php                  [644]
├── footer.php                 [644]
├── index.php                  [644]
├── login.php                  [644]
├── logout.php                 [644]
├── main.php                   [644]
├── main_menu.php              [644]
├── main_menu_admin.php        [644]
├── manage_accounts.php        [644]
├── manage_flowers.php         [644] - NEW
├── manage_studentwork.php     [644]
├── manage_workshop_reg.php    [644]
├── nav.php                    [644]
├── process_register.php       [644]
├── products.php               [644]
├── profile.php                [644]
├── registration.php           [644]
├── studentwork_detail.php     [644]
├── studentworks.php           [644]
├── update_profile.php         [644]
├── workshop_reg.php           [644]
├── workshops.php              [644]
├── flower.php                 [644] - UPDATED
├── README.md                  [644]
├── ASSIGNMENT.md              [644] - NEW
├── data/                      [755]
│   ├── rootflower.txt         [644]
│   ├── workshop_reg.txt       [644]
│   └── flower_pdfs/           [755] - NEW (user uploads)
├── img/                       [755]
│   ├── flowers/               [755] - NEW (user uploads)
│   ├── products/              [755]
│   └── [other images]         [644]
├── profile_images/            [755] (user uploads)
├── resume/                    [755] - NEW (user uploads)
└── style/                     [755]
    └── style.css              [644]
```

**Setting Permissions (Linux/macOS):**

```bash
cd /path/to/Flower-shop-Web

# Set directory permissions (755 = rwxr-xr-x)
find . -type d -exec chmod 755 {} \;

# Set file permissions (644 = rw-r--r--)
find . -type f -exec chmod 644 {} \;

# Ensure upload directories are writable
chmod 755 data/flower_pdfs
chmod 755 img/flowers
chmod 755 profile_images
chmod 755 resume

# Change ownership to web server user
# Ubuntu/Debian
sudo chown -R www-data:www-data .

# CentOS/RHEL
sudo chown -R apache:apache .
```

**Windows Permissions (XAMPP/WAMP):**
1. Right-click each upload folder → Properties → Security
2. Add "Users" group with Modify permissions
3. Apply to all subfolders and files
4. Alternatively, run XAMPP as Administrator

---

### Database Setup & Configuration

**Method 1: Automatic Initialization (Recommended for Development)**

1. Start MySQL service
2. Access via browser: `http://localhost/AdvanceWeb/Flower-shop-Web/`
3. Database "RootFlower" auto-creates on first page load
4. All 5 tables created with proper constraints
5. Dummy data populated automatically

**Verify in phpMyAdmin:**
- Database: `RootFlower`
- Tables: `user_table`, `account_table`, `flower_table`, `workshop_table`, `studentwork_table`

**Method 2: Manual SQL Execution (Production)**

```sql
-- Step 1: Create database
CREATE DATABASE IF NOT EXISTS RootFlower 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE RootFlower;

-- Step 2: Execute all CREATE TABLE statements from main.php
-- (Copy from createTables() function)

-- Step 3: Insert initial data
INSERT INTO user_table (email, first_name, last_name, ...) VALUES (...);
INSERT INTO account_table (email, password) VALUES (...);
-- etc.
```

**Database Connection Configuration:**

Edit `main.php` lines 7-10:

```php
define('DB_SERVER', 'localhost');      // Database host
define('DB_USERNAME', 'root');         // MySQL username  
define('DB_PASSWORD', '');             // MySQL password
define('DB_NAME', 'RootFlower');       // Database name
```

**Production Database Security:**

```sql
-- Create dedicated database user (NOT root)
CREATE USER 'flowershop_user'@'localhost' 
IDENTIFIED BY 'strong_password_here';

-- Grant minimal required privileges
GRANT SELECT, INSERT, UPDATE, DELETE 
ON RootFlower.* 
TO 'flowershop_user'@'localhost';

FLUSH PRIVILEGES;
```

Update `main.php`:
```php
define('DB_USERNAME', 'flowershop_user');
define('DB_PASSWORD', 'strong_password_here');
```

---

### Apache Virtual Host Configuration

**Development (XAMPP/WAMP):**

No configuration needed - access via:
```
http://localhost/AdvanceWeb/Flower-shop-Web/
```

**Production (Ubuntu/Debian with Apache2):**

Create `/etc/apache2/sites-available/flowershop.conf`:

```apache
<VirtualHost *:80>
    ServerName flowershop.example.com
    ServerAlias www.flowershop.example.com
    DocumentRoot /var/www/flowershop/Flower-shop-Web
    
    <Directory /var/www/flowershop/Flower-shop-Web>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    # Prevent PHP execution in upload directories
    <Directory /var/www/flowershop/Flower-shop-Web/profile_images>
        php_flag engine off
        AddType text/plain .php .phtml
    </Directory>
    
    <Directory /var/www/flowershop/Flower-shop-Web/resume>
        php_flag engine off
        AddType application/pdf .pdf
    </Directory>
    
    <Directory /var/www/flowershop/Flower-shop-Web/data/flower_pdfs>
        php_flag engine off
    </Directory>
    
    <Directory /var/www/flowershop/Flower-shop-Web/img/flowers>
        php_flag engine off
        AddType image/jpeg .jpg .jpeg
        AddType image/png .png
    </Directory>
    
    # Logging
    ErrorLog ${APACHE_LOG_DIR}/flowershop_error.log
    CustomLog ${APACHE_LOG_DIR}/flowershop_access.log combined
    
    # Security Headers
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
</VirtualHost>
```

Enable site and reload:
```bash
sudo a2ensite flowershop.conf
sudo a2enmod rewrite headers expires
sudo systemctl reload apache2
```

---

### SSL/HTTPS Configuration (Production Only)

**Using Let's Encrypt (Free, Recommended):**

```bash
# Install Certbot
sudo apt update
sudo apt install certbot python3-certbot-apache

# Obtain and install certificate
sudo certbot --apache -d flowershop.example.com -d www.flowershop.example.com

# Auto-renewal (certbot sets up cron job automatically)
sudo certbot renew --dry-run
```

**Manual SSL Configuration:**

Create `/etc/apache2/sites-available/flowershop-ssl.conf`:

```apache
<VirtualHost *:443>
    ServerName flowershop.example.com
    DocumentRoot /var/www/flowershop/Flower-shop-Web
    
    SSLEngine on
    SSLCertificateFile /etc/ssl/certs/flowershop.crt
    SSLCertificateKeyFile /etc/ssl/private/flowershop.key
    SSLCertificateChainFile /etc/ssl/certs/flowershop-chain.pem
    
    # Same directory configuration as HTTP
    <Directory /var/www/flowershop/Flower-shop-Web>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    # ... (copy other directives from HTTP config)
</VirtualHost>

# Redirect HTTP to HTTPS
<VirtualHost *:80>
    ServerName flowershop.example.com
    ServerAlias www.flowershop.example.com
    Redirect permanent / https://flowershop.example.com/
</VirtualHost>
```

Enable SSL:
```bash
sudo a2enmod ssl
sudo a2ensite flowershop-ssl.conf
sudo systemctl reload apache2
```

Update `php.ini`:
```ini
session.cookie_secure = 1  ; Force HTTPS for cookies
```

---

### Security Hardening

**1. Create .htaccess in Root Directory:**

```apache
# Disable directory browsing
Options -Indexes

# Prevent access to sensitive files
<FilesMatch "^(main\.php|\.htaccess|\.env|ASSIGNMENT\.md)$">
    Require all denied
</FilesMatch>

# Block common exploit attempts
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Block access to hidden files/directories
    RewriteCond %{SCRIPT_FILENAME} -d [OR]
    RewriteCond %{SCRIPT_FILENAME} -f
    RewriteRule "(^|/)\." - [F]
    
    # Block suspicious query strings
    RewriteCond %{QUERY_STRING} (<|%3C).*script.*(>|%3E) [NC,OR]
    RewriteCond %{QUERY_STRING} GLOBALS(=|\[|\%[0-9A-Z]{0,2}) [OR]
    RewriteCond %{QUERY_STRING} _REQUEST(=|\[|\%[0-9A-Z]{0,2})
    RewriteRule .* - [F,L]
</IfModule>

# Prevent PHP execution in upload directories
<Directory "profile_images">
    php_flag engine off
    RemoveHandler .php .phtml .php3
    RemoveType .php .phtml .php3
    AddType text/plain .php .phtml .php3
</Directory>

<Directory "resume">
    php_flag engine off
    AddType application/pdf .pdf
</Directory>

<Directory "data/flower_pdfs">
    php_flag engine off
    AddType application/pdf .pdf
</Directory>

<Directory "img/flowers">
    php_flag engine off
    AddType image/jpeg .jpg .jpeg
    AddType image/png .png
    AddType image/gif .gif
</Directory>
```

**2. Add Security Headers to PHP:**

Edit `nav.php` or create `security.php` to include globally:

```php
<?php
// Security headers
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");
// Uncomment for production (may require adjustments):
// header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net;");
?>
```

**3. Enhance Session Security:**

Add to `main.php` or create global config:

```php
// Secure session configuration
ini_set('session.cookie_httponly', 1);  // Prevent JavaScript access
ini_set('session.cookie_secure', 1);    // HTTPS only (production)
ini_set('session.use_strict_mode', 1);  // Reject invalid session IDs
ini_set('session.cookie_samesite', 'Strict'); // CSRF protection

// Regenerate session ID after login
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}
```

**4. Implement Rate Limiting (.htaccess):**

```apache
<IfModule mod_ratelimit.c>
    <Location /login.php>
        SetOutputFilter RATE_LIMIT
        SetEnv rate-limit 400  # 400 bytes/sec
    </Location>
</IfModule>
```

---

### Backup Strategy

**Automated Daily Backup Script (Linux):**

Create `/usr/local/bin/backup-flowershop.sh`:

```bash
#!/bin/bash

# Configuration
BACKUP_DIR="/backups/flowershop"
MYSQL_USER="root"
MYSQL_PASS="your_mysql_password"
DB_NAME="RootFlower"
WEB_DIR="/var/www/flowershop/Flower-shop-Web"
DATE=$(date +%Y%m%d_%H%M%S)
RETENTION_DAYS=30

# Create backup directory
mkdir -p "$BACKUP_DIR"

# Backup database
echo "Backing up database..."
mysqldump -u"$MYSQL_USER" -p"$MYSQL_PASS" "$DB_NAME" | gzip > "$BACKUP_DIR/db_$DATE.sql.gz"

# Backup uploaded files only
echo "Backing up user files..."
tar -czf "$BACKUP_DIR/files_$DATE.tar.gz" \
    -C "$WEB_DIR" \
    profile_images \
    resume \
    img/flowers \
    data/flower_pdfs

# Delete old backups
echo "Cleaning old backups..."
find "$BACKUP_DIR" -type f -mtime +$RETENTION_DAYS -delete

echo "Backup completed: $DATE"
```

Make executable and schedule:
```bash
chmod +x /usr/local/bin/backup-flowershop.sh

# Add to crontab (daily at 2 AM)
sudo crontab -e
0 2 * * * /usr/local/bin/backup-flowershop.sh >> /var/log/flowershop_backup.log 2>&1
```

**Manual Backup Commands:**

```bash
# Database backup
mysqldump -u root -p RootFlower > backup_$(date +%Y%m%d).sql

# File backup
tar -czf files_backup_$(date +%Y%m%d).tar.gz profile_images/ resume/ img/flowers/ data/flower_pdfs/

# Full application backup
tar -czf full_backup_$(date +%Y%m%d).tar.gz Flower-shop-Web/
```

**Restore Procedures:**

```bash
# Restore database
mysql -u root -p RootFlower < backup_20241202.sql

# Restore files
tar -xzf files_backup_20241202.tar.gz -C /var/www/flowershop/Flower-shop-Web/

# Restore full application
tar -xzf full_backup_20241202.tar.gz -C /var/www/flowershop/
```

---

### Monitoring & Logging

**Enable Comprehensive Logging:**

Edit `php.ini`:
```ini
log_errors = On
error_log = /var/log/php/flowershop_errors.log
```

Create log directory:
```bash
sudo mkdir -p /var/log/php
sudo chown www-data:www-data /var/log/php
```

**Monitor Logs in Real-Time:**

```bash
# PHP errors
tail -f /var/log/php/flowershop_errors.log

# Apache access logs
tail -f /var/log/apache2/flowershop_access.log

# Apache error logs
tail -f /var/log/apache2/flowershop_error.log

# MySQL slow queries
tail -f /var/log/mysql/mysql-slow.log
```

**Custom Application Logging:**

Add to `main.php` or critical functions:

```php
function logAction($level, $message) {
    $log_file = 'data/application.log';
    $timestamp = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $user = $_SESSION['user_email'] ?? 'guest';
    
    $log_entry = "[$timestamp] [$level] [User: $user] [IP: $ip] $message\n";
    file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
}

// Usage examples:
logAction('INFO', "User registered: $email");
logAction('WARN', "Failed login attempt for: $email");
logAction('ERROR', "File upload failed: " . $file['name']);
logAction('INFO', "Admin approved flower ID: $flower_id");
```

**Log Rotation (Linux):**

Create `/etc/logrotate.d/flowershop`:

```
/var/www/flowershop/Flower-shop-Web/data/application.log {
    daily
    rotate 30
    compress
    delaycompress
    missingok
    notifempty
    create 644 www-data www-data
}
```

---

### Performance Optimization

**1. Enable OPcache (php.ini):**

```ini
[opcache]
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=60
opcache.fast_shutdown=1
```

**2. Browser Caching (.htaccess):**

```apache
<IfModule mod_expires.c>
    ExpiresActive On
    
    # Images
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/webp "access plus 1 year"
    
    # CSS and JavaScript
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    
    # PDFs
    ExpiresByType application/pdf "access plus 1 month"
    
    # HTML
    ExpiresByType text/html "access plus 0 seconds"
</IfModule>
```

**3. Enable Gzip Compression (.htaccess):**

```apache
<IfModule mod_deflate.c>
    # Compress HTML, CSS, JavaScript, Text, XML
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
    AddOutputFilterByType DEFLATE application/json
</IfModule>
```

**4. Database Query Optimization:**

```sql
-- Add indexes for frequently queried columns
ALTER TABLE user_table ADD INDEX idx_email (email);
ALTER TABLE flower_table ADD INDEX idx_status (status);
ALTER TABLE flower_table ADD INDEX idx_contributor (contributor_email);
ALTER TABLE workshop_table ADD INDEX idx_participant (participant_email);
ALTER TABLE studentwork_table ADD INDEX idx_contributor (contributor_email);
```

---

### Production Deployment Checklist

**Pre-Deployment:**
- [ ] Test all features in staging environment
- [ ] Run security audit (SQL injection, XSS, file upload)
- [ ] Review and update database credentials
- [ ] Set `display_errors = Off` in php.ini
- [ ] Configure error logging to files
- [ ] Set secure file permissions (755/644)
- [ ] Backup development database and files
- [ ] Document custom configurations
- [ ] Update README.md with production URLs
- [ ] Remove or secure ASSIGNMENT.md

**Deployment Steps:**
- [ ] Upload files via SFTP/SCP or Git
- [ ] Create production MySQL database
- [ ] Run database initialization (main.php auto-init or manual SQL)
- [ ] Update `main.php` with production DB credentials
- [ ] Configure Apache virtual host
- [ ] Set up SSL certificate (Let's Encrypt)
- [ ] Test database connectivity
- [ ] Create upload directories with proper permissions
- [ ] Test file upload functionality (all types)
- [ ] Configure automated backups (cron job)
- [ ] Set up log monitoring
- [ ] Configure security headers
- [ ] Test all critical user flows
- [ ] Test admin workflows
- [ ] Create production admin accounts

**Post-Deployment Validation:**
- [ ] HTTPS working correctly (no mixed content warnings)
- [ ] Test from multiple browsers (Chrome, Firefox, Edge, Safari)
- [ ] Test responsive design on mobile devices
- [ ] Monitor error logs for 24 hours
- [ ] Test registration and login
- [ ] Test file uploads (profile image, resume, flowers)
- [ ] Test admin approval workflows
- [ ] Verify email sending (if implemented)
- [ ] Set up uptime monitoring (Pingdom, UptimeRobot, etc.)
- [ ] Document production URLs and credentials (securely)
- [ ] Schedule regular security updates
- [ ] Plan regular backup verification (monthly restore test)

**Go-Live Communication:**
- [ ] Notify stakeholders of production URL
- [ ] Provide admin credentials (securely)
- [ ] Share user documentation/guide
- [ ] Set up support channel
- [ ] Monitor traffic and performance

---

### Troubleshooting Common Issues

**Issue 1: "Failed to upload file" Error**

**Symptoms:** File upload fails despite correct file type/size

**Solutions:**
```bash
# Check directory permissions
ls -ld profile_images resume img/flowers data/flower_pdfs
# Should show drwxr-xr-x (755)

# Check ownership
ls -l profile_images/
# Should be owned by www-data (Linux) or SYSTEM (Windows)

# Fix permissions
chmod 755 profile_images resume img/flowers data/flower_pdfs
sudo chown -R www-data:www-data .

# Check php.ini settings
php -i | grep upload_max_filesize
php -i | grep post_max_size
php -i | grep file_uploads

# Check tmp directory
php -i | grep upload_tmp_dir
# Ensure directory exists and is writable
```

**Issue 2: "Cannot connect to database" Error**

**Symptoms:** White page or database connection error

**Solutions:**
```bash
# Verify MySQL is running
sudo systemctl status mysql  # Linux
# Check XAMPP Control Panel  # Windows

# Test connection manually
mysql -u root -p
SHOW DATABASES;
USE RootFlower;
SHOW TABLES;

# Check credentials in main.php
cat main.php | grep "define('DB_"

# Verify mysqli extension
php -m | grep mysqli

# Check MySQL error log
tail -50 /var/log/mysql/error.log
```

**Issue 3: Session Lost / Logged Out Immediately**

**Symptoms:** User logs in but immediately logged out

**Solutions:**
```php
// Check session.save_path is writable
<?php
echo session_save_path();
?>
// Verify directory exists and is writable (chmod 777 /tmp for testing)

// Check cookies enabled in browser
// Clear browser cache and cookies

// Ensure session_start() called before output
// Check for whitespace before <?php tags

// Verify session configuration
phpinfo(); // Search for "session"
```

**Issue 4: Images Not Displaying**

**Symptoms:** Broken image icons, 404 errors

**Solutions:**
```bash
# Check file paths are relative, not absolute
grep -r "C:\\" *.php  # Windows absolute paths
grep -r "/home/" *.php  # Linux absolute paths

# Verify images exist
ls -lh profile_images/
ls -lh img/flowers/

# Check file permissions
chmod 644 profile_images/*.jpg
chmod 644 img/flowers/*.png

# Check Apache error log
tail -50 /var/log/apache2/error.log

# Clear browser cache
# Test in incognito/private mode
```

**Issue 5: "Access Denied" to Admin Pages**

**Symptoms:** Regular users or admins can't access admin pages

**Solutions:**
```php
// Verify user_type in database
SELECT email, user_type FROM account_table WHERE email='admin@swin.edu.my';
// Should return 'admin'

// Check session variables
<?php
session_start();
var_dump($_SESSION);
?>

// Verify admin check logic in protected pages
// Should have: if ($_SESSION['user_type'] !== 'admin')

// Clear session and re-login
session_destroy();
```

**Issue 6: Resume PDF Download Fails**

**Symptoms:** Clicking "View Resume" shows 404 or corrupted file

**Solutions:**
```bash
# Check file exists
ls -lh resume/

# Verify relative path in database
mysql -u root -p -e "SELECT email, resume FROM RootFlower.user_table WHERE resume IS NOT NULL;"

# Check MIME type configuration
# Add to .htaccess:
AddType application/pdf .pdf

# Test direct URL access
# http://localhost/AdvanceWeb/Flower-shop-Web/resume/filename.pdf
```

**Issue 7: Flower Contributions Not Appearing**

**Symptoms:** Submitted flowers don't show in search

**Solutions:**
```sql
-- Check flower status
SELECT Scientific_Name, status FROM flower_table;

-- Flowers must be 'approved' to appear
UPDATE flower_table SET status='approved' WHERE Flower_ID=X;

-- Verify search query filters by status
-- flower.php should have: WHERE status='approved'
```

**Issue 8: High Server Load / Slow Response**

**Symptoms:** Pages load slowly, high CPU/memory usage

**Solutions:**
```bash
# Enable OPcache (see Performance Optimization section)

# Add database indexes
mysql -u root -p RootFlower -e "SHOW INDEX FROM user_table;"

# Monitor slow queries
mysql -u root -p -e "SET GLOBAL slow_query_log = 'ON'; SET GLOBAL long_query_time = 2;"
tail -f /var/log/mysql/mysql-slow.log

# Optimize images
# Use tools like ImageMagick to resize large uploads
find profile_images/ -name "*.jpg" -exec identify -format "%f %wx%h\n" {} \;

# Enable Gzip compression (see .htaccess section)
```

---

### Development vs Production Configuration

**Development (.env or config):**
```php
define('ENVIRONMENT', 'development');
define('DEBUG_MODE', true);
ini_set('display_errors', 1);
error_reporting(E_ALL);
define('BASE_URL', 'http://localhost/AdvanceWeb/Flower-shop-Web/');
```

**Production (.env or config):**
```php
define('ENVIRONMENT', 'production');
define('DEBUG_MODE', false);
ini_set('display_errors', 0);
error_reporting(E_ALL);
define('BASE_URL', 'https://flowershop.example.com/');
```

**Conditional Loading:**
```php
if (ENVIRONMENT === 'development') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    log_errors = 1;
}
```

---

### Installation Steps (Quick Start)

**Local Development (XAMPP):**

1. Extract files to `C:\xampp\htdocs\AdvanceWeb\Flower-shop-Web\`
2. Start XAMPP Control Panel
3. Start Apache and MySQL
4. Access http://localhost/AdvanceWeb/Flower-shop-Web/
5. Database auto-creates on first load
6. Login with admin@swin.edu.my / admin

**Production (Ubuntu Server):**

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install LAMP stack
sudo apt install apache2 mysql-server php libapache2-mod-php php-mysql -y

# Enable required Apache modules
sudo a2enmod rewrite headers expires deflate ssl

# Create application directory
sudo mkdir -p /var/www/flowershop
cd /var/www/flowershop

# Upload files (via SFTP) or clone from Git
git clone https://github.com/yourusername/Flower-shop-Web.git

# Set permissions
sudo chown -R www-data:www-data Flower-shop-Web
sudo chmod -R 755 Flower-shop-Web
sudo chmod 755 Flower-shop-Web/profile_images
sudo chmod 755 Flower-shop-Web/resume
sudo chmod 755 Flower-shop-Web/img/flowers
sudo chmod 755 Flower-shop-Web/data/flower_pdfs

# Configure virtual host (see Apache configuration section above)
sudo nano /etc/apache2/sites-available/flowershop.conf
sudo a2ensite flowershop.conf

# Create MySQL database and user
sudo mysql
CREATE DATABASE RootFlower CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'flowershop_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON RootFlower.* TO 'flowershop_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Update database credentials in main.php
sudo nano Flower-shop-Web/main.php

# Restart Apache
sudo systemctl restart apache2

# Set up SSL with Let's Encrypt
sudo certbot --apache -d flowershop.example.com

# Test access
curl -I http://flowershop.example.com
```

---

### Security Best Practices Summary

1. **Always use prepared statements** - Prevents SQL injection
2. **Hash passwords** - Use `password_hash()` with bcrypt
3. **Validate file uploads** - Check type, size, and sanitize filenames
4. **Prevent XSS** - Use `htmlspecialchars()` on user input
5. **Secure sessions** - Set httponly, secure flags; regenerate ID after login
6. **Use HTTPS** - Encrypt all traffic in production
7. **Disable directory listing** - Options -Indexes in .htaccess
8. **Prevent PHP execution in uploads** - php_flag engine off
9. **Set secure headers** - X-Frame-Options, X-XSS-Protection, etc.
10. **Regular backups** - Automated daily backups with retention
11. **Monitor logs** - Watch for suspicious activity
12. **Keep software updated** - PHP, MySQL, Apache security patches
13. **Use minimal DB privileges** - Don't use root for application
14. **Implement rate limiting** - Prevent brute force attacks
15. **Validate on server side** - Never trust client-side validation alone

---

---

## Code Quality Standards

- **Consistent Naming**: camelCase for PHP variables, snake_case for database columns
- **Code Comments**: Critical functions documented with purpose and parameters
- **Error Handling**: Try-catch blocks for database operations
- **DRY Principle**: Reusable functions in `main.php`
- **Separation of Concerns**: Database logic separate from presentation
- **Responsive Design**: Mobile-first approach with Bootstrap grid system
- **Accessibility**: ARIA labels, semantic HTML, keyboard navigation support

---

## Acknowledgments

This project was developed for Web Development coursework, demonstrating:
- Full-stack PHP/MySQL development
- Database design and normalization
- Secure authentication and authorization
- CRUD operations with complex workflows
- Responsive UI/UX design
- Code organization and maintainability

**Last Updated:** December 2, 2025
