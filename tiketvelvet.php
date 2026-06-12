<?php

class TiketVelvet extends Tiket
{
    protected $bantalSelimutPack;
    protected $layananButler;

    public function __construct(
        $idTiket,
        $namaFilm,
        $jadwalTayang,
        $jumlahKursi,
        $hargaDasarTiket,
        $bantalSelimutPack,
        $layananButler
    ) {
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

    public function hitungTotalHarga()
    {
        $biayaTambahan = 50000;

        return ($this->hargaDasarTiket + $biayaTambahan) * $this->jumlahKursi;
    }

    public function tampilkanInfoFasilitas()
    {
        return "Studio Velvet | Bantal & Selimut: {$this->bantalSelimutPack} | Butler: {$this->layananButler}";
    }

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