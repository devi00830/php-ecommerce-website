# E-Commerce Project: 

## Project Architecture

This is a **PHP/PDO e-commerce platform** (XAMPP-based) with user authentication, product catalog, shopping cart, and admin management.

### Core Components

- **Frontend**: `index.php` (product listing) + `pages/*.php` (user pages)
- **Admin**: `admin/*.php` (product management, dashboard)
- **Database**: MySQL via PDO in `includes/db.php` (no ORM)
- **Styling**: Responsive CSS Grid in `css/styles.css`

### Data Flow

```
User Login (pages/login.php) 
  → Session stored ($_SESSION['user_id'])
  → Redirects to index.php
  → Fetch products from DB
  → Add to Cart (POST) → stored in cart table
  → Checkout flow via pages/cart.php
```

## Key Architectural Patterns

### Session-Based Authentication
- **User pages**: Check `isset($_SESSION['user_id'])` before access; redirect to `pages/login.php` if not set
- **Admin pages**: Check `isset($_SESSION['admin_id'])` similarly
- Logout: Call `session_unset()` then `session_destroy()` (see `index.php` lines 5-8)

### Database Access (PDO)
- **Connection**: `includes/db.php` — always `include` this before DB queries
- **Pattern**: Use prepared statements with `$conn->prepare()` + `execute([])` to prevent SQL injection
  ```php
  $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
  $stmt->execute([$user_id, $product_id]);
  ```
- **Result fetching**: `fetchAll(PDO::FETCH_ASSOC)` for arrays, `fetch()` for single row

### Security Practices
- **Output escaping**: Always use `htmlspecialchars()` on user/DB data in HTML context (see `index.php` line 66)
- **Type casting**: Cast numeric IDs: `(int)$product['id']` before HTML (line 84)
- **File upload safety**: Validate file exists before including paths; use `file_exists()` (line 74)

### Product Display & Images
- **Grid layout**: CSS Grid (`grid-template-columns: repeat(auto-fill, minmax(250px, 1fr))`)
- **Image handling**: 
  - Check if image file exists: `file_exists(__DIR__ . '/images/' . $filename)`
  - Use fallback placeholder if missing: `images/product.png`
  - Trim whitespace: `$filename = trim($product['image'] ?? '')`
  - Use `object-fit: contain` in CSS to preserve aspect ratio
- **Card structure**: Flex layout with `align-items: stretch` to keep buttons at bottom (see `css/styles.css`)

## Common Developer Workflows

### Adding a Product (Admin)
1. Navigate: `admin/add_product.php` → Form with name, price, description, image upload
2. On submit: File moved to `images/` folder, product inserted into DB via `admin/add_product.php`
3. Appears on `index.php` after next page load

### Editing/Deleting Products
- Edit: `admin/manage_products.php` table has Edit link → form pre-populated (implement if missing)
- Delete: Same page, DELETE SQL in handler

### Adding Items to Cart
- User clicks "Add to Cart" button on `index.php` (POST to `pages/cart.php`)
- Script checks if product already in cart; if yes, increment quantity; if no, insert
- Redirect back to cart page to display items

## Project-Specific Conventions

### File Organization
- **Business logic** (DB queries) at top of page after session checks
- **HTML/templates** rendered below PHP logic
- **CSS**: All in single `css/styles.css` (no CSS-in-JS or external frameworks)

### Naming
- Tables: lowercase plural (`products`, `cart`, `users`)
- POST parameters: snake_case (`add_to_cart`, `product_id`, `user_id`)
- Session keys: snake_case (`user_id`, `admin_id`)

### Error Handling
- **Connection failures**: Caught in `try/catch` with `PDOException`
- **Missing files**: Use conditional `file_exists()` before including
- **User errors**: Redirect with `header()` and `exit()` (do not use exit with echo before header)

## Common Pitfalls to Avoid

1. **Forgetting `include 'includes/db.php'`** — DB queries will fail silently
2. **Not checking session before DB access** — Unset `$_SESSION` keys cause undefined variable warnings
3. **Unescaped output** — Always wrap DB data in `htmlspecialchars()` in HTML
4. **Image paths**: Use relative paths from web root (`images/file.png`), not absolute filesystem paths in HTML src
5. **Prepared statements**: Never concatenate variables into SQL strings

## Key Files to Reference

- **Database init**: `test_db.php` (simple connectivity check)
- **Cart logic**: `pages/cart.php` (full CRUD for cart items)
- **Admin product add**: `admin/add_product.php` (file upload pattern)
- **Product display**: `index.php` (image fallback, grid layout, htmlspecialchars examples)
