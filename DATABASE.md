# Database Schema

## Tables

### users
User accounts and authentication.

```
id              INT PRIMARY KEY AUTO_INCREMENT
name            VARCHAR(255) NOT NULL
email           VARCHAR(255) UNIQUE NOT NULL
email_verified_at TIMESTAMP NULL
password        VARCHAR(255) NOT NULL (hashed)
is_admin        BOOLEAN DEFAULT false
remember_token  VARCHAR(100) NULL
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

**Indexes:** email (for login lookups)

**Foreign Keys:** None (root entity)

---

### business_profiles
UMKM/business information. One per user.

```
id              INT PRIMARY KEY AUTO_INCREMENT
user_id         INT UNSIGNED UNIQUE NOT NULL
business_name   VARCHAR(255) NOT NULL
owner_name      VARCHAR(255) NULL
address         TEXT NULL
phone           VARCHAR(15) NULL
description     TEXT NULL
created_at      TIMESTAMP
updated_at      TIMESTAMP

FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
```

**Relationship:** User hasOne BusinessProfile

**Notes:**
- Unique on user_id (one profile per user)
- On user delete, cascade deletes profile

---

### categories
Product categories. Per-user.

```
id              INT PRIMARY KEY AUTO_INCREMENT
user_id         INT UNSIGNED NOT NULL
name            VARCHAR(255) NOT NULL
description     TEXT NULL
created_at      TIMESTAMP
updated_at      TIMESTAMP

FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
```

**Relationship:** User hasMany Category

**Notes:**
- Scoped to user (user_id filter on all queries)
- Cascade delete on user

---

### products
Inventory. Per-user, optional category.

```
id              INT PRIMARY KEY AUTO_INCREMENT
user_id         INT UNSIGNED NOT NULL
category_id     INT UNSIGNED NULL
name            VARCHAR(255) NOT NULL
description     TEXT NULL
price           DECIMAL(15,2) NOT NULL
stock           INT DEFAULT 0
unit            VARCHAR(50) DEFAULT 'pcs'
is_active       BOOLEAN DEFAULT true
created_at      TIMESTAMP
updated_at      TIMESTAMP

FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
```

**Relationships:**
- User hasMany Product
- Category hasMany Product

**Notes:**
- Stock is informational only (doesn't auto-decrement)
- Unit field stores measurement (pcs, box, kg, etc)
- is_active allows soft-disable without deletion
- category_id nullable (product can exist without category)

---

### transactions
Sales transactions. Per-user, multiple items each.

```
id              INT PRIMARY KEY AUTO_INCREMENT
user_id         INT UNSIGNED NOT NULL
transaction_code VARCHAR(255) UNIQUE NOT NULL
transaction_date DATE NOT NULL
total_amount    DECIMAL(15,2) DEFAULT 0
notes           TEXT NULL
created_at      TIMESTAMP
updated_at      TIMESTAMP

FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
```

**Relationship:** User hasMany Transaction

**Notes:**
- transaction_code format: `TRX-YYYYMMDD-XXXXX` (e.g., TRX-20240105-00001)
- total_amount = sum of all transaction_items.subtotal
- unique on transaction_code (no duplicates)

---

### transaction_items
Line items in a transaction. Multiple per transaction.

```
id              INT PRIMARY KEY AUTO_INCREMENT
transaction_id  INT UNSIGNED NOT NULL
product_id      INT UNSIGNED NOT NULL
product_name    VARCHAR(255) NOT NULL
price           DECIMAL(15,2) NOT NULL
quantity        INT NOT NULL
subtotal        DECIMAL(15,2) NOT NULL
created_at      TIMESTAMP
updated_at      TIMESTAMP

FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE
FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
```

**Relationships:**
- Transaction hasMany TransactionItem
- Product hasMany TransactionItem

**Notes:**
- Stores snapshot of product_name & price at time of transaction
- If product price changes later, history remains accurate
- subtotal = quantity × price
- DELETE RESTRICT on product_id (can't delete product if in transaction)

---

### blog_posts
Public blog content. Admin-only creation.

```
id              INT PRIMARY KEY AUTO_INCREMENT
title           VARCHAR(255) NOT NULL
slug            VARCHAR(255) UNIQUE NOT NULL
content         LONGTEXT NOT NULL
published_at    TIMESTAMP NULL
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

**Notes:**
- slug for URL-friendly paths (auto-generated from title)
- published_at NULL = draft (not visible to public)
- published_at set = published (visible on /blog)

---

## Relationships Diagram

```
User (1)
  ├──1:1──> BusinessProfile
  ├──1:N──> Category
  ├──1:N──> Product
  │          ├──1:N──> TransactionItem
  │          └──*:N──> Category
  └──1:N──> Transaction
              └──1:N──> TransactionItem
                         └──*:N──> Product

BlogPost (standalone)
```

## Cascade Behavior

**ON DELETE CASCADE** (if user deleted):
- All categories deleted
- All products deleted
- All transactions deleted
- All transaction_items deleted
- Business profile deleted

**ON DELETE SET NULL** (if category deleted):
- Products.category_id set to NULL
- Product remains (not deleted)

**ON DELETE RESTRICT** (if product deleted with transaction_items):
- Deletion blocked until transaction_items removed
- Prevents data loss from accidental deletes

## Queries Reference

### Get user's revenue
```sql
SELECT SUM(total_amount) 
FROM transactions 
WHERE user_id = ?;
```

### Get top selling products
```sql
SELECT product_id, product_name, SUM(quantity) as qty_sold
FROM transaction_items
WHERE transaction_id IN (
    SELECT id FROM transactions WHERE user_id = ?
)
GROUP BY product_id, product_name
ORDER BY qty_sold DESC
LIMIT 10;
```

### Get products with stock < 5
```sql
SELECT * FROM products 
WHERE user_id = ? AND stock < 5 AND is_active = true;
```

### Get transaction history with items
```sql
SELECT t.*, ti.* 
FROM transactions t
LEFT JOIN transaction_items ti ON t.id = ti.transaction_id
WHERE t.user_id = ?
ORDER BY t.transaction_date DESC;
```

## Data Types

- `INT` — Small numbers (ids, quantities)
- `INT UNSIGNED` — Only positive (foreign keys, stock)
- `DECIMAL(15,2)` — Money (price, total, subtotal)
- `VARCHAR(255)` — Short text (names, codes)
- `TEXT` — Long text (descriptions, notes)
- `LONGTEXT` — Very long text (blog content)
- `DATE` — Date only (no time)
- `TIMESTAMP` — Auto-set date+time
- `BOOLEAN` — true/false (is_admin, is_active)

## Indexing

Auto-indexed:
- All PRIMARY KEYs
- All FOREIGN KEYs
- UNIQUE columns (email, transaction_code, slug)

Consider adding for performance:
```sql
CREATE INDEX idx_products_user_id ON products(user_id);
CREATE INDEX idx_products_category_id ON products(category_id);
CREATE INDEX idx_transactions_user_id ON transactions(user_id);
CREATE INDEX idx_transaction_items_transaction_id ON transaction_items(transaction_id);
```

## Migrations

Files in `database/migrations/`:
```
2024_01_01_000000_create_users_table.php
2024_01_02_000000_create_business_profiles_table.php
2024_01_03_000000_create_categories_table.php
2024_01_04_000000_create_products_table.php
2024_01_05_000000_create_transactions_table.php
2024_01_06_000000_create_transaction_items_table.php
2026_09_24_124405_create_cache_table.php
2026_09_24_200000_add_admin_and_blog.php
```

Run all: `php artisan migrate`
Rollback: `php artisan migrate:rollback`

---

See `ARCHITECTURE.md` for relationship loading patterns.