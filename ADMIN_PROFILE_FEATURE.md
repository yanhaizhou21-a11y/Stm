# Admin Profile Management Feature

## Overview
A modern, responsive admin profile management system built with Laravel and TailwindCSS, featuring the Ocean Blue color theme.

## Features

### 🎨 Design & Theme
- **Ocean Blue Color Palette**:
  - Primary: #0077B6
  - Medium: #0096C7
  - Cyan Blue: #00B4D8
  - Light Cyan: #48CAE4
  - Very Light: #90E0EF
  - Extra Light: #CAF0F8

### 📱 Responsive Design
- Fully responsive layout that works on desktop, tablet, and mobile
- Mobile-first approach with breakpoint-specific styling
- Touch-friendly buttons and interactive elements
- Optimized table layout for small screens

### 🔧 Functionality
- **CRUD Operations**: Create, Read, Update, Delete admin profiles
- **Form Validation**: Comprehensive validation with custom error messages
- **Search & Pagination**: Easy navigation through admin records
- **Action Buttons**: 
  - Edit (Green #10B981)
  - Delete (Red #EF4444)
  - View (Ocean Blue)

### 📊 Database Schema
```sql
admins:
- id (Primary Key)
- username (Unique)
- name
- email (Unique)
- active_at (Timestamp)
- created_at
- updated_at
```

## File Structure

### Models
- `app/Models/Admin.php` - Admin model with fillable fields and casts

### Controllers
- `app/Http/Controllers/AdminController.php` - Resource controller with CRUD operations

### Requests
- `app/Http/Requests/AdminRequest.php` - Form request validation

### Views
- `resources/views/admins/index.blade.php` - Admin listing page
- `resources/views/admins/create.blade.php` - Create admin form
- `resources/views/admins/show.blade.php` - Admin profile view
- `resources/views/admins/edit.blade.php` - Edit admin form

### Database
- `database/migrations/2025_10_22_072303_create_admins_table.php` - Migration
- `database/seeders/AdminSeeder.php` - Sample data seeder

## Routes
```php
Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
Route::get('/admins/{admin}', [AdminController::class, 'show'])->name('admins.show');
Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');
Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admins.update');
Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');
```

## Usage

### Accessing Admin Management
1. Navigate to `/admins` in your browser
2. Use the sidebar navigation to access "Admins" section

### Creating a New Admin
1. Click "Add New Admin" button
2. Fill in the required fields (username, name, email)
3. Click "Create Admin"

### Viewing Admin Profile
1. Click "View" button next to any admin
2. See detailed profile information
3. Use quick action buttons for editing or deleting

### Editing Admin Profile
1. Click "Edit" button next to any admin
2. Modify the information
3. Click "Update Profile"

### Deleting Admin
1. Click "Delete" button
2. Confirm the deletion in the popup

## Responsive Features

### Mobile Optimizations
- Stacked layout for action buttons on small screens
- Horizontal scrolling for tables
- Touch-friendly button sizes
- Optimized typography for readability

### Desktop Features
- Side-by-side layout for profile information
- Hover effects on interactive elements
- Grid layout for optimal space usage

## Customization

### Colors
The Ocean Blue theme is defined in `tailwind.config.js`:
```javascript
colors: {
    ocean: {
        50: '#CAF0F8',
        100: '#ADE8F4',
        200: '#90E0EF',
        300: '#48CAE4',
        400: '#00B4D8',
        500: '#0096C7',
        600: '#0077B6',
        700: '#023E8A',
        800: '#03045E',
    },
}
```

### Styling
All views use TailwindCSS classes with the Ocean Blue theme. The design is consistent with the existing application layout.

## Testing
The feature includes sample data seeded via `AdminSeeder` with 4 sample admin accounts for testing purposes.

## Security
- Form validation prevents invalid data submission
- CSRF protection on all forms
- Authorization checks in place
- SQL injection protection through Eloquent ORM
