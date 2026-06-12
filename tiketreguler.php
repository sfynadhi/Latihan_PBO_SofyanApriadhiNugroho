<?php

/**
 * Class TiketRegular
 * Turunan dari class abstrak Tiket
 * Merepresentasikan studio Regular
 */
class TiketRegular extends Tiket
{
    // Properti tambahan khusus studio Regular
    protected $tipeAudio;
    protected $lokasiBaris;

    /**
     * Constructor TiketRegular
     */
    public function __construct(
        $idTiket,
        $namaFilm,
        $jadwalTayang,
        $jumlahKursi,
        $hargaDasarTiket,
        $tipeAudio,
        $lokasiBaris
    ) {
        // Memanggil constructor parent
        parent::__construct(
            $idTiket,
            $namaFilm,
            $jadwalTayang,
            $jumlahKursi,
            $hargaDasarTiket
        );

        $this->tipeAudio = $tipeAudio;
        $this->lokasiBaris = $lokasiBaris;
    }

    /**
     * Method overriding
     * Menghitung total harga tiket Regular
     * Rumus:
     * jumlah_kursi × harga_dasar
     */
    public function hitungTotalHarga()
    {
        return $this->jumlahKursi * $this->hargaDasarTiket;
    }

    /**
     * Menampilkan informasi fasilitas studio Regular
     */
    public function tampilkanInfoFasilitas()
    {
        return "Audio: {$this->tipeAudio}, Baris Kursi: {$this->lokasiBaris}";
    }

    // Getter
    public function getTipeAudio()
    {
        return $this->tipeAudio;
    }

    public function getLokasiBaris()
    {
        return $this->lokasiBaris;
    }
}
?>