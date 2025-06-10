<?php

// jika pakai soft delete (delete yang tidak sepenuhnya menghapus) pakainya bukan DELETE, melainkan UPDATE
if(isset($_GET['delete'])){
    $id_major = $_GET['delete'];

    $queryModulsDetails = mysqli_query($config, "SELECT file FROM moduls_details WHERE id_modul = '$id'");
    $rowModulsDetails = mysqli_fetch_assoc($queryModulsDetails);
    unlink("uploads/". $rowModulsDetails['file']);

    $queryDelete = mysqli_query($config, "DELETE FROM moduls_details WHERE id_modul='$id_major'");
    $queryDelete = mysqli_query($config, "DELETE FROM moduls WHERE id='$id_major'");
    if($queryDelete){
        header("location:?page=modul&hapus=berhasil");
    }else{
        header("location:?page=modul&hapus=gagal");
    }
}

$id_major = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($config, "SELECT * FROM majors WHERE id= '$id_major'");
$rowEdit= mysqli_fetch_assoc($queryEdit);

if(isset($_POST['save'])){
    // mengecek ada tidak sebuah parameter bernama edit, kalo ada jalankan perintah edit/update
    // kalo tidak ada jalankan perintah data baru / insert
    $id_instructor = $_POST['id_instructor'];
    $id_major = $_POST['id_major'];
    $name = $_POST['name'];

    $insert = mysqli_query($config, "INSERT INTO moduls (id_instructor, id_major, name) VALUES ('$id_instructor', '$id_major', '$name')");

    if($insert){
        $id_modul = mysqli_insert_id($config);
        // $_FILES
        foreach($_FILES['file']['name'] as $index => $file){
            
            if($_FILES['file']['error'][$index] == 0){
                $name = basename($_FILES['file']['name'][$index]);
                $fileName = uniqid(). "-" . $name;
                $path = "uploads/";
                $targetPath = $path . $fileName;

                if(move_uploaded_file($_FILES['file']['tmp_name'][$index], $targetPath)){
                    $InsertModulDetail = mysqli_query($config, "INSERT INTO moduls_details (id_modul, file) VALUES ('$id_modul','$fileName')");
                }
            }
        }
        header("location:?page=modul&tambah=berhasil");
    }

    // if(!isset($_GET['edit'])){
        
    //     header("location:?page=major&tambah=berhasil");
    // }else{
    //     $update = mysqli_query($config, "UPDATE majors SET name='$name' WHERE id='$id_major'");
    //     header("location:?page=major&ubah=berhasil");
    // }
}

$id_instructor = isset($_SESSION['ID_USER']) ? $_SESSION['ID_USER'] : '';
$queryInstMajor = mysqli_query($config, "SELECT majors.name, instructor_majors. * FROM instructor_majors LEFT JOIN majors ON majors.id = instructor_majors.id_major WHERE instructor_majors.id_instructor = '$id_instructor'");
$rowInstMajors = mysqli_fetch_all($queryInstMajor, MYSQLI_ASSOC);

$id_modul = isset($_GET['detail']) ? $_GET['detail'] : '';
$queryModul = mysqli_query($config, "SELECT majors.name AS major_name, instructors.name AS instructor_name, moduls. * FROM moduls LEFT JOIN majors ON majors.id = moduls.id_major LEFT JOIN instructors ON instructors.id = moduls.id_instructor WHERE moduls.id = '$id_modul'");
$rowModul = mysqli_fetch_assoc($queryModul);

// query ke table detail modul
$queryDetailModul = mysqli_query($config, "SELECT * FROM moduls_details WHERE id_modul = '$id_modul'");
$rowDetailModuls = mysqli_fetch_all($queryDetailModul, MYSQLI_ASSOC);

// if(isset($_GET['download'])){
//     $file = $_GET['download'];
//     $filePath = "uploads/" . $file;
//     if(file_exists($filePath)){
//         header("Content-Description: File Transfer");
//         header("Content-Type: application/octet-stream");
//         header("Content-Disposition: attachment; filename=". basename($filePath). "");
//         header("Expires: 0");
//         header("Cache-Control: -must-revalidate");
//         header("Pragma: public");
//         header("Content-Length:" . filesize($filePath) . "");
//         readfile($filePath);
//         exit;
//     }
// }

