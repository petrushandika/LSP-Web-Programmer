# 📋 Wedding Organizer API Testing Documentation

## 🚀 Overview
Dokumentasi lengkap untuk testing API Wedding Organizer menggunakan Postman atau tools testing API lainnya.

## 📋 Table of Contents
- [Prerequisites](#prerequisites)
- [Setup](#setup)
- [Authentication](#authentication)
- [User API](#user-api)
- [Catalogue API](#catalogue-api)
- [Order API](#order-api)
- [Setting API](#setting-api)
- [Testing Scenarios](#testing-scenarios)
- [Error Handling](#error-handling)

---

## 🔧 Prerequisites

### System Requirements
- PHP 8.1+
- Laravel 10+
- MySQL/PostgreSQL Database
- Postman atau API Testing Tool

### Development Server
```bash
# Start Laravel development server
php artisan serve
# atau
php -S localhost:8000 -t public public/index.php
```

### Base Configuration
- **Base URL**: `http://localhost:8000`
- **Content-Type**: `application/json`
- **Accept**: `application/json`

---

## 🔐 Authentication
Saat ini API menggunakan web routes tanpa authentication token. Untuk production, disarankan menggunakan Laravel Sanctum atau Passport.

---

## 👥 User API

### 📖 Endpoints Overview
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/users` | Ambil semua user |
| GET | `/users/{id}` | Ambil user berdasarkan ID |
| POST | `/users` | Buat user baru |
| PUT | `/users/{id}` | Update user |
| DELETE | `/users/{id}` | Hapus user |

### 📝 Detailed Documentation

#### 1. GET All Users
```http
GET /users
Accept: application/json
```

**Response Success (200)**:
```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "phone_number": "081234567890",
            "role": "client",
            "address": "Jl. Contoh No. 123, Jakarta",
            "created_at": "2024-01-15T10:30:00.000000Z",
            "updated_at": "2024-01-15T10:30:00.000000Z"
        }
    ],
    "per_page": 15,
    "total": 1
}
```

#### 2. GET User by ID
```http
GET /users/1
Accept: application/json
```

**Response Success (200)**:
```json
{
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "phone_number": "081234567890",
    "role": "client",
    "address": "Jl. Contoh No. 123, Jakarta",
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-01-15T10:30:00.000000Z"
}
```

#### 3. POST Create User
```http
POST /users
Content-Type: application/json
Accept: application/json

{
    "name": "Jane Smith",
    "email": "jane@example.com",
    "password": "password123",
    "phone_number": "081234567891",
    "role": "admin",
    "address": "Jl. Admin No. 456, Jakarta"
}
```

**Response Success (201)**:
```json
{
    "id": 2,
    "name": "Jane Smith",
    "email": "jane@example.com",
    "phone_number": "081234567891",
    "role": "admin",
    "address": "Jl. Admin No. 456, Jakarta",
    "created_at": "2024-01-15T11:00:00.000000Z",
    "updated_at": "2024-01-15T11:00:00.000000Z"
}
```

#### 4. PUT Update User
```http
PUT /users/1
Content-Type: application/json
Accept: application/json

{
    "name": "John Doe Updated",
    "email": "john.updated@example.com",
    "phone_number": "081234567892",
    "role": "admin",
    "address": "Jl. Updated No. 789, Jakarta"
}
```

#### 5. DELETE User
```http
DELETE /users/1
Accept: application/json
```

**Response Success (200)**:
```json
{
    "message": "User deleted successfully"
}
```

---

## 📚 Catalogue API

### 📖 Endpoints Overview
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/catalogues` | Ambil semua katalog |
| GET | `/catalogues/{id}` | Ambil katalog berdasarkan ID |
| POST | `/catalogues` | Buat katalog baru |
| PUT | `/catalogues/{id}` | Update katalog |
| DELETE | `/catalogues/{id}` | Hapus katalog |

### 📝 Detailed Documentation

#### 1. GET All Catalogues
```http
GET /catalogues
Accept: application/json
```

**Response Success (200)**:
```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "title": "Paket Wedding Premium",
            "user_id": 1,
            "price": 50000000,
            "is_publish": 1,
            "description": "Paket wedding premium dengan dekorasi mewah",
            "image": "catalogues/wedding-premium.jpg",
            "created_at": "2024-01-15T10:30:00.000000Z",
            "updated_at": "2024-01-15T10:30:00.000000Z",
            "user": {
                "id": 1,
                "name": "Wedding Organizer ABC"
            }
        }
    ],
    "per_page": 15,
    "total": 1
}
```

#### 2. POST Create Catalogue (with Image Upload)
```http
POST /catalogues
Content-Type: multipart/form-data
Accept: application/json

Form Data:
- title: "Paket Wedding Deluxe"
- user_id: 1
- price: 75000000
- is_publish: 1
- description: "Paket wedding deluxe dengan fasilitas lengkap"
- image: [file upload]
```

#### 3. PUT Update Catalogue
```http
POST /catalogues/1
Content-Type: multipart/form-data
Accept: application/json

Form Data:
- _method: "PUT"
- title: "Paket Wedding Premium Updated"
- user_id: 1
- price: 55000000
- is_publish: 1
- description: "Paket wedding premium updated"
- image: [file upload - optional]
```

---

## 📦 Order API

### 📖 Endpoints Overview
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/orders` | Ambil semua pesanan |
| GET | `/orders/{id}` | Ambil pesanan berdasarkan ID |
| POST | `/orders` | Buat pesanan baru |
| PUT | `/orders/{id}` | Update pesanan |
| DELETE | `/orders/{id}` | Hapus pesanan |

### 📝 Detailed Documentation

#### 1. GET All Orders
```http
GET /orders
Accept: application/json
```

**Response Success (200)**:
```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "user_id": 2,
            "catalogue_id": 1,
            "status": "pending",
            "created_at": "2024-01-15T12:00:00.000000Z",
            "updated_at": "2024-01-15T12:00:00.000000Z",
            "user": {
                "id": 2,
                "name": "Jane Smith",
                "email": "jane@example.com"
            },
            "catalogue": {
                "id": 1,
                "title": "Paket Wedding Premium",
                "price": 50000000
            }
        }
    ],
    "per_page": 15,
    "total": 1
}
```

#### 2. POST Create Order
```http
POST /orders
Content-Type: application/json
Accept: application/json

{
    "user_id": 2,
    "catalogue_id": 1,
    "status": "pending"
}
```

**Response Success (201)**:
```json
{
    "id": 2,
    "user_id": 2,
    "catalogue_id": 1,
    "status": "pending",
    "created_at": "2024-01-15T12:30:00.000000Z",
    "updated_at": "2024-01-15T12:30:00.000000Z"
}
```

#### 3. PUT Update Order Status
```http
PUT /orders/1
Content-Type: application/json
Accept: application/json

{
    "user_id": 2,
    "catalogue_id": 1,
    "status": "approved"
}
```

---

## ⚙️ Setting API

### 📖 Endpoints Overview
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/settings` | Ambil semua pengaturan |
| GET | `/settings/{id}` | Ambil pengaturan berdasarkan ID |
| POST | `/settings` | Buat pengaturan baru |
| PUT | `/settings/{id}` | Update pengaturan |
| DELETE | `/settings/{id}` | Hapus pengaturan |

### 📝 Detailed Documentation

#### 1. POST Create Setting
```http
POST /settings
Content-Type: application/json
Accept: application/json

{
    "company_name": "Wedding Organizer ABC",
    "email": "info@weddingabc.com",
    "phone_number": "021-12345678",
    "address": "Jl. Wedding No. 123, Jakarta Selatan",
    "description": "Wedding organizer terpercaya dengan pengalaman lebih dari 10 tahun"
}
```

**Response Success (201)**:
```json
{
    "id": 1,
    "company_name": "Wedding Organizer ABC",
    "email": "info@weddingabc.com",
    "phone_number": "021-12345678",
    "address": "Jl. Wedding No. 123, Jakarta Selatan",
    "description": "Wedding organizer terpercaya dengan pengalaman lebih dari 10 tahun",
    "created_at": "2024-01-15T13:00:00.000000Z",
    "updated_at": "2024-01-15T13:00:00.000000Z"
}
```

---

## 🧪 Testing Scenarios

### 1. Complete User Flow
```bash
# 1. Create a new user
POST /users (with valid data)

# 2. Get the created user
GET /users/{id}

# 3. Update user information
PUT /users/{id}

# 4. Verify the update
GET /users/{id}

# 5. Delete the user
DELETE /users/{id}

# 6. Verify deletion
GET /users/{id} (should return 404)
```

### 2. Catalogue with Image Upload
```bash
# 1. Create catalogue with image
POST /catalogues (multipart/form-data)

# 2. Verify image is stored
GET /catalogues/{id}

# 3. Update catalogue image
PUT /catalogues/{id} (with new image)

# 4. Delete catalogue
DELETE /catalogues/{id}
```

### 3. Order Management Flow
```bash
# 1. Create user (customer)
POST /users

# 2. Create catalogue
POST /catalogues

# 3. Create order
POST /orders (linking user and catalogue)

# 4. Update order status
PUT /orders/{id} (change status to approved)

# 5. Get order details with relationships
GET /orders/{id}
```

---

## ❌ Error Handling

### Common HTTP Status Codes
| Code | Description | Example |
|------|-------------|---------|
| 200 | Success | Data retrieved successfully |
| 201 | Created | Resource created successfully |
| 400 | Bad Request | Invalid input data |
| 404 | Not Found | Resource not found |
| 422 | Validation Error | Form validation failed |
| 500 | Server Error | Internal server error |

### Validation Error Example (422)
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "name": [
            "The name field is required."
        ]
    }
}
```

### Not Found Error Example (404)
```json
{
    "message": "No query results for model [App\\Models\\User] 999"
}
```

---

## 📁 Postman Collection

Import file `Wedding-Organizer-API.postman_collection.json` ke Postman untuk testing yang lebih mudah:

1. Buka Postman
2. Klik **Import**
3. Pilih file collection
4. Semua endpoint akan tersedia untuk testing

---

## 🔍 Testing Tips

### 1. Environment Variables
Buat environment di Postman dengan:
- `base_url`: `http://localhost:8000`
- `user_id`: ID user yang valid
- `catalogue_id`: ID catalogue yang valid

### 2. Pre-request Scripts
```javascript
// Generate random email for testing
pm.globals.set("random_email", "test" + Math.floor(Math.random() * 1000) + "@example.com");
```

### 3. Test Scripts
```javascript
// Verify response status
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

// Verify response structure
pm.test("Response has required fields", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData).to.have.property('id');
    pm.expect(jsonData).to.have.property('name');
});
```

---

## 📞 Support

Jika mengalami masalah saat testing:
1. Pastikan server Laravel berjalan
2. Cek database connection
3. Verify migration sudah dijalankan
4. Check Laravel logs di `storage/logs/laravel.log`

---

**Happy Testing! 🚀**