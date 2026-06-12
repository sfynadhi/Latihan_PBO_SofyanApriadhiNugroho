<?php
// Pastikan semua file kelas dan koneksi di-include
require_once 'koneksi.php';
require_once 'tiket.php';
require_once 'tiketreguler.php';
require_once 'tiketmax.php';
require_once 'tiketvelvet.php';

try {
    // 1. Ambil koneksi database
    $db = Koneksi::getKoneksi();
    
    // 2. Query untuk mengambil seluruh data tiket
    $query = "SELECT * FROM tabel_tiket ORDER BY jenis_studio, id_tiket ASC";
    $stmt = $db->query($query);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // 3. Kelompokkan objek tiket menggunakan konsep polimorfisme
    $daftarTiket = [
        'Regular' => [],
        'IMAX' => [],
        'Velvet' => []
    ];
    
    foreach ($rows as $row) {
        $jenisStudio = $row['jenis_studio'];
        
        if ($jenisStudio === 'Regular') {
            $daftarTiket['Regular'][] = new TiketRegular(
                $row['id_tiket'], $row['nama_film'], $row['jadwal_tayang'], 
                $row['jumlah_kursi'], $row['harga_dasar_tiket'], 
                $row['tipe_audio'], $row['lokasi_baris']
            );
        } elseif ($jenisStudio === 'IMAX') {
            $daftarTiket['IMAX'][] = new TiketIMAX(
                $row['id_tiket'], $row['nama_film'], $row['jadwal_tayang'], 
                $row['jumlah_kursi'], $row['harga_dasar_tiket'], 
                $row['kacamata_3d_id'], $row['efek_gerak_fitur']
            );
        } elseif ($jenisStudio === 'Velvet') {
            $daftarTiket['Velvet'][] = new TiketVelvet(
                $row['id_tiket'], $row['nama_film'], $row['jadwal_tayang'], 
                $row['jumlah_kursi'], $row['harga_dasar_tiket'], 
                $row['bantal_selimut_pack'], $row['layanan_butler']
            );
        }
    }

} catch (Exception $e) {
    die("Terjadi kesalahan data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan Tiket Bioskop</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 40px;
        }
        .studio-section {
            background: #fff;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .studio-title {
            font-size: 24px;
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 3px solid;
        }
        /* Pewarnaan Kategori Studio */
        .title-Regular { color: #2980b9; border-color: #2980b9; }
        .title-IMAX { color: #e67e22; border-color: #e67e22; }
        .title-Velvet { color: #8e44ad; border-color: #8e44ad; }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: 600;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .badge-fasilitas {
            background-color: #eaeded;
            color: #2c3e50;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 13px;
            display: inline-block;
        }
        .harga-total {
            font-weight: bold;
            color: #27ae60;
        }
        .empty-row {
            text-align: center;
            color: #7f8c8d;
            font-style: italic;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Daftar Pesanan Tiket Bioskop (Dinamis)</h1>

    <?php foreach ($daftarTiket as $kategori => $listTiket): ?>
        <div class="studio-section">
            <h2 class="studio-title title-<?= $kategori ?>">Studio <?= $kategori ?></h2>
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th style="width: 25%">Nama Film</th>
                        <th style="width: 18%">Jadwal Tayang</th>
                        <th style="width: 10%">Jumlah Kursi</th>
                        <th style="width: 27%">Spesifikasi Fasilitas Unik</th>
                        <th style="width: 15%">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($listTiket)): ?>
                        <tr>
                            <td colspan="6" class="empty-row">Tidak ada pesanan tiket untuk Studio <?= $kategori ?>.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($listTiket as $tiket): ?>
                            <tr>
                                <td><?= htmlspecialchars($tiket->getIdTiket()) ?></td>
                                <td><strong><?= htmlspecialchars($tiket->getNamaFilm()) ?></strong></td>
                                <td><?= htmlspecialchars(date('d M Y - H:i', strtotime($tiket->getJadwalTayang()))) ?> WIB</td>
                                <td><?= htmlspecialchars($tiket->getJumlahKursi()) ?></td>
                                <td>
                                    <span class="badge-fasilitas">
                                        <?= htmlspecialchars($tiket->tampilkanInfoFasilitas()) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="harga-total">
                                        Rp <?= number_format($tiket->hitungTotalHarga(), 2, ',', '.') ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>