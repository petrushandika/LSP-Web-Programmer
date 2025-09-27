# 📋 Wedding Organizer API Testing Documentation

## 🚀 Overview
Dokumentasi lengkap untuk testing API Wedding Organizer menggunakan Postman atau tools testing API lainnya.

**PENTING**: API endpoints sekarang tersedia di `/api/` dengan response JSON murni, terpisah dari web routes yang mengembalikan views HTML.

## 📋 Table of Contents
- [Prerequisites](#prerequisites)
- [Setup](#setup)
- [API vs Web Routes](#api-vs-web-routes)
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
- **API Base URL**: `http://localhost:8000/api/`
- **Content-Type**: `application/json`
- **Accept**: `application/json`

---

## 🔄 API vs Web Routes

### API Routes (`/api/`)
- **Purpose**: JSON responses untuk aplikasi mobile, SPA, atau integrasi sistem
- **Response**: Pure JSON data
- **Controllers**: `App\Http\Controllers\Api\*ApiController`
- **Base URL**: `http://localhost:8000/api/`

### Web Routes (`/`)
- **Purpose**: HTML views untuk web interface
- **Response**: Rendered HTML pages (Blade templates)
- **Controllers**: `App\Http\Controllers\*Controller`
- **Base URL**: `http://localhost:8000/`

**Contoh**:
- API: `GET /api/users` → JSON response
- Web: `GET /users` → HTML page

---

## 🔐 Authentication
Saat ini API menggunakan web routes tanpa authentication token. Untuk production, disarankan menggunakan Laravel Sanctum atau Passport.

---

## 👥 User API

### 📖 Endpoints Overview
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/users` | Ambil semua user |
| GET | `/api/users/{id}` | Ambil user berdasarkan ID |
| POST | `/api/users` | Buat user baru |
| PUT | `/api/users/{id}` | Update user |
| DELETE | `/api/users/{id}` | Hapus user |

### 📝 Detailed Documentation

#### 1. GET All Users
```http
GET /api/users
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
GET /api/users/1
Accept: application/json
```

**Response Success (200)**:
```json
{
    "message": "User retrieved successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "phone_number": "081234567890",
        "role": "client",
        "address": "Jl. Contoh No. 123, Jakarta",
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-15T10:30:00.000000Z"
    }
}
```

#### 3. POST Create User
```http
POST /api/users
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
    "message": "User created successfully",
    "data": {
        "id": 2,
        "name": "Jane Smith",
        "email": "jane@example.com",
        "phone_number": "081234567891",
        "role": "admin",
        "address": "Jl. Admin No. 456, Jakarta",
        "created_at": "2024-01-15T11:00:00.000000Z",
        "updated_at": "2024-01-15T11:00:00.000000Z"
    }
}
```

#### 4. PUT Update User
```http
PUT /api/users/1
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

**Response Success (200)**:
```json
{
    "message": "User updated successfully",
    "data": {
        "id": 1,
        "name": "John Doe Updated",
        "email": "john.updated@example.com",
        "phone_number": "081234567892",
        "role": "admin",
        "address": "Jl. Updated No. 789, Jakarta",
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-15T11:30:00.000000Z"
    }
}
```

#### 5. DELETE User
```http
DELETE /api/users/1
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
| GET | `/api/catalogues` | Ambil semua katalog |
| GET | `/api/catalogues/{id}` | Ambil katalog berdasarkan ID |
| POST | `/api/catalogues` | Buat katalog baru |
| PUT | `/api/catalogues/{id}` | Update katalog |
| DELETE | `/api/catalogues/{id}` | Hapus katalog |

### 📝 Detailed Documentation

#### 1. GET All Catalogues
```http
GET /api/catalogues
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
                "name": "Wedding Organizer ABC",
                "email": "admin@weddingabc.com"
            }
        }
    ],
    "per_page": 15,
    "total": 1
}
```

#### 2. POST Create Catalogue (with Image Upload)
```http
POST /api/catalogues
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

**Response Success (201)**:
```json
{
    "message": "Catalogue created successfully",
    "data": {
        "id": 2,
        "title": "Paket Wedding Deluxe",
        "user_id": 1,
        "price": 75000000,
        "is_publish": 1,
        "description": "Paket wedding deluxe dengan fasilitas lengkap",
        "image": "catalogues/deluxe-wedding.jpg",
        "created_at": "2024-01-15T12:00:00.000000Z",
        "updated_at": "2024-01-15T12:00:00.000000Z",
        "user": {
            "id": 1,
            "name": "Wedding Organizer ABC",
            "email": "admin@weddingabc.com"
        }
    }
}
```

#### 3. PUT Update Catalogue
```http
PUT /api/catalogues/1
Content-Type: multipart/form-data
Accept: application/json

Form Data:
- title: "Paket Wedding Premium Updated"
- user_id: 1
- price: 55000000
- is_publish: 1
- description: "Paket wedding premium updated"
- image: [file upload - optional]
- remove_image: false
```

---

## 📦 Order API

