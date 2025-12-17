# User Drag Order

Drag & Drop ordering for WordPress users using the native `wp_users.user_order` column.

This plugin allows administrators to visually reorder users directly from the **Users** admin table using drag & drop.  
The order is saved in the real `user_order` column of `wp_users`, making it reliable for frontend queries.

---

## ✨ Features

- Drag & drop users directly in **wp-admin → Users**
- Persists order in `wp_users.user_order`
- AJAX saving (no page reload)
- Compatible with `get_users()`
- Lightweight and dependency-free (uses jQuery UI bundled with WordPress)

---

## 🧱 Folder Structure

```text
user-drag-order/
├── user-drag-order.php
├── includes/
│   ├── class-user-drag-order.php
│   └── user-order-query.php
└── assets/
    └── js/
        └── admin-drag-order.js
```

---

## 🖱 How to Use

1. Go to: wp-admin → Users

2. Make sure users are ordered by `user_order`:

3. Drag and drop rows to reorder users.

4. Changes are saved automatically.

---

## 🔍 Frontend Usage Example

You can now safely order users by `user_order`, even when using `meta_query`:

```php
$members = get_users([
    'orderby' => 'user_order',
    'order'   => 'ASC',
]);
```
