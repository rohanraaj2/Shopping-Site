# Shopping-Site

A simple PHP-based clothing web store with product browsing, a session-backed shopping cart, checkout with tax + discounts, and basic order history.

## Features

- **Browse products by category**: Hoodies, Jackets, Pants, Pyjamas  
  Data source: [productdata.json](productdata.json)
- **Product detail page** (and optional comparison view) via query params  
  Implemented in [product.php](product.php)
- **Shopping cart** stored in PHP sessions:
  - Add/update/remove items via [`cartHandler.php`](cartHandler.php)
  - Cart UI + totals in [shoppingCart.php](shoppingCart.php)
  - Cart icon badge via [cartIcon.php](cartIcon.php)
- **Checkout flow** with:
  - Authentication check (AJAX) via [checkAuth.php](checkAuth.php)
  - Tax rate of $10\%$ on subtotal
  - Discounts based on order count using [`calculateDiscountPercent`](discount.php) and [`applyDiscount`](discount.php) from [discount.php](discount.php)
  - “Try Your Luck” $20\%$ discount via [luckyDiscount.php](luckyDiscount.php)
  - Order persistence in [orders.json](orders.json) and display in [orderHistory.php](orderHistory.php)
- **Dark mode toggle** persisted in `localStorage`  
  Implemented in [script.js](script.js) with styles in [mystyle.css](mystyle.css)

## Pages / Entry Points

- Home: [index.php](index.php)
- Category lists:
  - [hoodiesList.php](hoodiesList.php)
  - [jacketsList.php](jacketsList.php)
  - [pantsList.php](pantsList.php)
  - [pyjamasList.php](pyjamasList.php)
- Product detail / comparison: [product.php](product.php)
- Cart: [shoppingCart.php](shoppingCart.php)
- Checkout: [checkout.php](checkout.php)
- Order history: [orderHistory.php](orderHistory.php)
- About: [about.php](about.php)

## How totals are calculated

- Subtotal: $\sum_i price_i \cdot quantity_i$
- Tax: $tax = 0.10 \cdot subtotal$
- Discount (if applicable): $discount = \frac{discountPercent}{100}\cdot subtotal$
- Total (as used in checkout): $total = (subtotal - discount) + tax$

See:
- Cart totals in [shoppingCart.php](shoppingCart.php)
- Checkout totals + discount logic in [checkout.php](checkout.php) and [discount.php](discount.php)

## Local Setup (PHP built-in server)

### Prerequisites

- PHP (recommended: PHP 8.x)
- Write permissions for [orders.json](orders.json) (checkout appends orders)

### Run

From the repository root:

```sh
php -S localhost:8000
```

Then open:
- `http://localhost:8000/index.php`

## Project structure (high level)

- UI pages: `*.php` (e.g. [index.php](index.php), [shoppingCart.php](shoppingCart.php))
- Cart backend: [cartHandler.php](cartHandler.php)
- Product data: [productdata.json](productdata.json)
- Orders data: [orders.json](orders.json)
- Styling: [mystyle.css](mystyle.css)
- Frontend behavior: [script.js](script.js)
- Images: [images/](images/)

## Notes

- The cart is **session-based**, so items persist per browser session.
- The “Try Your Luck” discount sets session flags in [luckyDiscount.php](luckyDiscount.php) and is applied once on the next checkout in [checkout.php](checkout.php).
- The login/register pages exist (e.g. [login.php](login.php), [register.php](register.php)), and checkout requires a session `username`. Authentication enforcement is in [checkout.php](checkout.php) and [checkAuth.php](checkAuth.php).
