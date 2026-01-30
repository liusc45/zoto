# API REST Documentation

Complete API reference for Opticas-Development system.

**Base URL:** `http://localhost:8080/api` (development)

**Authentication:** Bearer Token (CodeIgniter Shield)

**Content-Type:** `application/json`

---

## Table of Contents

- [Authentication](#authentication)
- [Patients](#patients)
- [Sales](#sales)
- [Inventory](#inventory)
- [Items](#items)
- [Consultations](#consultations)
- [Prescriptions](#prescriptions)
- [Payments](#payments)
- [Credits](#credits)
- [Promotions](#promotions)
- [Reports](#reports)
- [Error Responses](#error-responses)

---

## Authentication

All API endpoints require authentication via Bearer Token.

### Login

```http
POST /auth/login
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "password123"
}
```

**Response:**

```json
{
  "success": true,
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "user": {
    "id": 1,
    "email": "admin@example.com",
    "username": "admin"
  }
}
```

### Logout

```http
POST /auth/logout
Authorization: Bearer {token}
```

### Request with Authentication

```http
GET /api/patients
Authorization: Bearer {token}
```

---

## Patients

### List Patients

```http
GET /api/patient
Authorization: Bearer {token}
```

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| search | string | No | Search by name, email, or phone |
| page | integer | No | Page number (default: 1) |
| limit | integer | No | Items per page (default: 20) |
| sort | string | No | Sort field (name, email, created_at) |
| order | string | No | Sort direction (asc, desc) |

**Response:**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "person": {
        "id": 1,
        "name": "Juan",
        "last_name": "Pérez García",
        "email": "juan@email.com",
        "main_phone": "5551234567",
        "dob": "1990-05-15",
        "street": "Av. Reforma 123",
        "city": "Mexico City",
        "state": "CDMX",
        "postal_code": "06600"
      },
      "card_id": "OPT-001234",
      "company": null,
      "store_id": 1,
      "created_at": "2024-01-15T10:30:00Z"
    }
  ],
  "pagination": {
    "current_page": 1,
    "total": 150,
    "per_page": 20,
    "last_page": 8
  }
}
```

### Get Patient

```http
GET /api/patient/{id}
Authorization: Bearer {token}
```

**Response:** Same as list (single object)

### Create Patient

```http
POST /api/patient
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "María",
  "last_name": "López Hernández",
  "dob": "1985-08-22",
  "email": "maria@email.com",
  "main_phone": "5559876543",
  "street": "Calle Principal 456",
  "city": "Guadalajara",
  "state": "Jalisco",
  "postal_code": "44100",
  "card_id": "OPT-001235",
  "company": "Empresa ABC",
  "occupation": "Contadora"
}
```

**Response:**

```json
{
  "success": true,
  "data": {
    "id": 151,
    "person": {
      "id": 151,
      "name": "María",
      "last_name": "López Hernández",
      ...
    },
    "card_id": "OPT-001235",
    "created_at": "2026-01-29T12:00:00Z"
  }
}
```

### Delete Patient

```http
DELETE /api/patient/{id}
Authorization: Bearer {token}
```

**Response:**

```json
{
  "success": true,
  "message": "Patient deleted successfully"
}
```

---

## Sales

### List Sales

```http
GET /api/sale
Authorization: Bearer {token}
```

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| start_date | date | No | Filter by start date (YYYY-MM-DD) |
| end_date | date | No | Filter by end date (YYYY-MM-DD) |
| type | string | No | Filter by type (cash, credit, aside) |
| store_id | integer | No | Filter by store |
| user_id | integer | No | Filter by salesperson |
| page | integer | No | Page number |
| limit | integer | No | Items per page |

**Response:**

```json
{
  "success": true,
  "data": [
    {
      "id": 1234,
      "uuid": "550e8400-e29b-41d4-a716-446655440000",
      "type": "cash",
      "subtotal": 4500.00,
      "discount_total": 200.00,
      "tax_total": 720.00,
      "total": 5020.00,
      "status": "completed",
      "store_id": 1,
      "user_id": 5,
      "customer_id": 45,
      "created_at": "2026-01-29T14:30:00Z",
      "items": [
        {
          "id": 5678,
          "item": {
            "id": 789,
            "name": "Lente Multifocal Progresivo",
            "line": "Lentes",
            "brand": "Essilor"
          },
          "qty": 1,
          "unit_price": 2500.00,
          "subtotal": 2500.00,
          "discount": 100.00
        }
      ],
      "payments": [
        {
          "type": "cash",
          "amount": 5020.00,
          "received": 5020.00,
          "cashback": 0.00
        }
      ]
    }
  ]
}
```

### Get Sale

```http
GET /api/sale/{id}
Authorization: Bearer {token}
```

### Create Sale

```http
POST /api/sale
Authorization: Bearer {token}
Content-Type: application/json

{
  "type": "cash",
  "customer": 45,
  "cart": [
    {
      "id": 789,
      "qty": 1,
      "unit_price": 2500.00,
      "discount": 100.00,
      "lens_side": "pair"
    }
  ],
  "payments": [
    {
      "type": "cash",
      "amount": 5020.00,
      "received": 5200.00,
      "cashback": 180.00
    }
  ],
  "discount_code": "VERANO2026",
  "notes": "Cliente VIP"
}
```

**Sale Types:**
- `cash`: Cash payment (immediate inventory decrement)
- `credit`: Credit sale (creates credit record)
- `aside`: Reserved/partial payment (creates aside record)

**Response:**

```json
{
  "success": true,
  "data": {
    "id": 1235,
    "uuid": "550e8400-e29b-41d4-a716-446655440001",
    "type": "cash",
    "total": 5020.00,
    "status": "completed",
    "created_at": "2026-01-29T14:35:00Z"
  }
}
```

### Update Sale

```http
PUT /api/sale/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "notes": "Updated notes",
  "status": "cancelled"
}
```

### Delete Sale

```http
DELETE /api/sale/{id}
Authorization: Bearer {token}
```

**Note:** This will rollback inventory for all items in the sale.

### Generate Ticket PDF

```http
GET /api/sale/{uuid}/ticket
Authorization: Bearer {token}
```

**Response:** Binary PDF file (Content-Type: application/pdf)

### Get Sales by Store

```http
GET /api/sale/store/{store_id}
Authorization: Bearer {token}
```

### Get Sales by User

```http
GET /api/sale/user/{user_id}
Authorization: Bearer {token}
```

### Generate New UUID

```http
GET /api/sale/uuid
Authorization: Bearer {token}
```

**Response:**

```json
{
  "success": true,
  "uuid": "550e8400-e29b-41d4-a716-446655440002"
}
```

---

## Inventory

### List Inventory

```http
GET /api/inventory
Authorization: Bearer {token}
```

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| store_id | integer | No | Filter by store |
| item_id | integer | No | Filter by item |
| line_id | integer | No | Filter by line |
| min_stock | integer | No | Show items below minimum stock |
| search | string | No | Search by name or code |
| page | integer | No | Page number |

**Response:**

```json
{
  "success": true,
  "data": [
    {
      "id": 123,
      "code": "TIENDA1-00078",
      "store_id": 1,
      "item": {
        "id": 78,
        "name": "Lente Monofocal 1.50",
        "sku": "LEN-001-1.50",
        "line": {
          "id": 13,
          "name": "Lentes"
        },
        "brand": {
          "name": "Essilor"
        }
      },
      "stock": 25,
      "cost_price": 800.00,
      "enter_at": "2026-01-15T00:00:00Z"
    }
  ]
}
```

### Create Inventory Entry

```http
POST /api/inventory
Authorization: Bearer {token}
Content-Type: application/json

{
  "item_id": 78,
  "store_id": 1,
  "stock": 50,
  "cost_price": 800.00,
  "enter_at": "2026-01-29"
}
```

### Update Inventory

```http
PUT /api/inventory/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "stock": 30,
  "cost_price": 850.00
}
```

### Delete Inventory

```http
DELETE /api/inventory/{id}
Authorization: Bearer {token}
```

### Decrease Stock (Internal)

```http
POST /api/inventory/decrease
Authorization: Bearer {token}
Content-Type: application/json

{
  "inventory_id": 123,
  "qty": 5
}
```

---

## Items

### List Items

```http
GET /api/item
Authorization: Bearer {token}
```

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| line_id | integer | No | Filter by line |
| brand_id | integer | No | Filter by brand |
| search | string | No | Search by name or SKU |
| stockable | boolean | No | Filter stockable items |
| page | integer | No | Page number |

**Response:**

```json
{
  "success": true,
  "data": [
    {
      "id": 78,
      "name": "Lente Monofocal 1.50",
      "sku": "LEN-001-1.50",
      "description": "Lente monofocal esférico",
      "line_id": 13,
      "brand_id": 5,
      "line": {
        "id": 13,
        "name": "Lentes"
      },
      "brand": {
        "id": 5,
        "name": "Essilor"
      },
      "is_stockable": true,
      "current_price": 2500.00,
      "total_stock": 25,
      "created_at": "2026-01-01T00:00:00Z"
    }
  ]
}
```

### Get Item

```http
GET /api/item/{id}
Authorization: Bearer {token}
```

### Create Item

```http
POST /api/item
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Nuevo Lente",
  "sku": "LEN-NEW-001",
  "description": "Descripción del lente",
  "line_id": 13,
  "brand_id": 5,
  "is_stockable": true
}
```

### Update Item

```http
PUT /api/item/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Lente Actualizado",
  "description": "Nueva descripción"
}
```

### Delete Item

```http
DELETE /api/item/{id}
Authorization: Bearer {token}
```

---

## Consultations

### List Consultations

```http
GET /api/consultation
Authorization: Bearer {token}
```

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| patient_id | integer | No | Filter by patient |
| doctor_id | integer | No | Filter by doctor |
| start_date | date | No | Filter from date |
| end_date | date | No | Filter to date |
| page | integer | No | Page number |

**Response:**

```json
{
  "success": true,
  "data": [
    {
      "id": 234,
      "patient_id": 45,
      "doctor_id": 3,
      "consultation_date": "2026-01-29T10:00:00Z",
      "notes": "Consulta general",
      "general": {
        "chief_complaint": "Visión borrosa",
        "medical_history": "Hipertensión"
      },
      "visual_evaluation": {
        "right_eye_sph": "-1.50",
        "right_eye_cyl": "-0.50",
        "left_eye_sph": "-2.00",
        "left_eye_cyl": "-0.75"
      },
      "prescription": {
        "id": 123,
        "prescription_date": "2026-01-29"
      }
    }
  ]
}
```

### Create Consultation

```http
POST /api/consultation
Authorization: Bearer {token}
Content-Type: application/json

{
  "patient_id": 45,
  "doctor_id": 3,
  "consultation_date": "2026-01-29",
  "notes": "Consulta de rutina",
  "general": {
    "chief_complaint": "Dolor de cabeza",
    "medical_history": "Diabetes tipo 2"
  },
  "visual_evaluation": {
    "right_eye_sph": "-1.50",
    "right_eye_cyl": "-0.50",
    "right_eye_axis": "90",
    "left_eye_sph": "-2.00",
    "left_eye_cyl": "-0.75",
    "left_eye_axis": "85"
  }
}
```

---

## Prescriptions

### List Prescriptions

```http
GET /api/prescription
Authorization: Bearer {token}
```

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| patient_id | integer | No | Filter by patient |
| start_date | date | No | Filter from date |
| end_date | date | No | Filter to date |

**Response:**

```json
{
  "success": true,
  "data": [
    {
      "id": 123,
      "patient_id": 45,
      "doctor_id": 3,
      "prescription_date": "2026-01-29",
      "details": [
        {
          "eye": "right",
          "sph": "-1.50",
          "cyl": "-0.50",
          "axis": "90",
          "add": "+2.00"
        },
        {
          "eye": "left",
          "sph": "-2.00",
          "cyl": "-0.75",
          "axis": "85",
          "add": "+2.00"
        }
      ]
    }
  ]
}
```

---

## Payments

### List Payments

```http
GET /api/payment
Authorization: Bearer {token}
```

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| sale_id | integer | No | Filter by sale |
| type | string | No | Filter by type (cash, card, transfer) |
| start_date | date | No | Filter from date |
| end_date | date | No | Filter to date |

**Response:**

```json
{
  "success": true,
  "data": [
    {
      "id": 345,
      "sale_id": 1234,
      "type": "cash",
      "amount": 5020.00,
      "received": 5200.00,
      "cashback": 180.00,
      "created_at": "2026-01-29T14:30:00Z"
    }
  ]
}
```

### Create Payment

```http
POST /api/payment
Authorization: Bearer {token}
Content-Type: application/json

{
  "sale_id": 1234,
  "type": "card",
  "amount": 5020.00,
  "card_last_four": "4242",
  "card_holder": "Juan Pérez"
}
```

---

## Credits

### List Credits

```http
GET /api/credit
Authorization: Bearer {token}
```

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| patient_id | integer | No | Filter by patient |
| status | string | No | Filter by status (pending, paid, overdue) |

**Response:**

```json
{
  "success": true,
  "data": [
    {
      "id": 567,
      "sale_id": 1235,
      "patient_id": 45,
      "amount": 5000.00,
      "balance": 3000.00,
      "due_date": "2026-02-28",
      "status": "pending",
      "payments": [
        {
          "id": 890,
          "amount": 1000.00,
          "payment_date": "2026-01-29"
        },
        {
          "id": 891,
          "amount": 1000.00,
          "payment_date": "2026-02-10"
        }
      ]
    }
  ]
}
```

### Make Credit Payment

```http
POST /api/credit/{id}/payment
Authorization: Bearer {token}
Content-Type: application/json

{
  "amount": 500.00,
  "payment_date": "2026-01-29"
}
```

---

## Promotions

### List Promotions

```http
GET /api/promotion
Authorization: Bearer {token}
```

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| active | boolean | No | Show only active promotions |
| code | string | No | Search by code |

**Response:**

```json
{
  "success": true,
  "data": [
    {
      "id": 10,
      "code": "VERANO2026",
      "name": "Promoción Verano 2026",
      "description": "20% de descuento en lentes",
      "type": "percentage",
      "value": 20,
      "start_date": "2026-01-01",
      "end_date": "2026-03-31",
      "active": true,
      "applicable_items": [78, 79, 80]
    }
  ]
}
```

### Validate Promotion Code

```http
POST /api/promotion/validate
Authorization: Bearer {token}
Content-Type: application/json

{
  "code": "VERANO2026",
  "cart": [
    {"id": 78, "qty": 1, "price": 2500.00}
  ]
}
```

**Response:**

```json
{
  "success": true,
  "applicable": true,
  "discount": 500.00,
  "promotion": {
    "id": 10,
    "code": "VERANO2026",
    "type": "percentage",
    "value": 20
  }
}
```

---

## Reports

### Sales Summary

```http
GET /api/report/sales
Authorization: Bearer {token}
```

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| start_date | date | Yes | Report start date |
| end_date | date | Yes | Report end date |
| store_id | integer | No | Filter by store |

**Response:**

```json
{
  "success": true,
  "data": {
    "total_sales": 156,
    "total_amount": 245000.00,
    "average_sale": 1570.51,
    "by_payment_method": {
      "cash": 185000.00,
      "card": 60000.00
    },
    "top_items": [
      {
        "item_name": "Lente Monofocal 1.50",
        "qty_sold": 45,
        "total_revenue": 112500.00
      }
    ]
  }
}
```

### Inventory Report

```http
GET /api/report/inventory
Authorization: Bearer {token}
```

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| store_id | integer | No | Filter by store |

**Response:**

```json
{
  "success": true,
  "data": {
    "total_items": 1234,
    "total_stock": 5678,
    "total_value": 2345000.00,
    "low_stock_items": [
      {
        "item_name": "Lente Multifocal 2.50",
        "current_stock": 3,
        "min_stock": 5
      }
    ]
  }
}
```

---

## Error Responses

All error responses follow this format:

```json
{
  "success": false,
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "Validation failed",
    "details": [
      {
        "field": "email",
        "message": "The email field is required."
      }
    ]
  }
}
```

### Error Codes

| Code | Description | HTTP Status |
|------|-------------|-------------|
| `VALIDATION_ERROR` | Invalid input data | 400 |
| `UNAUTHORIZED` | Authentication required or invalid token | 401 |
| `FORBIDDEN` | Insufficient permissions | 403 |
| `NOT_FOUND` | Resource not found | 404 |
| `CONFLICT` | Resource already exists | 409 |
| `SERVER_ERROR` | Internal server error | 500 |

---

## Rate Limiting

API is rate limited to **1000 requests per minute per user**.

Headers returned:

```http
X-RateLimit-Limit: 1000
X-RateLimit-Remaining: 998
X-RateLimit-Reset: 1643510400
```

---

## Versioning

Current API version: **v1**

API version is included in the URL: `/api/v1/...`

---

## Testing with Postman

Import collection:

```bash
# Download Postman collection
curl -O https://raw.githubusercontent.com/tu-usuario/opticas-development/main/docs/api/postman-collection.json
```

---

## Support

For API support, contact: **soporte@opticas-development.local**
