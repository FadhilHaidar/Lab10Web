<?php
// mobil.php - contoh latihan OOP sederhana (praktikum 10)
class Mobil {
    private $warna;
    private $merk;
    private $harga;

    public function __construct($merk = "BMW", $warna = "Biru", $harga = 10000000) {
        $this->merk = $merk;
        $this->warna = $warna;
        $this->harga = $harga;
    }

    public function gantiWarna($warnaBaru) {
        $this->warna = $warnaBaru;
    }

    public function tampilWarna() {
        echo "Warna mobil {$this->merk} : " . $this->warna;
    }
}

// contoh pemakaian
$a = new Mobil("Toyota", "Merah");
$a->tampilWarna();
echo "<br>";
$b = new Mobil("Honda", "Hijau");
$b->tampilWarna();
