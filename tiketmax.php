<?php

/**
 * Class TiketIMAX
 * Turunan dari class abstrak Tiket
 * Merepresentasikan studio IMAX
 */
class TiketIMAX extends Tiket
{
    // Properti tambahan khusus studio IMAX
    protected $kacamata3dId;
    protected $efekGerakFitur;

    /**
     * Constructor TiketIMAX
     */
    public function __construct(
        $idTiket,
        $namaFilm,
        $jadwalTayang,
        $jumlahKursi,
        $hargaDasarTiket,
        $kacamata3dId,
        $efekGerakFitur
    ) {
        // Memanggil constructor parent
        parent::__construct(
            $idTiket,
            $namaFilm,
            $jadwalTayang,
            $jumlahKursi,
            $hargaDasarTiket
        );

        $this->kacamata3dId = $kacamata3dId;
        $this->efekGerakFitur = $efekGerakFitur;
    }

    /**
     * Method overriding
     * Menghitung total harga tiket IMAX
     * Rumus:
     * (jumlah_kursi × harga_dasar) + 35.000
     */
    public function hitungTotalHarga()
    {
        return ($this->jumlahKursi * $this->hargaDasarTiket) + 35000;
    }

    /**
     * Menampilkan informasi fasilitas studio IMAX
     */
    public function tampilkanInfoFasilitas()
    {
        return "Kacamata 3D ID: {$this->kacamata3dId}, Efek Gerak: {$this->efekGerakFitur}";
    }

    // Getter
    public function getKacamata3dId()
    {
        return $this->kacamata3dId;
    }

    public function getEfekGerakFitur()
    {
        return $this->efekGerakFitur;
    }
}
?>