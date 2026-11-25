# API Routes

## Public Routes

### Homepage & Blog

```
GET /                       Homepage (public)
GET /blog                   Blog listing (published posts only)
GET /blog/{slug}            Blog post detail
GET /sitemap.xml            Sitemap for SEO
GET /robots.txt             Robots directive
```

No authentication required. Anyone can view.

---

## Authentication Routes

### Login

```
GET  /login                 Login form
POST /login                 Submit credentials

Request body:
  email: string (required)
  password: string (required, min:8)

Response:
  Success: Redirect to /dashboard with session
  Error: Redirect to /login with errors
```

Rate limit: 5 attempts per 10 minutes

### Register

```
GET  /register              Registration form
POST /register              Create account

Request body:
  name: string (required)
  email: string (required, unique, valid email)
  password: string (required, min:8)
  password_confirmation: string (required, match password)

Response:
  Success: Redirect to /login
  Error: Redirect to /register with validation errors
```

Rate limit: 5 accounts per 10 minutes

### Logout

```
POST /logout                End session

Response:
  Redirect to / (homepage)
```

Requires: Authentication

---

## Authenticated Routes

All require `auth` middleware (logged in user).

### Dashboard

```
GET /dashboard              Dashboard summary

Response:
  - Total revenue (sum of transactions)
  - Transaction count
  - Active products count
  - Recent transactions (last 5)
```

---

### Business Profile

```
GET  /business/edit         Edit form
PUT  /business              Update profile

Fields:
  business_name: string (required)
  owner_name: string (optional)
  address: string (optional)
  phone: string (optional, max:15)
  description: text (optional)

Response:
  Success: Redirect to /dashboard with message
  Error: Return form with validation errors
```

Only one profile per user (1:1 relationship).

---

### Categories (CRUD)

```
GET  /categories            List all categories
GET  /categories/create     Create form
POST /categories            Store new category
GET  /categories/{id}/edit  Edit form
PUT  /categories/{id}       Update category
DELETE /categories/{id}     Delete category

Fields:
  name: string (required, unique per user)
  description: text (optional)

Response:
  List: JSON or HTML table
  Create/Update: Redirect with message or form with errors
  Delete: Redirect to list
```

Scoped: Only user's own categories visible/editable.

---

### Products (CRUD)

```
GET  /products              List all products
GET  /products/create       Create form
POST /products              Store new product
GET  /products/{id}/edit    Edit form
PUT  /products/{id}         Update product
DELETE /products/{id}       Delete product

Fields:
  name: string (required)
  category_id: int (optional, must be user's category)
  description: text (optional)
  price: decimal (required, >= 0)
  stock: int (optional, >= 0)
  unit: string (optional, default "pcs")
  is_active: boolean (optional, default true)

Response:
  List: HTML table with edit/delete buttons
  Create/Update: Redirect with message or form with errors
  Delete: Redirect to list
```

Scoped: Only user's own products visible/editable.

---

### Transactions (Create, Read, Delete)

```
GET  /transactions          List all transactions
GET  /transactions/create   Create form
POST /transactions          Store new transaction
GET  /transactions/{id}     View transaction detail
DELETE /transactions/{id}   Delete transaction

Fields (header):
  transaction_date: date (required)
  notes: text (optional)

Fields (items, array):
  {
    product_id: int (required, user's product)
    quantity: int (required, >= 1)
    price: decimal (auto-filled from product)
    subtotal: decimal (auto-calculated: qty * price)
  }

Response:
  List: HTML table showing date, code, total, items count
  Detail: Full transaction with line items
  Create: Form with product picker + dynamic item rows
  Delete: Redirect to list with confirmation
```

Auto-generates transaction_code on creation (TRX-YYYYMMDD-XXXXX).
Calculates total_amount as sum of subtotals.
Scoped: Only user's own transactions.

---

### Reports

```
GET /reports                Report dashboard
GET /reports/export         Export CSV

Response (/reports):
  - Total revenue (all time)
  - Total transactions
  - Total items sold
  - Top 10 products (name, qty, revenue)
  - Monthly trend (optional)

Response (/reports/export):
  CSV file download (transactions.csv)
  Columns: date, code, total, item_count
```

Scoped: Only user's own data included.

---

## Admin Routes

Require `admin` middleware (is_admin = true).

Rate limit: 60 requests/minute

### Blog Management

```
GET  /admin/blog            Blog list (all posts, published/draft)
GET  /admin/blog/create     Create form
POST /admin/blog            Store post
GET  /admin/blog/{id}/edit  Edit form
PUT  /admin/blog/{id}       Update post
DELETE /admin/blog/{id}     Delete post

Fields:
  title: string (required, max:255)
  slug: string (required, unique, auto-generated from title)
  content: text (required)
  published_at: timestamp (optional, null = draft)

Response:
  List: HTML table showing title, publish status, date
  Create/Update: Form with markdown editor
  Delete: Redirect to list with confirmation
```

---

## Response Formats

### Success (HTML)
```
Redirect with flash message:
  session('message') = "Product created successfully"
  session('alert') = "success" | "info" | "warning" | "error"
```

### Success (JSON)
```json
{
  "status": "success",
  "data": { ... },
  "message": "Operation completed"
}
```

### Errors (HTML)
```
422 Unprocessable Entity:
  $errors (Blade variable with field errors)
  Redirect back with old input

404 Not Found:
  Route not found or resource doesn't exist

403 Forbidden:
  User not authorized (doesn't own resource, not admin)
```

### Errors (JSON)
```json
{
  "status": "error",
  "message": "Validation failed",
  "errors": {
    "field_name": ["Error message"]
  }
}
```

---

## Pagination

List views support pagination:
```
GET /products?page=2

Response: 15 items per page by default
Includes: links(), current_page, last_page, total
```

---

## Rate Limiting

Global throttle: 60 requests/minute per user

Specific endpoints:
- `POST /login` — 5 per 10 minutes
- `POST /register` — 5 per 10 minutes
- Admin routes — 60 per 1 minute

Exceeded: 429 Too Many Requests

---

## Middleware Stack

Applied to all authenticated routes:

```
web                 → Session, CSRF tokens
auth                → Check logged in
throttle:60,1       → Rate limiting
user ownership      → Custom validation
```

Applied to admin routes:

```
web
auth
admin              → Check is_admin = true
throttle:60,1      → Stricter limit
```

---

## Examples

### Create Transaction

```
POST /transactions

Body:
{
  "transaction_date": "2024-01-10",
  "notes": "Sale from store",
  "items": [
    {
      "product_id": 5,
      "quantity": 2
    },
    {
      "product_id": 12,
      "quantity": 1
    }
  ]
}

Response (success):
  Redirect to /transactions
  Message: "Transaction TRX-20240110-00001 created"

Database:
  INSERT transactions (user_id, transaction_code, transaction_date, total_amount, notes)
  VALUES (1, 'TRX-20240110-00001', '2024-01-10', 17450000, 'Sale from store')
  
  INSERT transaction_items (transaction_id, product_id, product_name, price, quantity, subtotal)
  VALUES (15, 5, 'Laptop Dell', 8500000, 2, 17000000)
  VALUES (15, 12, 'Mouse', 150000, 1, 150000)
```

### Export Report

```
GET /reports/export?from=2024-01-01&to=2024-01-31

Response: CSV file
  transaction_date, transaction_code, total_amount, item_count
  2024-01-05, TRX-20240105-00001, 17450000, 2
  2024-01-10, TRX-20240110-00001, 5200000, 3
  ...
```

---

See `ARCHITECTURE.md` for request flow details.