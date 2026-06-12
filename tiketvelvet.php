<?php

/**
 * Class TiketVelvet
 * Turunan dari class abstrak Tiket
 * Merepresentasikan studio Velvet
 */
class TiketVelvet extends Tiket
{
    // Properti tambahan khusus studio Velvet
    protected $bantalSelimutPack;
    protected $layananButler;

    /**
     * Constructor TiketVelvet
     */
    public function __construct(
        $idTiket,
        $namaFilm,
        $jadwalTayang,
        $jumlahKursi,
        $hargaDasarTiket,
        $bantalSelimutPack,
        $layananButler
    ) {
        // Memanggil constructor parent
        parent::__construct(
            $idTiket,
            $namaFilm,
            $jadwalTayang,
            $jumlahKursi,
            $hargaDasarTiket
        );

        $this->bantalSelimutPack = $bantalSelimutPack;
        $this->layananButler = $layananButler;
    }

    /**
     * Method overriding
     * Menghitung total harga tiket Velvet
     * Rumus:
     * (jumlah_kursi × harga_dasar) × 1.5
     */
    public function hitungTotalHarga()
    {
        return ($this->jumlahKursi * $this->hargaDasarTiket) * 1.50;
    }

    /**
     * Menampilkan informasi fasilitas studio Velvet
     */
    public function tampilkanInfoFasilitas()
    {
        return "Paket Bantal & Selimut: {$this->bantalSelimutPack}, Layanan Butler: {$this->layananButler}";
    }

    // Getter
    public function getBantalSelimutPack()
    {
        return $this->bantalSelimutPack;
    }

    public function getLayananButler()
    {
        return $this->layananButler;
    }
}
?>