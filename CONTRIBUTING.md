# Contributing

Guidelines for development and contributions.

## Setup Development Environment

### Prerequisites
- PHP 8.2+
- MySQL 5.7+ / MariaDB
- Composer
- Node.js 18+
- Git

### First Time Setup

```bash
# Clone project
cd umkm-sales

# Install dependencies
composer install
npm install

# Copy environment
cp .env.example .env
php artisan key:generate

# Setup database
mysql -u root -p -e "CREATE DATABASE umkm_sales;"
bash scripts/setup-database.sh

# Run development server
php artisan serve

# In another terminal, build assets
npm run dev
```

Access at http://localhost:8000

Default login: `admin@example.com` / `password` (from seeders)

## Code Structure

### Adding a Feature

1. **Create Migration**
   ```bash
   php artisan make:migration create_xxx_table
   ```
   Store in `database/migrations/`

2. **Create Model**
   ```bash
   php artisan make:model Xxx
   ```
   Store in `app/Models/`
   Define relationships here.

3. **Create Controller**
   ```bash
   php artisan make:controller XxxController
   ```
   Store in `app/Http/Controllers/`
   Follow RESTful: index, create, store, edit, update, destroy.

4. **Add Routes**
   Edit `routes/web.php`:
   ```php
   Route::resource('xxx', XxxController::class);
   ```

5. **Create Views**
   Blade templates in `resources/views/xxx/`
   - `index.blade.php` (list)
   - `create.blade.php` (create form)
   - `edit.blade.php` (edit form)

6. **Test Locally**
   ```bash
   php artisan test
   ```

7. **Commit**
   ```bash
   git add .
   git commit -m "feature: add xxx feature"
   ```

## File Organization

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/              Login, register
│   │   ├── Admin/             Admin-only features
│   │   └── [Feature]Controller.php
│   └── Middleware/            Auth, admin checks
├── Models/                    Database models
└── Policies/                  Authorization rules (optional)

database/
├── migrations/                Schema changes
└── seeders/                   Test data

resources/views/
├── auth/                      Login, register pages
├── dashboard/                 Dashboard layout
└── [feature]/                 Feature views
    ├── index.blade.php        List
    ├── create.blade.php       Create form
    └── edit.blade.php         Edit form

routes/
└── web.php                    All web routes

public/
├── css/                       Compiled styles
└── js/                        Compiled scripts
```

## Controller Pattern

```php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // List all products for user
    public function index()
    {
        $products = auth()->user()
            ->products()
            ->with('category')
            ->paginate(15);
        
        return view('products.index', compact('products'));
    }

    // Show create form
    public function create()
    {
        $categories = auth()->user()->categories;
        return view('products.create', compact('categories'));
    }

    // Store new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        auth()->user()->products()->create($validated);

        return redirect('products')
            ->with('message', 'Product created successfully');
    }

    // Show edit form
    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        $categories = auth()->user()->categories;
        return view('products.edit', compact('product', 'categories'));
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $product->update($validated);

        return redirect('products')
            ->with('message', 'Product updated successfully');
    }

    // Delete product
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();

        return redirect('products')
            ->with('message', 'Product deleted successfully');
    }
}
```

## Model Pattern

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'price',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
```

## Database Migrations

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->decimal('price', 15, 2);
            $table->integer('stock')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
