<?php
class Barang
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function ambilBarang()
    {
        $query = "SELECT * FROM tb_barang";
        $result = mysqli_query($this->conn, $query);
        $barang = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $barang[] = $row;
        }
        return $barang;
    }


    public function ambilBarangId($id)
    {
        $query = "SELECT * FROM tb_barang WHERE id_barang = $id";
        $result = mysqli_query($this->conn, $query);
        $barang = mysqli_fetch_assoc($result);
        return $barang;
    }
    public function tambahBarang($data)
    {

        $nama_barang = $data['nama_barang'];
        $harga_barang = $data['harga_barang'];
        $query = "INSERT INTO tb_barang (nama_barang, harga_barang) VALUES ('$nama_barang', '$harga_barang')";
        $result = mysqli_query($this->conn, $query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function updateBarang($id, $data)
    {
        $nama_barang = $data['nama_barang'];
        $harga_barang = $data['harga_barang'];


        $query = "UPDATE tb_barang SET nama_barang = '$nama_barang', harga_barang = '$harga_barang' WHERE id_barang = $id";
        $result = mysqli_query($this->conn, $query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function hapusBarang($id)
    {
        $query = "DELETE FROM tb_barang WHERE id_barang = $id";
        $result = mysqli_query($this->conn, $query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
