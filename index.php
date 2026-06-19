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
    
    // Daftar film unik untuk tampilan Beranda (Home)
    $filmUnik = [];
    
    foreach ($rows as $row) {
        $jenisStudio = $row['jenis_studio'];
        $namaFilm = $row['nama_film'];
        
        // Simpan daftar film unik untuk beranda katalog
        if (!isset($filmUnik[$namaFilm])) {
            $filmUnik[$namaFilm] = [
                'judul' => $namaFilm,
                'jadwal' => date('d M Y', strtotime($row['jadwal_tayang'])),
                'tipe' => $jenisStudio
            ];
        }
        
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
    <title>DAKOTA - Dashboard Cinema</title>
    <!-- Google Fonts & FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-dark: #0b0f17;
            --bg-navbar: #06090f;
            --bg-card: #121824;
            --accent-gold: #ffb800;
            --text-white: #ffffff;
            --text-grey: #7b869a;
            --border-color: #1e2736;
            
            --regular: #3b82f6;
            --imax: #f97316;
            --velvet: #a855f7;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-white);
            padding-bottom: 50px;
        }

        /* --- NAVIGATION BAR DENGAN MENU DI TENGAH --- */
        .navbar {
            background-color: var(--bg-navbar);
            border-bottom: 2px solid var(--border-color);
            padding: 15px 40px;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand-logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-white);
            letter-spacing: 1px;
            flex: 1; /* Mengisi ruang kiri agar mendorong menu ke tengah */
            display: flex;
            align-items: center;
        }

        .brand-logo span {
            color: var(--accent-gold);
        }

        /* Nav menu digeser tepat ke tengah */
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 25px;
            align-items: center;
            justify-content: center;
        }

        /* Spacer kanan agar menu tetap berada di tengah secara simetris */
        .navbar-spacer {
            flex: 1;
        }

        .menu-btn {
            background: transparent;
            border: none;
            color: var(--text-white);
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            padding: 8px 12px;
            transition: color 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .menu-btn:hover {
            color: var(--accent-gold);
        }

        /* Active Menu State */
        .menu-btn.active {
            color: var(--accent-gold);
            border-bottom: 2px solid var(--accent-gold);
        }

        /* --- CONTENT MAIN CONTAINER --- */
        .container {
            max-width: 1300px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            padding-left: 10px;
            border-left: 4px solid var(--accent-gold);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .content-section {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .content-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* --- HOME GRID LAYOUT --- */
        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 20px;
        }

        .movie-card-text {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 25px 15px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 210px;
            position: relative;
            box-shadow: 0 4px 6px rgba(0,0,0,0.15);
            transition: transform 0.2s, border-color 0.2s;
        }

        .movie-card-text:hover {
            transform: translateY(-5px);
            border-color: var(--accent-gold);
        }

        .movie-tag {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            color: #fff;
        }
        .tag-Regular { background-color: var(--regular); }
        .tag-IMAX { background-color: var(--imax); }
        .tag-Velvet { background-color: var(--velvet); }

        .movie-icon-box {
            font-size: 36px;
            color: var(--text-grey);
            margin-top: 15px;
            margin-bottom: 10px;
        }

        .movie-title-text {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-white);
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .movie-date-text {
            font-size: 12px;
            color: var(--text-grey);
        }

        /* --- DESIGN TABEL DATA MANIFEST --- */
        .table-container {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: rgba(6, 9, 15, 0.6);
            padding: 16px 20px;
            color: var(--text-grey);
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
        }

        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(255, 255, 255, 0.02); }

        .badge-facility {
            background: rgba(255,255,255,0.05);
            color: #cbd5e1;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .price-tag {
            font-weight: 700;
            color: #10b981;
        }

        .empty-state {
            padding: 40px;
            text-align: center;
            color: var(--text-grey);
        }
    </style>
</head>
<body>

    <!-- NAVBAR PREMIUM DAKOTA (MENU DI TENGAH) -->
    <header class="navbar">
        <div class="brand-logo">
            DAKO<span>TA</span>
        </div>
        
        <ul class="nav-menu">
            <li><button class="menu-btn active" data-target="home"><i class="fa-solid fa-house"></i> Home</button></li>
            <li><button class="menu-btn" data-target="Regular"><i class="fa-solid fa-ticket"></i> Movies</button></li>
            <li><button class="menu-btn" data-target="IMAX"><i class="fa-solid fa-wand-magic-sparkles"></i> IMAX</button></li>
            <li><button class="menu-btn" data-target="Velvet"><i class="fa-solid fa-couch"></i> Velvet</button></li>
        </ul>

        <!-- Elemen penyeimbang di kanan -->
        <div class="navbar-spacer"></div>
    </header>

    <div class="container">

        <!-- ================= BERANDA HOME SECTION ================= -->
        <div class="content-section active" id="section-home">
            <h2 class="section-title">Sedang Tayang</h2>
            <div class="movie-grid">
                <?php foreach($filmUnik as $film): ?>
                    <div class="movie-card-text">
                        <span class="movie-tag tag-<?= $film['tipe'] ?>"><?= $film['tipe'] ?></span>
                        <div class="movie-icon-box">
                            <i class="fa-solid fa-clapperboard"></i>
                        </div>
                        <div>
                            <div class="movie-title-text"><?= htmlspecialchars($film['judul']) ?></div>
                            <div class="movie-date-text"><?= $film['jadwal'] ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ================= SECTION TABLES (REGULAR, IMAX, VELVET) ================= -->
        <?php foreach ($daftarTiket as $kategori => $listTiket): ?>
            <div class="content-section" id="section-<?= $kategori ?>">
                <h2 class="section-title">Manifes Penjualan Studio <?= $kategori ?></h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 8%">ID</th>
                                <th style="width: 25%">Nama Film</th>
                                <th style="width: 20%">Jadwal Tayang</th>
                                <th style="width: 12%">Jumlah Kursi</th>
                                <th style="width: 23%">Spesifikasi Fasilitas Unik</th>
                                <th style="width: 12%">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($listTiket)): ?>
                                <tr>
                                    <td colspan="6" class="empty-state">
                                        Tidak ada pesanan tiket untuk Studio <?= $kategori ?>.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($listTiket as $tiket): ?>
                                    <tr>
                                        <td style="color: var(--text-grey); font-weight: bold;">#<?= htmlspecialchars($tiket->getIdTiket()) ?></td>
                                        <td><strong style="color: #fff;"><?= htmlspecialchars($tiket->getNamaFilm()) ?></strong></td>
                                        <td><?= htmlspecialchars(date('d M Y - H:i', strtotime($tiket->getJadwalTayang()))) ?> WIB</td>
                                        <td><?= htmlspecialchars($tiket->getJumlahKursi()) ?> Pax</td>
                                        <td>
                                            <span class="badge-facility">
                                                <?= htmlspecialchars($tiket->tampilkanInfoFasilitas()) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="price-tag">
                                                Rp <?= number_format($tiket->hitungTotalHarga(), 0, ',', '.') ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <!-- SCRIPT INTERAKSI NAVIGASI TAB -->
    <script>
        document.querySelectorAll('.menu-btn').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.menu-btn').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                const target = this.getAttribute('data-target');
                
                document.querySelectorAll('.content-section').forEach(section => {
                    section.classList.remove('active');
                });
                
                document.getElementById('section-' + target).classList.add('active');
            });
        });
    </script>
</body>
</html>