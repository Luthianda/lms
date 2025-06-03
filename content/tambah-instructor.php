<?php

// jika pakai soft delete (delete yang tidak sepenuhnya menghapus) pakainya bukan DELETE, melainkan UPDATE
if(isset($_GET['delete'])){
    $id_user = $_GET['delete'];
    $queryDelete = mysqli_query($config, "UPDATE users SET deleted_at = 1 WHERE id = '$id_user'");
    if($queryDelete){
        header("location:?page=user&hapus=berhasil");
    }else{
        header("location:?page=user&hapus=gagal");
    }
}

if(isset($_POST['name'])){
    // mengecek ada tidak sebuah parameter bernama edit, kalo ada jalankan perintah edit/update
    // kalo tidak ada jalankan perintah data baru / insert
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
    $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';

    if(!isset($_GET['edit'])){
        $insert = mysqli_query($config, "INSERT INTO users (name, email, password) VALUES ('$name','$email','$password')");
        header("location:?page=user&tambah=berhasil");
    }else{
        print_r($_POST);
        die;
        $update = mysqli_query($config, "UPDATE users SET name='$name', email='$email', password='$password' WHERE id='$id_user'");
        header("location:?page=user&ubah=berhasil");
    }
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add User</h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="">Nama *</label>
                        <input type="text" class="form-control" name="name" placeholder="Masukkan Nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="">Email *</label>
                        <input type="text" class="form-control" name="email" placeholder="Masukkan Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="">Password *</label>
                        <input type="text" class="form-control" name="password" placeholder="Masukkan Password" required>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="save" value="save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>