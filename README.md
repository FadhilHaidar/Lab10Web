# Laporan Praktikum 10: PHP OOP

Project ini merupakan hasil refactor dari aplikasi mini CRUD pada Praktikum 9 (Modular PHP) menjadi arsitektur OOP (Object-Oriented Programming) sesuai instruksi Praktikum 10.

Fokus utama refactor:

- Memindahkan logic procedural ke dalam class

- Membuat class reusable untuk Form dan Database

- Menjadikan index.php sebagai Front Controller

- Mempertahankan struktur modular (config/, views/, assets/, dll)

- Meningkatkan UI/UX agar tampil lebih bersih dan profesional

## 1. Struktur Folder (Final – Praktikum 10)

<img width="308" height="648" alt="image" src="https://github.com/user-attachments/assets/12a4df55-cb19-4c0a-9cc1-101b6b5d3cf6" />

## 2. Perubahan Utama dari Praktikum 9 → Praktikum 10

Di Praktikum 9, aplikasi dibangun dengan pendekatan:

- Struktur Modular

- Routing berdasarkan $_GET['page']

- Fungsi procedural (belum terorganisir secara OOP)

Pada Praktikum 10, project diubah menjadi:

- OOP-based

- Memiliki class Database sebagai wrapper

- Memiliki class Form untuk membantu rendering form

- Views lebih rapi & clean

- Login/logout & CRUD memanfaatkan class, bukan fungsi procedural

## 3. Class Database (database.php)

Class ini menggantikan seluruh logika database procedural:

✔ Fitur:

- Auto-koneksi via __construct

- Query universal (query())

- Insert / Update / Delete

- Prepared statements

- Fetch single / fetch all

Cuplikan Kode:

    class Database {
        private $mysqli;
    
        public function __construct($host,$user,$pass,$db) {
            $this->mysqli = new mysqli($host,$user,$pass,$db);
        }
    
        public function query($sql) {
            return $this->mysqli->query($sql);
        }
    
        public function fetchAll($sql) {
            $res = $this->query($sql);
            return $res->fetch_all(MYSQLI_ASSOC);
        }
    
        public function insert($table, $data) {
            $cols = implode(',', array_keys($data));
            $vals = implode("','", array_values($data));
            return $this->query("INSERT INTO $table ($cols) VALUES('$vals')");
        }
    
        public function update($table,$data,$where) {
            $sets = [];
            foreach($data as $k=>$v) $sets[] = "$k='$v'";
            $set = implode(',', $sets);
            return $this->query("UPDATE $table SET $set WHERE $where");
        }
    
        public function delete($table,$where) {
            return $this->query("DELETE FROM $table WHERE $where");
        }
    }

## 4. Class Form (form.php)

Class ini menggantikan form procedural di Praktikum 9.

✔ Fitur:

- Reusable component

- Menambah input dengan method

- Auto-render dengan styling Bootstrap

- Mempercepat pembuatan form add/edit

Cuplikan:

    class Form {
        private $action;
        private $method;
    
        public function __construct($action,$method='POST') {
            $this->action = $action;
            $this->method = $method;
        }
    
        public function open($extra='') {
            return "<form action='{$this->action}' method='{$this->method}' {$extra}>";
        }
    
        public function close() {
            return "</form>";
        }
    }

## 5. index.php sebagai Front Controller

Pada Praktikum 9, setiap file langsung dipanggil oleh URL.
Praktikum 10 mengubahnya menjadi satu pintu utama:

    index.php?page=user/list
    index.php?page=auth/login

Tugas Front Controller:

- Load config

- Load class (Database, Form, helpers)

- Routing berdasar parameter page

- Load header + view + footer

## 6. Refactor CRUD (List, Add, Edit, Delete)

Dari procedural:

    mysqli_query($koneksi,"INSERT INTO data_barang ...");

Menjadi OOP:

    $app->db->insert('data_barang', $data);

✔ Semua CRUD sudah:

- Memakai class Database

- Memakai class Form

- Menggunakan layout header/footer

- Menggunakan UI modern (Bootstrap 5)

## 7. Refactor Login/Logout

Login sebelumnya memanggil koneksi langsung.
Kini login memakai:

    $rows = $app->db->fetch("SELECT * FROM users WHERE username = '$username'");

Jika benar → set session → redirect.

Logout hanya menghapus session dan redirect ke login.

## 8. Peningkatan UI/UX

Praktikum 10 juga menyempurnakan tampilan:

- Navbar fixed

- Card clean (Apple style)

- Layout full Bootstrap 5

- Tabel modern (rounded + soft shadow)

- Alert pill

- Spacing konsisten

- Font Poppins

- Warna mint-fresh (putih + biru pastel)

Cuplikan tampilan (placeholder):

## 9. Screenshot Hasil Running (Placeholder)

- Dashboard List Data Barang

<img width="956" height="503" alt="image" src="https://github.com/user-attachments/assets/1f840ea7-e011-4c73-bfcf-d1bc22f99604" />

- Add Item

<img width="955" height="808" alt="image" src="https://github.com/user-attachments/assets/6d8c293a-3cea-4a17-b565-443614b22234" />

<img width="956" height="621" alt="image" src="https://github.com/user-attachments/assets/64069084-aa54-47e5-b4eb-7b251bb19643" />

## 10. Kesimpulan

Refactoring dari Praktikum 9 → Praktikum 10:

| Praktikum 9 (Modular)   | Praktikum 10 (OOP)       |

| ----------------------- | ------------------------ |

| Procedural              | Berbasis OOP             |

| File dipanggil langsung | Front Controller         |

| Tidak ada class         | Database + Form class    |

| Routing sederhana       | Routing modular rapi     |

| UI biasa                | UI premium (Bootstrap 5) |

| Fungsi CRUD manual      | CRUD via method class    |

Dengan refactor ini:

- Code lebih bersih

- Perubahan lebih mudah dilakukan

- Arsitektur lebih maintainable

- Tampilannya jauh lebih profesional
