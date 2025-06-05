<?php

// jika pakai soft delete (delete yang tidak sepenuhnya menghapus) pakainya bukan DELETE, melainkan UPDATE
if(isset($_GET['delete'])){
    $id_major = $_GET['delete'];
    $queryDelete = mysqli_query($config, "DELETE FROM majors WHERE id='$id_major'");
    if($queryDelete){
        header("location:?page=major&hapus=berhasil");
    }else{
        header("location:?page=major&hapus=gagal");
    }
}

$id_major = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($config, "SELECT * FROM majors WHERE id= '$id_major'");
$rowEdit= mysqli_fetch_assoc($queryEdit);
// print_r($rowEdit);
// die;

if(isset($_POST['name'])){
    // mengecek ada tidak sebuah parameter bernama edit, kalo ada jalankan perintah edit/update
    // kalo tidak ada jalankan perintah data baru / insert
    $name = $_POST['name'];

    if(!isset($_GET['edit'])){
        $insert = mysqli_query($config, "INSERT INTO majors (name) VALUES ('$name')");
        header("location:?page=major&tambah=berhasil");
    }else{
        $update = mysqli_query($config, "UPDATE majors SET name='$name' WHERE id='$id_major'");
        header("location:?page=major&ubah=berhasil");
    }
}

$id_instructor = isset($_SESSION['ID_USER']) ? $_SESSION['ID_USER'] : '';
$queryInstMajor = mysqli_query($config, "SELECT majors.name, instructor_majors. * FROM instructor_majors LEFT JOIN majors ON majors.id = instructor_majors.id_major WHERE instructor_majors.id_instructor = '$id_instructor'");
$rowInstMajors = mysqli_fetch_all($queryInstMajor, MYSQLI_ASSOC);
// print_r($rowInstMajors);
// die;

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Modul</h5>

                <form action="" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="">Nama Instruktur *</label>
                                <input readonly value="<?= $_SESSION['NAME'] ?>" type="text" class="form-control">
                                <input type="hidden" name="id_instructor" value="<?= $_SESSION['ID_USER'] ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Jurusan *</label>
                                <select name="id_major" id="" class="form-control">
                                    <option value="">--Pilih Salah Satu--</option>
                                        <?php foreach ($rowInstMajors as $rowInstMajor): ?>
                                            <option value="<?php echo $rowInstMajor['id_major']?>"><?php echo $rowInstMajor['name']?></option>    
                                        <?php endforeach ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="save" value="save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>