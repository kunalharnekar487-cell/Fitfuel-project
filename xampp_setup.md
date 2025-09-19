# XAMPP Setup Instructions for FitFuel

## Step 1: Install and Start XAMPP

1. **Download XAMPP** from https://www.apachefriends.org/
2. **Install XAMPP** on your system
3. **Start XAMPP Control Panel**
4. **Start Apache and MySQL** services

## Step 2: Copy Project to XAMPP Directory

1. Copy the entire `fitfuel` folder to `C:\xampp\htdocs\`
2. Your project should be located at: `C:\xampp\htdocs\fitfuel\`

## Step 3: Setup Database

1. Open **phpMyAdmin** in browser: http://localhost/phpmyadmin
2. Create a new database named `fitfuel_db`
3. Import the database schema:
   - Click on `fitfuel_db` database
   - Go to **Import** tab
   - Select `database/schema.sql` file
   - Click **Go** to import

**OR** run the setup script:
1. Open browser: http://localhost/fitfuel/setup_database.php
2. This will automatically create the database and insert sample data

## Step 4: Access the Application

- **Frontend**: http://localhost/fitfuel/
- **API Endpoints**: http://localhost/fitfuel/api/
- **Admin Panel**: http://localhost/phpmyadmin (for database management)

## Step 5: Test the Backend

Visit http://localhost/fitfuel/ and you should see:
- ✅ Products loading from database
- ✅ API status showing as "running"
- ✅ Add to cart functionality (requires login)

## Default Admin Account
- Username: `admin`
- Password: `admin123`
- Email: `admin@fitfuel.com`

## API Testing URLs

Test these URLs in your browser:
- http://localhost/fitfuel/api/ (API status)
- http://localhost/fitfuel/api/products (Get all products)
- http://localhost/fitfuel/api/products?category=1 (Products by category)
- http://localhost/fitfuel/api/products?search=whey (Search products)

## Troubleshooting

### If you get "Connection error":
1. Make sure MySQL is running in XAMPP
2. Check database credentials in `config/database.php`
3. Ensure `fitfuel_db` database exists

### If API endpoints return 404:
1. Make sure Apache is running
2. Check if mod_rewrite is enabled in XAMPP
3. Verify the project is in `htdocs/fitfuel/`

### If products don't load:
1. Run the database setup script
2. Check browser console for JavaScript errors
3. Verify API endpoints are accessible
