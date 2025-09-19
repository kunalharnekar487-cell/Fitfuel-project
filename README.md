# FitFuel - Gym Supplements E-commerce Platform

A complete PHP-based e-commerce platform for gym supplements with user authentication, product management, cart, wishlist, and wallet functionality.

## Features

- **User Management**: Registration, login, user dashboard
- **Product Catalog**: Browse products by category, search functionality
- **Shopping Cart**: Add/remove products, quantity management
- **Wishlist**: Save favorite products
- **Wallet System**: Digital wallet for payments
- **Lab Reports**: Product quality certificates
- **Admin Dashboard**: Product and order management

## Backend Structure

```
backend/
├── config/
│   ├── database.php     # Database connection
│   └── cors.php         # CORS headers
├── models/
│   ├── User.php         # User model
│   ├── Product.php      # Product model
│   ├── Cart.php         # Cart model
│   └── Wishlist.php     # Wishlist model
├── api/
│   ├── auth/
│   │   ├── login.php    # User login endpoint
│   │   └── register.php # User registration endpoint
│   ├── products/
│   │   └── get_products.php # Products API
│   ├── cart/
│   │   ├── add_to_cart.php  # Add to cart API
│   │   └── get_cart.php     # Get cart items API
│   └── wishlist/
│       └── add_to_wishlist.php # Add to wishlist API
└── database/
    └── schema.sql       # Database schema
```

## Setup Instructions

### Prerequisites
- PHP 7.4 or higher
- MySQL/MariaDB
- XAMPP/WAMP (recommended for Windows)

### Installation

1. **Start MySQL Server**
   - Start XAMPP/WAMP and ensure MySQL is running

2. **Setup Database**
   ```bash
   php setup_database.php
   ```

3. **Configure Database Connection**
   - Update `config/database.php` if needed (default: localhost, root, no password)

4. **Start PHP Development Server**
   ```bash
   php -S localhost:8000 server.php
   ```

5. **Access the Application**
   - Frontend: http://localhost:8000
   - API: http://localhost:8000/api

## API Endpoints

### Authentication
- `POST /api/auth/login` - User login
- `POST /api/auth/register` - User registration

### Products
- `GET /api/products` - Get all products
- `GET /api/products?category=1` - Get products by category
- `GET /api/products?search=whey` - Search products

### Cart
- `POST /api/cart/add` - Add product to cart
- `GET /api/cart` - Get cart items

### Wishlist
- `POST /api/wishlist/add` - Add product to wishlist

## Database Schema

The database includes the following tables:
- `users` - User accounts and wallet balances
- `categories` - Product categories
- `products` - Product catalog
- `cart` - Shopping cart items
- `wishlist` - User wishlists
- `orders` - Order history
- `order_items` - Order line items
- `wallet_transactions` - Wallet transaction history

## Sample Data

The setup includes sample products:
- FitFuel Whey Protein Isolate (₹1,899)
- FitFuel Creatine Monohydrate (₹899)
- FitFuel Pre-Workout Blast (₹1,299)
- FitFuel Mass Gainer Pro (₹2,499)
- FitFuel BCAA Recovery (₹999)
- FitFuel Multivitamin (₹599)

## Default Admin Account
- Username: admin
- Password: admin123
- Email: admin@fitfuel.com

## Development

To extend the functionality:
1. Add new models in `models/` directory
2. Create corresponding API endpoints in `api/` directory
3. Update the routing in `server.php`
4. Add database migrations to `database/schema.sql`

## Security Features

- Password hashing with PHP's `password_hash()`
- SQL injection prevention with prepared statements
- Session-based authentication
- CORS headers for API security
- Input validation and sanitization