if (isset($_GET['download'])) {
    $file = basename($_GET['download']); // Mencegah directory traversal
    $filePath = "uploads/" . $file;

    if (file_exists($filePath)) {
        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . basename($filePath));
        header("Expires: 0");
        header("Cache-Control: must-revalidate");
        header("Pragma: public");
        header("Content-Length: " . filesize($filePath));
        
        ob_clean(); // Membersihkan output buffer
        // flush(); // Mengosongkan buffer sistem
        readfile($filePath);
        exit;
    } else {
        echo "File tidak ditemukan.";
    }
}

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($_GET['detail']) ? 'Detail' : 'Add' ?> Modul</h5>

                <?php if(isset($_GET['detail'])): ?>
                    <table class="table table-stripped">
                        <tr>
                            <th>Nama Modul</th>
                            <th>:</th>
                            <td><?= $rowModul['name'] ?></td>
                            <th>Jurusan</th>
                            <th>:</th>
                            <td><?= $rowModul['major_name'] ?></td>
                        </tr>
                        <tr>
                            <th>Instruktur</th>
                            <th>:</th>
                            <td><?= $rowModul['instructor_name'] ?></td>
                        </tr>
                    </table>
                    <br>
                    <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($rowDetailModuls as $index => $rowDetailModul): ?>
                                    <tr>
                                        <!-- jika pakai sama dengan (=) tidak perlu menulis echo lagi -->
                                        <td><?= $index += 1 ?></td>
                                        <td>
                                            <a target="_blank" href="?page=tambah-modul&download=<?= urlencode($rowDetailModul['file']) ?>">
                                                <?= $rowDetailModul['file'] ?> <i class="bi bi-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="">Nama Instruktur *</label>
                                    <input readonly value="<?= $_SESSION['NAME'] ?>" type="text" class="form-control">
                                    <input type="hidden" name="id_instructor" value="<?= $_SESSION['ID_USER'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Modul *</label>
                                    <input type="text" name="name" class="form-control" value="" placeholder="Masukkan Nama Modul" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Jurusan *</label>
                                    <select name="id_major" id="" class="form-control" required>
                                        <option value="">--Pilih Salah Satu--</option>
                                            <?php foreach ($rowInstMajors as $rowInstMajor): ?>
                                                <option value="<?php echo $rowInstMajor['id_major']?>"><?php echo $rowInstMajor['name']?></option>    
                                            <?php endforeach ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div align="right" class="mb-3">
                            <button type="button" class="btn btn-primary addRow" id="addRow">Tambah Baris</button>
                        </div>
                        <table class="table" id="myTable" enctype="multipart/form-data">
                            <thead>
                                <tr>
                                    <th>File</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                        <div class="mb-3">
                            <input type="submit" class="btn btn-success" name="save" value="save">
                        </div>
                    </form>
                <?php endif ?>

            </div>
        </div>
    </div>
</div>

<script>
    // var, let, const
    // var: ketika nilainya tidak ada error, kalo let harus mempunyai nilainya
    // const: nilainya tidak boleh berubah
    // var sudah mulai ditinggalkan biasnya orang pakainya let
    // const nama= "nanda";
    // nama= "biila"
    // const button = document.getElementById('addRow');
    // const button = document.getElementsByClassName('addRow');
    // getElementById pakai Id, getElementsByClassName pakai nama classnya, document.querySelector ngambilnya pakai elemen
    // . untuk menggantikan class, # untuk menggantikan id
        const button = document.querySelector('.addRow');
        const tbody = document.querySelector('#myTable tbody');
        // button.textContent = "werwer";
        // button.style.color = "purple";

        button.addEventListener("click", function(){
            // alert('duarrr');
            const tr = document.createElement('tr');
            tr.innerHTML = `
            <td><input type='file' name='file[]'></td>
            <td>Delete<td>
            `;

            tbody.appendChild(tr);
        });
</script>