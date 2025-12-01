<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once 'config.php';

$database = new Database();
$db = $database->getConnection();

$method = $_SERVER['REQUEST_METHOD'];
$response = [];

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    try {
        // Start transaction
        $db->beginTransaction();
        
        // Insert penjualan
        $query = "INSERT INTO penjualan 
                  (id_pelanggan, total_bayar, metode_pembayaran, kasir, catatan) 
                  VALUES (:id_pelanggan, :total, :metode, :kasir, :catatan)";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id_pelanggan', $data['id_pelanggan']);
        $stmt->bindParam(':total', $data['total_bayar']);
        $stmt->bindParam(':metode', $data['metode_pembayaran']);
        $stmt->bindParam(':kasir', $data['kasir']);
        $stmt->bindParam(':catatan', $data['catatan']);
        $stmt->execute();
        
        $id_penjualan = $db->lastInsertId();
        
        // Insert detail penjualan & update stok
        foreach ($data['items'] as $item) {
            // Insert detail
            $query = "INSERT INTO detail_penjualan 
                      (id_penjualan, id_produk, quantity, harga_satuan, subtotal, diskon) 
                      VALUES (:id_penjualan, :id_produk, :qty, :harga, :subtotal, :diskon)";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id_penjualan', $id_penjualan);
            $stmt->bindParam(':id_produk', $item['id_produk']);
            $stmt->bindParam(':qty', $item['quantity']);
            $stmt->bindParam(':harga', $item['harga_satuan']);
            $stmt->bindParam(':subtotal', $item['subtotal']);
            $stmt->bindParam(':diskon', $item['diskon']);
            $stmt->execute();
            
            // Update stok
            $query = "UPDATE produk SET stok = stok - :qty WHERE id_produk = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':qty', $item['quantity']);
            $stmt->bindParam(':id', $item['id_produk']);
            $stmt->execute();
        }
        
        // Update total transaksi pelanggan
        $query = "UPDATE pelanggan SET total_transaksi = total_transaksi + 1 
                  WHERE id_pelanggan = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $data['id_pelanggan']);
        $stmt->execute();
        
        // Commit transaction
        $db->commit();
        
        $response = [
            'success' => true,
            'message' => 'Transaksi berhasil',
            'id_penjualan' => $id_penjualan
        ];
        
    } catch (Exception $e) {
        $db->rollBack();
        $response = [
            'success' => false,
            'message' => 'Transaksi gagal: ' . $e->getMessage()
        ];
    }
    
} elseif ($method === 'GET') {
    // Get transaction history
    $limit = isset($_GET['limit']) ? $_GET['limit'] : 50;
    
    $query = "SELECT p.*, pl.nama_lengkap 
              FROM penjualan p
              LEFT JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
              ORDER BY p.tanggal_transaksi DESC
              LIMIT :limit";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    
    $response = [
        'success' => true,
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ];
}

echo json_encode($response);
?>