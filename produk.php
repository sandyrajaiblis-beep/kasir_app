<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'config.php';

$database = new Database();
$db = $database->getConnection();

$method = $_SERVER['REQUEST_METHOD'];
$response = [];

switch($method) {
    case 'GET':
        // Get all products atau search
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
        
        $query = "SELECT * FROM produk WHERE aktif = 1";
        
        if (!empty($search)) {
            $query .= " AND (nama_produk LIKE :search OR kategori LIKE :search)";
        }
        if (!empty($kategori)) {
            $query .= " AND kategori = :kategori";
        }
        
        $query .= " ORDER BY nama_produk ASC";
        
        $stmt = $db->prepare($query);
        
        if (!empty($search)) {
            $search_param = "%{$search}%";
            $stmt->bindParam(':search', $search_param);
        }
        if (!empty($kategori)) {
            $stmt->bindParam(':kategori', $kategori);
        }
        
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $response = [
            'success' => true,
            'data' => $products,
            'count' => count($products)
        ];
        break;

    case 'POST':
        // Create new product
        $data = json_decode(file_get_contents("php://input"), true);
        
        $query = "INSERT INTO produk 
                  (nama_produk, kategori, harga_jual, harga_beli, stok, stok_minimum, satuan, deskripsi) 
                  VALUES (:nama, :kategori, :harga_jual, :harga_beli, :stok, :stok_min, :satuan, :deskripsi)";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nama', $data['nama_produk']);
        $stmt->bindParam(':kategori', $data['kategori']);
        $stmt->bindParam(':harga_jual', $data['harga_jual']);
        $stmt->bindParam(':harga_beli', $data['harga_beli']);
        $stmt->bindParam(':stok', $data['stok']);
        $stmt->bindParam(':stok_min', $data['stok_minimum']);
        $stmt->bindParam(':satuan', $data['satuan']);
        $stmt->bindParam(':deskripsi', $data['deskripsi']);
        
        if ($stmt->execute()) {
            $response = [
                'success' => true,
                'message' => 'Produk berhasil ditambahkan',
                'id' => $db->lastInsertId()
            ];
        } else {
            $response = ['success' => false, 'message' => 'Gagal menambahkan produk'];
        }
        break;

    case 'PUT':
        // Update product
        $data = json_decode(file_get_contents("php://input"), true);
        
        $query = "UPDATE produk SET 
                  nama_produk = :nama,
                  kategori = :kategori,
                  harga_jual = :harga_jual,
                  harga_beli = :harga_beli,
                  stok = :stok,
                  stok_minimum = :stok_min,
                  satuan = :satuan,
                  deskripsi = :deskripsi
                  WHERE id_produk = :id";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $data['id_produk']);
        $stmt->bindParam(':nama', $data['nama_produk']);
        $stmt->bindParam(':kategori', $data['kategori']);
        $stmt->bindParam(':harga_jual', $data['harga_jual']);
        $stmt->bindParam(':harga_beli', $data['harga_beli']);
        $stmt->bindParam(':stok', $data['stok']);
        $stmt->bindParam(':stok_min', $data['stok_minimum']);
        $stmt->bindParam(':satuan', $data['satuan']);
        $stmt->bindParam(':deskripsi', $data['deskripsi']);
        
        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'Produk berhasil diupdate'];
        } else {
            $response = ['success' => false, 'message' => 'Gagal mengupdate produk'];
        }
        break;
}

echo json_encode($response);