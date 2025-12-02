# Setup Guide - Root Flowers Web Application

## Quick Start (5 Minutes)

### Step 1: Check Your Folders
Make sure you have these folders in your project:
- `img/` (for images)
- `data/flower_pdfs/` OR `flower_description/` (for PDF files)
- `profile_images/` (will be created automatically)
- `resume/` (will be created automatically)

### Step 2: Start XAMPP
1. Open XAMPP Control Panel
2. Click "Start" for Apache
3. Click "Start" for MySQL

### Step 3: Open the Website
1. Open your browser
2. Go to: `http://localhost/AdvanceWeb/Flower-shop-Web/`
3. The database will create automatically!

### Step 4: Login as Admin
- **Email**: admin@swin.edu.my
- **Password**: admin

That's it! You're ready to use the system.

---

## Folder Structure

```
Flower-shop-Web/
├── img/                        (product images)
│   └── flowers/               (user-contributed flowers)
├── flower_description/        (flower description PDFs - 7MB max)
├── data/
│   ├── rootflower.txt         (legacy text file)
│   └── workshop_reg.txt       (legacy text file)
├── profile_images/            (user profile pictures)
├── resume/                    (user resume PDFs)
├── style/
│   └── style.css             (all styling)
└── *.php files               (application pages)
```

---

## Database Tables

The system creates 5 tables automatically:
1. **user_table** - User profiles
2. **account_table** - Login credentials
3. **flower_table** - Flower database
4. **workshop_table** - Workshop registrations
5. **studentwork_table** - Student submissions

---

## User Features

- ✅ Register and login
- ✅ Update profile with photo
- ✅ Upload resume (PDF)
- ✅ Browse products and workshops
- ✅ Register for workshops
- ✅ Submit student work
- ✅ Identify flowers by photo
- ✅ Contribute flowers to database

## Admin Features

- ✅ Manage user accounts
- ✅ Approve/reject workshop registrations
- ✅ Approve/reject student works
- ✅ Approve/reject flower contributions

---

## Troubleshooting

**Problem**: Can't login?
- **Solution**: Make sure MySQL is running in XAMPP

**Problem**: Images not showing?
- **Solution**: Check that image files exist in `img/` folder

**Problem**: Upload not working?
- **Solution**: Make sure folders have write permissions

**Problem**: Database error?
- **Solution**: Delete database and reload page - it will recreate automatically

---

## Video Demonstration Checklist

Record these features for your submission:

1. ☐ User registration
2. ☐ User login
3. ☐ Profile update with image
4. ☐ Resume upload
5. ☐ Flower identification by photo
6. ☐ Flower contribution
7. ☐ Admin login
8. ☐ Admin approval workflows

---

## Credits

**Student**: Neng Yi Chieng  
**Course**: Web Development  
**Date**: December 2025
