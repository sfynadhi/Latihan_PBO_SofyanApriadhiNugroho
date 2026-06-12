<?php

class TiketIMAX extends Tiket
{
    protected $kacamata3dId;
    protected $efekGerakFitur;

    public function __construct(
        $idTiket,
        $namaFilm,
        $jadwalTayang,
        $jumlahKursi,
        $hargaDasarTiket,
        $kacamata3dId,
        $efekGerakFitur
    ) {
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

    public function hitungTotalHarga()
    {
        $biayaTambahan = 25000;

        return ($this->hargaDasarTiket + $biayaTambahan) * $this->jumlahKursi;
    }

    public function tampilkanInfoFasilitas()
    {
        return "Studio IMAX | Kacamata 3D: {$this->kacamata3dId} | Efek Gerak: {$this->efekGerakFitur}";
    }

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