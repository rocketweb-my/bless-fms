# Vendor Management Implementation Summary

## Overview
A vendor management system has been created, similar to the Team module, allowing management of vendor users who can login and manage tickets.

## Files Created

### 1. Migration File
**Path:** `database/migrations/2025_10_01_224441_add_vendor_fields_to_users_table.php`

**Fields Added to `hesk_users` table:**
- `user_type` ENUM('staff', 'vendor') DEFAULT 'staff' - Differentiates between staff and vendor users
- `vendor_type` ENUM('admin', 'technical') NULL - Type of vendor (Admin or Technical)
- `company` VARCHAR(255) NULL - Company name for vendors

**Status:** Migration file created, NOT YET RUN

### 2. VendorController
**Path:** `app/Http/Controllers/VendorController.php`

**Methods:**
- `index()` - List all vendors with DataTables
- `store()` - Create new vendor with email credentials
- `profile($id)` - View/edit vendor profile
- `update($id)` - Update vendor details
- `updateStatus()` - Toggle vendor active/inactive status
- `destroy()` - Delete vendor

**Key Features:**
- Filters users by `user_type = 'vendor'`
- Uses legacy SHA1 password hashing (same as team)
- Sends email with auto-generated password
- Stores: Name, Email, Company, Phone Number, Vendor Type

### 3. Routes (TO BE ADDED)
Add to `routes/web.php`:

```php
// Vendor Management Routes
Route::prefix('vendor')->middleware(['auth'])->group(function () {
    Route::get('/', [VendorController::class, 'index'])->name('vendor.index');
    Route::post('/store', [VendorController::class, 'store'])->name('vendor.store');
    Route::get('/profile/{id}', [VendorController::class, 'profile'])->name('vendor.profile');
    Route::post('/update/{id}', [VendorController::class, 'update'])->name('vendor.update');
    Route::post('/update-status', [VendorController::class, 'updateStatus'])->name('vendor.updateStatus');
    Route::post('/delete', [VendorController::class, 'destroy'])->name('vendor.delete');
});
```

### 4. Views (TO BE CREATED)

#### vendor.blade.php
**Path:** `resources/views/pages/vendor.blade.php`

**Structure:**
- DataTable with columns: No, Name, Email, Company, Phone, Type, Status, Action
- Registration form with fields:
  - Name (required)
  - Email (required, unique)
  - Company (required)
  - Phone Number (required)
  - Vendor Type dropdown: Admin/Technical (required)
- Ajax handlers for status toggle and delete
- Similar to `team.blade.php` but simplified

#### vendor_profile.blade.php
**Path:** `resources/views/pages/vendor_profile.blade.php`

**Structure:**
- Edit form for vendor details
- Same fields as registration
- Password reset option
- Similar to team profile page

### 5. Sidebar Menu (TO BE ADDED)
Add to sidebar navigation (after PIC menu):

```blade
<li class="slide">
    <a class="side-menu__item" href="{{ route('vendor.index') }}">
        <i class="side-menu__icon fa fa-building"></i>
        <span class="side-menu__label">Vendor</span>
    </a>
</li>
```

## Database Changes

### users table will have:
```
user_type: 'staff' (existing users) or 'vendor' (new vendors)
vendor_type: 'admin' or 'technical' (only for vendors)
company: Company name (only for vendors)
```

### Differentiation Strategy:
- **Staff**: `user_type = 'staff'`, `vendor_type = NULL`
- **Vendor Admin**: `user_type = 'vendor'`, `vendor_type = 'admin'`
- **Vendor Technical**: `user_type = 'vendor'`, `vendor_type = 'technical'`

## Vendor Login & Permissions

Vendors will:
1. Login using same login form as staff (email as username)
2. Have limited permissions: `can_view_tickets,can_reply_tickets`
3. **NOT** have admin privileges (`isadmin = 0`)
4. Receive notifications for assigned tickets
5. Be able to reply to tickets but not create new ones

## Next Steps

1. **Review Migration** - Check `database/migrations/2025_10_01_224441_add_vendor_fields_to_users_table.php`
2. **Run Migration** - `php artisan migrate` (after approval)
3. **Create Views** - Create `vendor.blade.php` and `vendor_profile.blade.php`
4. **Add Routes** - Add vendor routes to `routes/web.php`
5. **Add Menu** - Add Vendor menu item to sidebar
6. **Update TeamController** - Add filter to exclude vendors from team list: `User::where('user_type', 'staff')`
7. **Test** - Create test vendor and verify login/permissions

## Notes

- Email as username for vendors (simpler than separate username field)
- Password auto-generated and emailed (same as team members)
- Uses existing `hesk_users` table (no separate vendor table)
- Vendors are distinguished by `user_type` and `vendor_type` columns
- Compatible with existing authentication system
