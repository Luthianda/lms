<?php

// jika pakai soft delete (delete yang tidak sepenuhnya menghapus) pakainya bukan DELETE, melainkan UPDATE
if(isset($_GET['delete'])){
    $id_role = $_GET['delete'];
    $queryDelete = mysqli_query($config, "DELETE FROM roles WHERE id='$id_role'");
    if($queryDelete){
        header("location:?page=role&hapus=berhasil");
    }else{
        header("location:?page=role&hapus=gagal");
    }
}

$id_role = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($config, "SELECT * FROM roles WHERE id= '$id_role'");
$rowEdit= mysqli_fetch_assoc($queryEdit);
// print_r($rowEdit);
// die;

if(isset($_POST['name'])){
    // mengecek ada tidak sebuah parameter bernama edit, kalo ada jalankan perintah edit/update
    // kalo tidak ada jalankan perintah data baru / insert
    $name = $_POST['name'];

    if(!isset($_GET['edit'])){
        $insert = mysqli_query($config, "INSERT INTO roles (name) VALUES ('$name')");
        header("location:?page=role&tambah=berhasil");
    }else{
        $update = mysqli_query($config, "UPDATE roles SET name='$name' WHERE id='$id_role'");
        header("location:?page=role&ubah=berhasil");
    }
}

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Role</h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="">Role *</label>
                        <input type="text" class="form-control" name="name" placeholder="Masukkan Role" required value="<?= isset($rowEdit['name'])? $rowEdit['name'] : '' ?>">
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