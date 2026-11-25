# System Architecture

## MVC Pattern

```
HTTP Request
    ↓
routes/web.php (Route matching)
    ↓
Controller (Request handling + validation)
    ↓
Model (Database queries via Eloquent)
    ↓
Database (MySQL/MariaDB)
    ↓
Model returns data
    ↓
View (Blade template rendering)
    ↓
HTTP Response (HTML to browser)
```

## Request Flow Example: Create Product

```
1. User submits form
   POST /products

2. Route matches
   Route::post('/products', [ProductController::class, 'store'])

3. Middleware checks
   - auth: User logged in?
   - throttle: Rate limit OK?

4. Controller processes
   ProductController::store()
   - Validate input
   - Get auth user
   - Create Product model
   - Save to database

5. Model relationships
   Product belongsTo User
   Product belongsTo Category
   Product hasMany TransactionItems

6. Response
   Redirect /products with success message
```

## Authentication Flow

```
Login form submission
    ↓
LoginController::login()
    ↓
Hash(password) == users.password in DB?
    ↓
Create session/cookie
Store user_id in session
    ↓
Redirect to dashboard
```

Session persists on every request. Logout clears session.

## Authorization

Two levels:

1. **Middleware-based** (route level)
   ```php
   Route::middleware('auth')...       // Requires login
   Route::middleware('admin')...      // Requires is_admin=true
   ```

2. **Model-based** (resource level)
   ```php
   // In controller
   $product = Product::find($id);
   if ($product->user_id !== auth()->id()) {
       abort(403);  // User doesn't own this product
   }
   ```

Every resource is scoped to the authenticated user.

## Database Relationships

### User (1:1, 1:N)
```
User ──1:1──> BusinessProfile
User ──1:N──> Category
User ──1:N──> Product
User ──1:N──> Transaction
```

### Product (1:N)
```
Product ──1:N──> TransactionItem
```

### Transaction (1:N)
```
Transaction ──1:N──> TransactionItem
```

### Category (1:N)
```
Category ──1:N──> Product
```

All cascading deletes on User deletion.

## Data Isolation

User A cannot access User B's data:

```php
// Products
$products = Product::where('user_id', auth()->id())->get();

// Transactions
$transactions = Transaction::where('user_id', auth()->id())->get();

// Reports
$revenue = Transaction::where('user_id', auth()->id())->sum('total_amount');
```

Every query includes `user_id` filter.

## File Organization

```
app/
├── Http/
│   ├── Controllers/          Request handlers
│   │   ├── Auth/             Login/Register
│   │   ├── Admin/            Admin panel
│   │   └── *.php             Feature controllers
│   └── Middleware/           Request interceptors
│
├── Models/                   Database models
│   ├── User.php
│   ├── Product.php
│   ├── Transaction.php
│   └── ...
│
└── Policies/                 Authorization rules
```

## Controller Naming

RESTful convention:

| Action | Method | Route | Controller |
|--------|--------|-------|----------|
| Show list | GET | /products | index() |
| Show form | GET | /products/create | create() |
| Save | POST | /products | store() |
| Show one | GET | /products/{id} | show() |
| Edit form | GET | /products/{id}/edit | edit() |
| Update | PUT | /products/{id} | update() |
| Delete | DELETE | /products/{id} | destroy() |

Example:
```php
class ProductController extends Controller {
    public function index() { }      // GET /products
    public function create() { }     // GET /products/create
    public function store() { }      // POST /products
    public function show($id) { }    // GET /products/{id}
    public function edit($id) { }    // GET /products/{id}/edit
    public function update($id) { }  // PUT /products/{id}
    public function destroy($id) { } // DELETE /products/{id}
}
```

## View Rendering

Blade templating in `resources/views/`:

```
resources/views/
├── auth/
│   ├── login.blade.php
│   └── register.blade.php
├── dashboard/
│   └── index.blade.php
├── products/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── transactions/
│   ├── index.blade.php
│   └── create.blade.php
└── layouts/
    └── app.blade.php
```

All views inherit from `layouts/app.blade.php` for consistent header/footer.

## Migrations & Schema

Migrations run in order:

```
2024_01_01_000000_create_users_table.php
2024_01_02_000000_create_business_profiles_table.php
2024_01_03_000000_create_categories_table.php
2024_01_04_000000_create_products_table.php
2024_01_05_000000_create_transactions_table.php
2024_01_06_000000_create_transaction_items_table.php
```

Rollback reverses in opposite order.

## Seeders

`database/seeders/DatabaseSeeder.php` creates:
- Test user (admin@example.com)
- Sample products & categories
- Dummy transactions for testing

Run: `php artisan db:seed`

## Error Handling

### Validation Errors
```php
$validated = $request->validate([
    'name' => 'required|string',
    'price' => 'required|numeric|min:0',
]);
// Returns 422 with error messages if invalid
```

### Authorization Errors
```php
abort(403);  // 403 Forbidden (user not owner)
abort(404);  // 404 Not Found (resource doesn't exist)
```

### Exceptions
Caught by `App\Exceptions\Handler.php` and rendered as HTTP responses.

## Performance Optimizations

1. **Eager Loading**
   ```php
   // Bad: N+1 queries
   $products = Product::all();
   foreach ($products as $p) echo $p->category->name;

   // Good: 2 queries
   $products = Product::with('category')->get();
   ```

2. **Selective Queries**
   ```php
   // Get only needed columns
   Product::select('id', 'name', 'price')->get();
   ```

3. **Indexing**
   All foreign keys indexed automatically in migrations.

4. **Pagination**
   ```php
   $products = Product::paginate(15);  // 15 per page
   ```

## Deployment Checklist

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure `.env` for production DB
- [ ] Run `php artisan migrate`
- [ ] Run `php artisan config:cache`
- [ ] Setup HTTPS/SSL
- [ ] Configure web server (Apache/Nginx)
- [ ] Setup automated backups
- [ ] Monitor error logs

---

See `DATABASE.md` for schema details, `API.md` for routes.