<?php
/**
 * Class Abstrak Tiket
 * * Sesuai dengan spesifikasi pada dokumen UAS/Latihan PBO,
 * properti dienkapsulasi dengan akses modifier protected dan
 * wajib memetakan kolom dari tabel database (tabel_tiket).
 */
abstract class Tiket {
    // Properti/Atribut Terenkapsulasi (Protected)
    protected $idTiket;
    protected $namaFilm;
    protected $jadwalTayang; // Representasi dari kolom DATETIME database
    protected $jumlahKursi;
    protected $hargaDasarTiket;

    /**
     * Constructor Kelas Tiket
     * Memetakan nilai properti langsung dari row data database
     */
    public function __construct($idTiket, $namaFilm, $jadwalTayang, $jumlahKursi, $hargaDasarTiket) {
        $this->idTiket = $idTiket;
        $this->namaFilm = $namaFilm;
        $this->jadwalTayang = $jadwalTayang;
        $this->jumlahKursi = (int)$jumlahKursi;
        $this->hargaDasarTiket = (float)$hargaDasarTiket;
    }

    /**
     * Metode Abstrak untuk menghitung total harga tiket.
     * Wajib diimplementasikan oleh kelas anak (Regular, IMAX, Velvet).
     * * @return float
     */
    abstract public function hitungTotalHarga();

    /**
     * Metode Abstrak untuk menampilkan informasi fasilitas studio.
     * Wajib diimplementasikan oleh kelas anak.
     * * @return void
     */
    abstract public function tampilkanInfoFasilitas();

    // ==========================================
    // GETTER AND SETTER (Akses Data Terenkapsulasi)
    // ==========================================

    public function getIdTiket() {
        return $this->idTiket;
    }

    public function setIdTiket($idTiket) {
        $this->idTiket = $idTiket;
    }

    public function getNamaFilm() {
        return $this->namaFilm;
    }

    public function setNamaFilm($namaFilm) {
        $this->namaFilm = $namaFilm;
    }

    public function getJadwalTayang() {
        return $this->jadwalTayang;
    }

    public function setJadwalTayang($jadwalTayang) {
        $this->jadwalTayang = $jadwalTayang;
    }

    public function getJumlahKursi() {
        return $this->jumlahKursi;
    }

    public function setJumlahKursi($jumlahKursi) {
        $this->jumlahKursi = (int)$jumlahKursi;
    }

    public function getHargaDasarTiket() {
        return $this->hargaDasarTiket;
    }

    public function setHargaDasarTiket($hargaDasarTiket) {
        $this->hargaDasarTiket = (float)$hargaDasarTiket;
    }
}
?>