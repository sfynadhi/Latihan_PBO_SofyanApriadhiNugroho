<?php
/**
 * Class Koneksi Database menggunakan PDO
 * Dibuat dengan konsep OOP (Static Method) agar efisien 
 * dan bisa dipanggil langsung tanpa instansiasi baru.
 */
class Koneksi {
    private static $host = "localhost";
    private static $username = "root";
    private static $password = ""; // Kosongkan jika menggunakan XAMPP bawaan
    private static $database = "db_latihan_pbo_trpl1a_sofyanapriadhinugroho";
    private static $conn = null;

    /**
     * Method static untuk mendapatkan koneksi PDO
     * @return PDO|null
     */
    public static function getKoneksi() {
        if (self::$conn === null) {
            try {
                // Mengatur DSN (Data Source Name) untuk MySQL
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$database . ";charset=utf8mb4";
                
                // Membuat instance PDO baru
                self::$conn = new PDO($dsn, self::$username, self::$password);
                
                // Mengatur error mode ke Exception untuk mempermudah debugging
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
            } catch (PDOException $e) {
                // Jika koneksi gagal, tampilkan pesan error
                die("Koneksi ke database gagal: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
?>