# Lab10Web — Refactor Praktikum 9 → OOP (Praktikum 10)

## Ringkasan
Repo ini adalah hasil refactor mini-app Praktikum 9 (modular + procedural) menjadi arsitektur OOP sesuai instruksi Praktikum 10. Fokus:
- Struktur folder modular tetap (config/, views/, assets/, gambar/).
- Dibuat class library:
  - `config/database.php` → `Database` class (koneksi & wrapper CRUD).
  - `lib/Form.php` → `Form` class (membuat form input di views).
- Index tetap front controller (`index.php`) — sekarang membuat instance `Database` dan menyediakannya untuk views lewat `$app->db`.
- Login/logout dan CRUD data_barang direfactor untuk memanfaatkan `Database` dan `Form`.

Referensi: Praktikum 9 (index & views original) dan Praktikum 10 (contoh class Form/Database). :contentReference[oaicite:6]{index=6} :contentReference[oaicite:7]{index=7}

---

## File penting
- `config/config.php` — konfigurasi DB
- `config/database.php` — class Database (OOP)
- `lib/Form.php` — class Form (library)
- `index.php` — front controller (membuat `$app->db`)
- `views/` — refactor views (auth, user)
- `mobil.php` — contoh program OOP kecil (praktikum 10)
- `form_input.php` — contoh pemanggilan `Form` (lihat folder root)

---

## Langkah menjalankan (di mesin Anda)
1. Salin repo ke `htdocs` (XAMPP) atau `www` (lamp) — mis. `C:\xampp\htdocs\Lab10Web`.
2. Pastikan MySQL berjalan. Buat database `db_barang` dan tabel sesuai praktikum (struktur sama seperti tugas Praktikum 9).
3. Edit `config/config.php` jika username/password/db berbeda.
4. Akses di browser: `http://localhost/Lab10Web/index.php`  
   - Halaman default adalah `user/list` (sama seperti Praktikum 9).

---

## Perubahan teknis (ringkasan)
- Koneksi DB: dari procedural `mysqli_connect()` → `Database` class dengan prepared statements (lebih aman).
- Form: dari HTML manual di setiap view → sebagian dijalankan oleh `Form` class (`form->addField(...)`, `form->render()`).
- Front controller (`index.php`) tetap dipakai tetapi sekarang membuat instance `$db = new Database(); $app->db = $db;`.
- Views menggunakan `$app->db->fetchAll(...)`, `$app->db->insert(...)`, dll., bukan `db()` function.

---

## Screenshot
Saya tidak menyertakan screenshot karena saya tidak menjalankan server di sini. Silakan ambil screenshot berikut pada lingkungan Anda dan letakkan file gambar di `/screenshots`:
1. Tampilan `index.php?page=user/list` (list barang)
2. Halaman `index.php?page=auth/login`
3. Proses tambah barang (form add + hasil list setelah tambah)
4. Struktur folder di file explorer (tunjukkan `config/`, `lib/`, `views/`)

Setelah ambil screenshot, tambahkan link atau embed di README jika menyerahkan laporan. Contoh:
```markdown
![List Barang](screenshots/01_list.png)
![Login](screenshots/02_login.png)
