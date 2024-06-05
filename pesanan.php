<?php
class Pesanan
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function ambilPesanan()
    {
        $query = "SELECT * FROM tb_pesanan";
        $result = mysqli_query($this->conn, $query);
        $Pesanan = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $Pesanan[] = $row;
        }
        return $Pesanan;
    }




    public function ambilPesananId($userId)
    {
        $query = "SELECT * FROM tb_pesanan WHERE user_id = $userId";
        $result = mysqli_query($this->conn, $query);
        // $Pesanan = mysqli_fetch_assoc($result);
        $Pesanan = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $Pesanan[] = $row;
        }
        return $Pesanan;
    }


    public function simpanPesanan($data)
    {


        $nama_pemesan = $data['nama_pemesan'];
        $phone = $data['phone'];
        $alamat = $data['alamat'];
        $barang_id = $data['barang_id'];
        $user_id = $data['user_id'];
        $total = $data['total'];

        $query = "INSERT INTO tb_pesanan (nama_pemesan, phone,alamat,barang_id,user_id,total)
         VALUES ('$nama_pemesan', '$phone', '$alamat', '$barang_id', '$user_id', '$total')";
        $result = mysqli_query($this->conn, $query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function updatePesanan($id, $data)
    {
        $nama_Pesanan = $data['nama_Pesanan'];
        $harga_Pesanan = $data['harga_Pesanan'];


        $query = "UPDATE tb_pesanan SET nama_Pesanan = '$nama_Pesanan', harga_Pesanan = '$harga_Pesanan' WHERE id_Pesanan = $id";
        $result = mysqli_query($this->conn, $query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function hapusPesanan($id)
    {
        $query = "DELETE FROM tb_pesanan WHERE id_Pesanan = $id";
        $result = mysqli_query($this->conn, $query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
