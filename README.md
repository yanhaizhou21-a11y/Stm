# 🏫 School Management System

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.4-06B6D4?style=for-the-badge&logo=tailwind-css&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-3-003B57?style=for-the-badge&logo=sqlite&logoColor=white)

**Modern School Management System dengan Ocean Blue Theme**

[Demo](#) • [Documentation](INSTALLATION_GUIDE.md) • [Quick Start](QUICK_START.md)

</div>

---

## 📖 About

School Management System adalah aplikasi manajemen sekolah modern yang dibangun dengan Laravel 12, menampilkan desain Ocean Blue Theme yang elegan dan responsif. Sistem ini memudahkan pengelolaan data guru, siswa, kategori inventaris, dan inventaris sekolah.

### ✨ Key Features

- 🔐 **Authentication System** - Login, Register, Forgot Password dengan Ocean Blue Theme
- 📊 **Dashboard** - Statistik real-time dengan gradient cards
- 👨‍🏫 **Teacher Management** - CRUD lengkap untuk data guru
- 👨‍🎓 **Student Management** - Manajemen data siswa
- 📁 **Category Management** - Kategori untuk inventaris
- 📦 **Inventory Management** - Manajemen aset sekolah dengan relasi
- 🔄 **Borrowing System** - Sistem peminjaman dengan validasi ID
- ↩️ **Return System** - Pengembalian barang dengan update status otomatis
- 🎨 **Modern UI/UX** - Ocean Blue Theme dengan animasi smooth
- 📱 **Responsive Design** - Mobile-friendly interface
- ⚡ **Fast & Efficient** - Yajra Datatables dengan server-side processing

---

## 🎨 Screenshots

### Login Page
![Login](docs/screenshots/login.png)
*Ocean Blue themed login dengan floating animation*

### Dashboard
![Dashboard](docs/screenshots/dashboard.png)
*Dashboard dengan statistik cards gradient*

### Data Management
![Teachers](docs/screenshots/teachers.png)
*Teacher management dengan modal CRUD*

---

## 🚀 Quick Start

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- SQLite

### Installation

1. **Clone repository**
```bash
git clone https://github.com/yourusername/school-management-system.git
cd school-management-system
```

2. **Install dependencies**
```bash
composer install
composer require yajra/laravel-datatables-oracle
npm install
npm install alpinejs
```

3. **Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Create database**
```bash
touch database/database.sqlite
```

5. **Run migrations & seeders**
```bash
php artisan migrate
php artisan db:seed
```

6. **Build assets**
```bash
npm run build
```

7. **Start server**
```bash
php artisan serve
```

8. **Login**
- URL: http://localhost:8000
- Email: `admin@school.com`
- Password: `password`

---

## 📚 Documentation

- [Installation Guide](INSTALLATION_GUIDE.md) - Panduan instalasi lengkap
- [Quick Start Guide](QUICK_START.md) - Panduan cepat memulai
- [API Documentation](#) - Coming soon

---

## 🎯 Features Detail

### 1. Authentication
- ✅ Login dengan Ocean Blue Theme
- ✅ Register dengan animated design
- ✅ Forgot Password functionality
- ✅ Session management
- ✅ Reusable components (Button, Input, Label, etc.)

### 2. Dashboard
- ✅ Statistics cards dengan gradient
- ✅ Total Teachers, Students, Inventories, Categories
- ✅ Quick access links
- ✅ Welcome message

### 3. Teacher Management
- ✅ Create, Read, Update, Delete
- ✅ Modal forms
- ✅ Yajra Datatables server-side
- ✅ Search & filter
- ✅ Status badge
- ✅ Action buttons (Edit: Green, Delete: Red)

**Fields:**
- NIP (unique)
- Nama Lengkap
- Jabatan
- No HP
- Email (unique)
- Alamat
- Status Aktif

### 4. Student Management
- ✅ Full CRUD operations
- ✅ Modal forms
- ✅ Datatables with pagination
- ✅ Filter & search

**Fields:**
- NISN (unique)
- Nama Lengkap
- Kelas
- Jurusan
- Angkatan
- Alamat
- No HP
- Status Aktif

### 5. Category Management
- ✅ CRUD categories
- ✅ Quick add/edit
- ✅ Used for inventory categorization

**Fields:**
- Nama Kategori
- Deskripsi
- Status Aktif

### 6. Inventory Management
- ✅ CRUD with category relation
- ✅ Status badges (Baik/Rusak/Diperbaiki)
- ✅ Location tracking
- ✅ Category dropdown

**Fields:**
- Kode Barang (unique)
- Nama Barang
- Kategori (foreign key)
- Deskripsi
- Status
- Lokasi Barang
- Status Aktif

### 7. Peminjaman (Borrowing)
- ✅ Borrowing records for Students and Teachers
- ✅ NISN/NIP Validation with AJAX
- ✅ Item Code Validation with AJAX
- ✅ Automatic status tracking
- ✅ Double borrowing prevention

**Fields:**
- Peminjam (Siswa/Guru)
- Barang
- Tanggal Pinjam
- Tanggal Kembali (Rencana)
- Keterangan
- Status (Dipinjam/Dikembalikan)

### 8. Pengembalian (Returning)
- ✅ Streamlined return process via Modal
- ✅ Automatic Inventory Status update (Baik/Rusak)
- ✅ Overdue calculation
- ✅ Return condition tracking

**Fields:**
- Tanggal Dikembalikan
- Status Barang (Baik/Rusak/Hilang)
- Catatan

---

## 🎨 Design System

### Color Palette

```css
/* Ocean Blue Theme */
--ocean-600: #0077B6  /* Primary */
--ocean-500: #0096C7  /* Medium */
--ocean-400: #00B4D8  /* Cyan Blue */
--ocean-300: #48CAE4  /* Light Cyan */
--ocean-200: #90E0EF  /* Very Light */
--ocean-50:  #CAF0F8  /* Extra Light */

/* Action Colors */
--green-500: #10B981  /* Edit Button */
--red-500:   #EF4444  /* Delete Button */
--yellow-500: #F59E0B /* Warning */
```

### Typography

- **Headings**: Poppins (Bold, Semibold)
- **Body**: Inter (Regular, Medium)

### Components

All views menggunakan reusable Blade components:
- `<x-button>` - Button dengan variants
- `<x-input>` - Styled input fields
- `<x-label>` - Form labels
- `<x-checkbox>` - Styled checkboxes
- `<x-input-error>` - Error messages
- `<x-alert>` - Alert notifications

---

## 🛠️ Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Tailwind CSS 3.4, Alpine.js
- **Database**: SQLite
- **Datatables**: Yajra Datatables
- **Icons**: Heroicons (SVG)
- **Authentication**: Laravel Breeze

---

## 📁 Project Structure

```
school-management-system/
├── app/
│   ├── Http/Controllers/       # Controllers
│   └── Models/                 # Eloquent Models
├── database/
│   ├── factories/              # Model Factories
│   ├── migrations/             # Database Migrations
│   └── seeders/                # Database Seeders
├── resources/
│   ├── css/                    # Styles
│   ├── js/                     # JavaScript
│   └── views/                  # Blade Templates
│       ├── components/         # Reusable Components
│       ├── layouts/            # Layout Templates
│       ├── auth/               # Authentication Views
│       └── ...                 # Feature Views
├── routes/
│   └── web.php                 # Web Routes
└── tailwind.config.js          # Tailwind Configuration
```

---

## 🔄 Development

### Run in development mode
```bash
npm run dev
php artisan serve
```

### Build for production
```bash
npm run build
```

### Clear cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Run tests
```bash
php artisan test
```

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📝 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

---

## 👤 Author

**Your Name**
- GitHub: [@yourusername](https://github.com/yourusername)
- Email: your.email@example.com

---

## 🙏 Acknowledgments

- Laravel Framework
- Tailwind CSS
- Yajra Datatables
- Heroicons
- All contributors

---

<div align="center">

**Made with ❤️ using Laravel & Tailwind CSS**

**Theme: Ocean Blue 🌊**

⭐ Star this repo if you like it!

</div>