```

## Blade View Pattern

```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Products</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" required>
            @error('name') <span>{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Price</label>
            <input type="number" name="price" step="0.01" required>
            @error('price') <span>{{ $message }}</span> @enderror
        </div>

        <button type="submit">Save</button>
    </form>
</div>
@endsection
```

## Validation

Always validate at request boundary:

```php
$validated = $request->validate([
    'name' => 'required|string|max:255|unique:products',
    'email' => 'required|email|unique:users',
    'price' => 'required|numeric|min:0|max:999999.99',
    'category_id' => 'nullable|integer|exists:categories,id',
    'date' => 'required|date|after:today',
]);
```

Common rules:
- `required` — Field must exist
- `string` — Must be text
- `numeric` — Must be number
- `email` — Valid email format
- `unique:table` — Value not in database
- `exists:table,column` — Value exists in database
- `min:N` / `max:N` — Min/max length or value
- `date` — Valid date format
- `confirmed` — Matches `{field}_confirmation`

## Authorization

Check user ownership before updating/deleting:

```php
// In controller
public function update(Request $request, Product $product)
{
    // Check ownership
    if ($product->user_id !== auth()->id()) {
        abort(403);  // Forbidden
    }

    // Or use policy
    $this->authorize('update', $product);

    $product->update($request->validated());
    return redirect()->back()->with('message', 'Updated');
}
```

## Testing

Run tests:
```bash
php artisan test
php artisan test --filter=ProductTest
php artisan test --filter=store
```

Write tests in `tests/Feature/` or `tests/Unit/`

Example:
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class ProductTest extends TestCase
{
    public function test_user_can_create_product()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/products', [
                'name' => 'Test Product',
                'price' => 100,
            ]);

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }
}
```

## Git Workflow

### Branch Names
```
feature/add-xxx              New feature
fix/bug-description          Bug fix
docs/update-readme           Documentation
refactor/improve-xxx         Code cleanup
```

### Commit Messages
```
feature: add product filtering
fix: resolve transaction total calculation
docs: update API documentation
refactor: simplify product controller
```

Format: `type: description` (lowercase, short)

### Push & Merge

```bash
# Create branch
git checkout -b feature/new-feature

# Make changes, commit
git add .
git commit -m "feature: add new feature"

# Push
git push -u origin feature/new-feature

# Create PR/merge on GitHub
```

## Code Style

### PHP

```php
// Use meaningful variable names
$products = auth()->user()->products;  // Good
$p = auth()->user()->products;         // Bad

// Use early returns
if (!auth()->check()) {
    return redirect('login');
}

// Use constants for magic numbers
const ITEMS_PER_PAGE = 15;
$items = Model::paginate(ITEMS_PER_PAGE);

// Use short array syntax
$array = [1, 2, 3];      // Good
$array = array(1, 2, 3); // Bad
```

### Blade Templates

```blade
{{-- Use meaningful variable names --}}
@foreach ($products as $product)
    {{ $product->name }}
@endforeach

{{-- Use comments for clarity --}}
{{-- Only admins can see this --}}
@admin
    <button>Delete</button>
@endadmin

{{-- Avoid complex logic in views --}}
{{ $user->isAdmin ? 'Admin' : 'User' }}  {{-- OK --}}
{{ $user->role()->permissions()->count() > 5 ? ... }}  {{-- Move to controller --}}
```

## Performance Tips

1. **Eager Load Relationships**
   ```php
   // Bad: N+1 queries
   $products = Product::all();
   foreach ($products as $p) echo $p->category->name;

   // Good: 2 queries
   $products = Product::with('category')->get();
   ```

2. **Select Only Needed Columns**
   ```php
   // Get only what you need
   Product::select('id', 'name', 'price')->get();
   ```

3. **Use Pagination**
   ```php
   // Don't load all 10,000 items
   $items = Item::paginate(15);
   ```

4. **Cache Expensive Queries**
   ```php
   $data = cache()->remember('dashboard', 3600, function () {
       return Transaction::where('user_id', auth()->id())
           ->sum('total_amount');
   });
   ```

## Debugging

### Laravel Debug
```php
// Print and die
dd($variable);

// Print without dying
dump($variable);

// Log to file
\Log::info('Something happened', ['user_id' => 1]);
```

### Check Database
```bash
# Connect to MySQL
mysql -u root -p umkm_sales

# Show tables
SHOW TABLES;

# Query data
SELECT * FROM products WHERE user_id = 1;
```

### Test Routes
```bash
# List all routes
php artisan route:list

# Check specific route
php artisan route:list | grep products
```

## Documentation

Update docs when:
- Adding new route
- Changing database schema
- Adding new feature
- Fixing bug that affects API

Update files:
- `API.md` — New routes
- `DATABASE.md` — Schema changes
- `FEATURES.md` — Feature additions
- `ARCHITECTURE.md` — Design changes

---

See `README.md` for quick start, `ARCHITECTURE.md` for design patterns.