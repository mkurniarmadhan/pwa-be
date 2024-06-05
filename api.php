<?php
require_once 'config.php';
require_once 'barang.php';
require_once 'pesanan.php';
require_once 'auth.php';
// Create an instance of the Employee class
$dataBarang = new Barang($conn);
$pesanan = new Pesanan($conn);
$auth = new Auth($conn);
// Get the request method
$method = $_SERVER['REQUEST_METHOD'];
// Get the requested endpoint
$endpoint = $_SERVER['PATH_INFO'];
// Set the response content type
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
// Process the request


switch ($method) {
    case 'GET':
        if ($endpoint === '/barang') {
            // Get all barang
            $barang = $dataBarang->ambilBarang();
            echo json_encode($barang);
        } elseif (preg_match('/^\/barang\/(\d+)$/', $endpoint, $matches)) {
            // Get employee by ID
            $employeeId = $matches[1];
            $employee = $dataBarang->ambilBarangId($employeeId);
            echo json_encode($employee);
        }

        if ($endpoint === '/pesanan') {
            // Get all barang
            $pesanan = $pesanan->ambilPesanan();
            echo json_encode($pesanan);
        } elseif (preg_match('/^\/pesanan\/(\d+)$/', $endpoint, $matches)) {
            // Get employee by ID
            $userId = $matches[1];
            $pesanan = $pesanan->ambilPesananId($userId);
            echo json_encode($pesanan);
        }
        break;

    case 'POST':

        if ($endpoint === '/token') {
            $data = json_decode(file_get_contents('php://input'), true);
            $result = $auth->setToken($data);

            echo json_encode(['success' => $result]);
        }
        if ($endpoint === '/barang') {
            $data = $_POST;
            $result = $dataBarang->tambahBarang($data);
            echo json_encode(['success' => $result]);
        }

        if ($endpoint === '/pesanan') {
            $data = $_POST;
            $result = $pesanan->simpanPesanan($data);
            echo json_encode(['success' => $data]);
        }
        if ($endpoint === '/daftar') {
            $data = $_POST;
            $result = $auth->daftar($data);
            echo json_encode(['success' => $result]);
        }
        if ($endpoint === '/login') {
            $data = $_POST;
            $result = $auth->login($data);
            echo json_encode(['success' => $result]);
        }



        break;
    case 'PUT':
        if (preg_match('/^\/barang\/(\d+)$/', $endpoint, $matches)) {
            // Update employee by ID
            $employeeId = $matches[1];
            $data = json_decode(file_get_contents('php://input'), true);
            $result = $dataBarang->updateBarang($employeeId, $data);
            echo json_encode(['success' => $result]);
        }
        break;
    case 'DELETE':
        if (preg_match('/^\/barang\/(\d+)$/', $endpoint, $matches)) {
            // Delete employee by ID
            $employeeId = $matches[1];
            $result = $dataBarang->hapusBarang($employeeId);
            echo json_encode(['success' => $result]);
        }
        break;
}
