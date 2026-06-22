# Nipzz!! Store - CodeIgniter 3 E-Commerce

## Instalasi (XAMPP)

1. Buat database `laptopku_db` di phpMyAdmin
2. Buka `http://localhost/eccomerce-main/install?run=1`
3. Login:
   - **Super Admin:** superadmin@laptopku.id / password123
   - **Admin:** admin@laptopku.id / password123
   - **User:** user@laptopku.id / password123

## Fitur

- MVC CodeIgniter 3, AdminLTE 3, RBAC (Super Admin / Admin / User)
- Auth: login, register, lupa password, remember me, bcrypt, CSRF
- Toko: katalog, promo, keranjang, checkout, pesanan
- Admin CRUD: produk, pesanan, pelanggan, user, role, menu, settings, log
- DataTables + export Excel/PDF di panel admin
- Migration & seeder database lengkap

## Struktur

```
application/   Controllers, Models, Views, Migrations
assets/        CSS & JS terpisah (bukan inline di view)
uploads/       Upload gambar produk
system/        CodeIgniter core
```
