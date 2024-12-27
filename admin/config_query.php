<?php
class database
{
    var $host = "localhost";
    var $username = "root";
    var $password = "";
    var $database = "db_emading";
    var $koneksi = "";

    function __construct()
    {
        $this->koneksi = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        if (mysqli_connect_errno()) {
            echo "Koneksi database gagal : " . mysqli_connect_error();
        }
    }

    public function get_data_user($username)
    {
        $data = mysqli_query($this->koneksi, "SELECT * FROM tb_users WHERE username = '$username' ");
        return $data;
    }

    // Get data tb_artikel
    public function tampil_data()
    {
        $data = mysqli_query($this->koneksi, "SELECT id_artikel,header,judul_artikel,isi_artikel,status_publish,tba.created_at,tba.updated_at,name,tba.id_users FROM tb_artikel tba join tb_users tbu on tba.id_users = tbu.id_users");
        if ($data) {
            if (mysqli_num_rows($data) > 0) {
                while ($row = mysqli_fetch_array($data)) {
                    $hasil[] = $row;
                }
            } else {
                $hasil = '0';
            }
        }
        return $hasil;
    }

    public function tambah_data($header, $judul_artikel, $isi_artikel, $status_publish, $id_users)
    {
        $datetime = date("Y-m-d H:i:s");
        $insert = mysqli_query($this->koneksi, "INSERT INTO tb_artikel (header,judul_artikel,isi_artikel,status_publish,id_users,created_at) values('$header','$judul_artikel','$isi_artikel','$status_publish','$id_users','$datetime')");
        return $insert;
    }
}
