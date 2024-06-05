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

            $query = "SELECT token FROM tb_notifikasi";
            $result = mysqli_query($this->conn, $query);

            $tokens = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $tokens[] = $row['token'];
            }

            $this->sendNotif($tokens);


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

    private function sendNotif($tokens)
    {

        $serverKey = 'AAAAiyFEpYA:APA91bGf75IoZA9zfmixAziXF6tKl2jfspN3l_d6HZ4GMGSGR0Wb9tm09dUuxTiRJqV2J5hM-VnaUBCnBp3fblSHrdlxic_03XQESrrJlDAoRkKJ9DuvGnA9UYc29Y7n4ujtvwOVPHCO';


        $header = [
            'Authorization: Key=' . $serverKey,
            'Content-Type: Application/json'
        ];

        $msg = [
            'registration_ids' => $tokens, // Mengirim ke beberapa token
            'notification' => [
                'title' => 'ADA BARANG BARU',
                'body' => 'barang baru di tambahkan !',
                'icon' => 'your-icon-url'
            ]
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($msg));
        $result = curl_exec($ch);
        curl_close($ch);
    }
}
