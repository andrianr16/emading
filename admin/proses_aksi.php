<?php
include('config_query.php');
$db = new database();
session_start();
$id_users = $_SESSION['id_users'];
$aksi = $_GET['aksi'];

if ($aksi == "add") {
    // Cek file sudah dipilih atau belum

    // echo "<pre>";
    // print_r($_FILES);
    // echo "</pre>";
    // die;

    if ($_FILES["header"]["name"] != '') {
        $tmp = explode('.', $_FILES["header"]["name"]);
        $ext = end($tmp); //Mengambil extension
        $filename = $tmp[0]; //Mengabil nilai nama file tanpa extension
        $allowed_ext = array("png", "jpg", "jpeg"); //Extension file yang diizinkan

        if (in_array($ext, $allowed_ext)) { //Cek validasi extension
            if ($_FILES["header"]["size"] <= 5120000) { //Cek ukuran gambar max 5mb
                $name = $filename . '_' . rand() . '.' . $ext; //Rename nama file gambar
                $path = "../files/" . $name; //Lokasi upload file
                $uploaded = move_uploaded_file($_FILES["header"]["tmp_name"], $path);

                if ($uploaded) {
                    $insertData = $db->tambah_data($name, $_POST["judul_artikel"], $_POST["isi_artikel"], $_POST["status_publish"], $id_users); //Query insert data
                    if ($insertData) {
                        echo "
                        <script>
                        alert('Data berhasil ditambahkan!');
                        document.location.href = 'index.php';
                        </script>";
                    } else {
                        echo "
                        <script>
                        alert('Upps!! Data gagal ditambahkan!');
                        document.location.href = 'index.php';
                        </script>";
                    }
                } else {
                    echo "
                        <script>
                        alert('Upps!! Upload file gagal!');
                        document.location.href = 'tambah_data.php';
                        </script>";
                }
            } else {
                echo "
                    <script>
                    alert('Ukuran gambar lebih dari 5M!');
                    document.location.href = 'tambah_data.php';
                    </script>";
            }
        } else {
            echo "
                <script>
                alert('File yang diupload bukan extensi yang diizinkan!');
                document.location.href = 'tambah_data.php';
                </script>";
        }
    } else {
        echo "
        <script>
        alert('Silahkan pilih file gambar');
        document.location.href = 'tambah_data.php';
        </script>";
    }
} elseif ($aksi == "edit") {
    // Disini operasi edit data
} elseif ($aksi == "delete") {
    // Disini operasi delete data
} else {
    echo "
    <script>
    alert('Anda tidak mendapatkan akses untuk operasi ini!');
    document.location.href = 'index.php';
    </script>";
}
