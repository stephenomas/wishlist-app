##  Setup Instructions

### 1. Clone the Repository

git clone https://github.com/your-username/wishlist-api.git
cd wishlist-api

### 2. Install Dependencies

composer install

### 3. Copy and Configure Environment File

cp .env.example .env

### 4.  Generate App Key

php artisan key:generate

### 5.  Run Migrations and Seeders

php artisan migrate --seed

### API Documentation

Register
POST /api/register

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "secret",
  "password_confirmation": "secret"
}

Login
POST /api/login

{
  "email": "john@example.com",
  "password": "secret"
}

Logout
POST /api/logout
(Requires auth token in Authorization header)

Products
Get All Products
GET /api/products

Wishlist
Get Wishlist
GET /api/wishlist
Requires Auth

Add Product to Wishlist
POST /api/wishlist/{productId}
Requires Auth

Remove Product from Wishlist
DELETE /api/wishlist/{productId}
Requires Auth

### Testing

To run tests:

php artisan test
This includes:

User registration/login tests

Wishlist feature tests

Product retrieval tests
