<?php

class TiketRegular extends Tiket
{
    protected $tipeAudio;
    protected $lokasiBaris;

    public function __construct(
        $idTiket,
        $namaFilm,
        $jadwalTayang,
        $jumlahKursi,
        $hargaDasarTiket,
        $tipeAudio,
        $lokasiBaris
    ) {
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

    public function hitungTotalHarga()
    {
        return $this->hargaDasarTiket * $this->jumlahKursi;
    }

    public function tampilkanInfoFasilitas()
    {
        return "Studio Regular | Audio: {$this->tipeAudio} | Baris: {$this->lokasiBaris}";
    }

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