### 📖 Endpoints Overview
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/orders` | Ambil semua pesanan |
| GET | `/api/orders/{id}` | Ambil pesanan berdasarkan ID |
| POST | `/api/orders` | Buat pesanan baru |
| PUT | `/api/orders/{id}` | Update pesanan |
| DELETE | `/api/orders/{id}` | Hapus pesanan |

### 📝 Detailed Documentation

#### 1. GET All Orders
```http
GET /api/orders
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
                "email": "jane@example.com",
                "phone_number": "081234567891",
                "role": "client",
                "address": "Jl. Client No. 789, Jakarta"
            },
            "catalogue": {
                "id": 1,
                "title": "Paket Wedding Premium",
                "price": 50000000,
                "user_id": 1
            }
        }
    ],
    "per_page": 15,
    "total": 1
}
```

#### 2. POST Create Order
```http
POST /api/orders
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
    "message": "Order created successfully",
    "data": {
        "id": 2,
        "user_id": 2,
        "catalogue_id": 1,
        "status": "pending",
        "created_at": "2024-01-15T12:30:00.000000Z",
        "updated_at": "2024-01-15T12:30:00.000000Z",
        "user": {
            "id": 2,
            "name": "Jane Smith",
            "email": "jane@example.com",
            "phone_number": "081234567891",
            "role": "client",
            "address": "Jl. Client No. 789, Jakarta"
        },
        "catalogue": {
            "id": 1,
            "title": "Paket Wedding Premium",
            "price": 50000000,
            "user_id": 1
        }
    }
}
```

#### 3. PUT Update Order Status
```http
PUT /api/orders/1
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
| GET | `/api/settings` | Ambil semua pengaturan |
| GET | `/api/settings/{id}` | Ambil pengaturan berdasarkan ID |
| POST | `/api/settings` | Buat pengaturan baru |
| PUT | `/api/settings/{id}` | Update pengaturan |
| DELETE | `/api/settings/{id}` | Hapus pengaturan |

### 📝 Detailed Documentation

#### 1. POST Create Setting
```http
POST /api/settings
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
    "message": "Setting created successfully",
    "data": {
        "id": 1,
        "company_name": "Wedding Organizer ABC",
        "email": "info@weddingabc.com",
        "phone_number": "021-12345678",
        "address": "Jl. Wedding No. 123, Jakarta Selatan",
        "description": "Wedding organizer terpercaya dengan pengalaman lebih dari 10 tahun",
        "created_at": "2024-01-15T13:00:00.000000Z",
        "updated_at": "2024-01-15T13:00:00.000000Z"
    }
}
```

---

## 🧪 Testing Scenarios

### 1. Complete User Flow
```bash
# 1. Create a new user
POST /api/users (with valid data)

# 2. Get the created user
GET /api/users/{id}

# 3. Update user information
PUT /api/users/{id}

# 4. Verify the update
GET /api/users/{id}

# 5. Delete the user
DELETE /api/users/{id}

# 6. Verify deletion
GET /api/users/{id} (should return 404)
```

### 2. Catalogue with Image Upload
```bash
# 1. Create catalogue with image
POST /api/catalogues (multipart/form-data)

# 2. Verify image is stored
GET /api/catalogues/{id}

# 3. Update catalogue image
PUT /api/catalogues/{id} (with new image)

# 4. Delete catalogue
DELETE /api/catalogues/{id}
```

### 3. Order Management Flow
```bash
# 1. Create user (customer)
POST /api/users

# 2. Create catalogue
POST /api/catalogues

# 3. Create order
POST /api/orders (linking user and catalogue)

# 4. Update order status
PUT /api/orders/{id} (change status to approved)

# 5. Get order details with relationships
GET /api/orders/{id}
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
    "message": "Validation failed",
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
    "message": "User not found",
    "error": "No query results for model [App\\Models\\User] 999"
}
```

---

## 📁 Postman Collection

Import file `Wedding-Organizer-API.postman_collection.json` ke Postman untuk testing yang lebih mudah:

1. Buka Postman
2. Klik **Import**
3. Pilih file collection
4. **Update Base URL** ke `http://localhost:8000/api/` untuk API endpoints
5. Semua endpoint akan tersedia untuk testing

---

## 🔍 Testing Tips

### 1. Environment Variables
Buat environment di Postman dengan:
- `api_base_url`: `http://localhost:8000/api`
- `web_base_url`: `http://localhost:8000`
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
    pm.expect(jsonData).to.have.property('message');
    pm.expect(jsonData).to.have.property('data');
});

// Verify API response format
pm.test("Response is proper API format", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData).to.not.have.property('html');
    pm.expect(typeof jsonData).to.equal('object');
});
```

---

## 📞 Support

Jika mengalami masalah saat testing:
1. Pastikan server Laravel berjalan
2. Cek database connection
3. Verify migration sudah dijalankan
4. Check Laravel logs di `storage/logs/laravel.log`
5. Pastikan menggunakan `/api/` prefix untuk API endpoints

---

**Happy API Testing! 🚀**