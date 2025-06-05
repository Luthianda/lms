<?php

// jika pakai soft delete (delete yang tidak sepenuhnya menghapus) pakainya bukan DELETE, melainkan UPDATE
if(isset($_GET['delete'])){
    $id_inst = $_GET['delete'];
    $queryDelete = mysqli_query($config, "DELETE FROM instructors WHERE id='$id_inst'");
    if($queryDelete){
        header("location:?page=instructor&hapus=berhasil");
    }else{
        header("location:?page=instructor&hapus=gagal");
    }
}

$id_inst = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($config, "SELECT * FROM instructors WHERE id= '$id_inst'");
$rowEdit= mysqli_fetch_assoc($queryEdit);

if(isset($_POST['name'])){
    // mengecek ada tidak sebuah parameter bernama edit, kalo ada jalankan perintah edit/update
    // kalo tidak ada jalankan perintah data baru / insert
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $education = $_POST['education'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = isset($_POST['password']) ? sha1($_POST['password']) : $rowEdit['password'];
    $address = $_POST['address'];

    if(!isset($_GET['edit'])){
        $insert = mysqli_query($config, "INSERT INTO instructors (name, gender, education, phone, email, password, address) VALUES ('$name','$gender','$education','$phone','$email','$password', '$address')");
        header("location:?page=instructor&tambah=berhasil");
    }else{
        $update = mysqli_query($config, "UPDATE instructors SET name='$name', gender='$gender', education='$education', phone='$phone', email='$email', password='$password', address='$address' WHERE id='$id_inst'");
        header("location:?page=instructor&ubah=berhasil");
    }
}

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Instuctor</h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="">Nama *</label>
                        <input type="text" class="form-control" name="name" placeholder="Masukkan Nama" required value="<?= isset($rowEdit['name'])? $rowEdit['name'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">Jenis Kelamin *</label><br>
                        <input type="radio" name="gender" required value= "0" <?= isset($rowEdit['gender'])? ($rowEdit['gender'] == 0) ? 'checked' : '' :'' ?>> Pria
                        <input type="radio" name="gender" required value= "1" <?= isset($rowEdit['gender'])? ($rowEdit['gender'] == 1) ? 'checked' : '' :'' ?>> Wanita
                        <!-- <select required name="gender" id="" class="form-control">
                            <option value="">--Pilih Gender--</option>
                            <option <?= isset($rowEdit['gender'])? ($rowEdit['gender'] == 0) ? 'selected' : '' :'' ?> value="0">Pria</option>
                            <option <?= isset($rowEdit['gender'])? ($rowEdit['gender'] == 1) ? 'selected' : '' :'' ?> value="1">Wanita</option>
                        </select> -->
                    </div>
                    <div class="mb-3">
                        <label for="">Pendidikan *</label>
                        <input type="text" class="form-control" name="education" placeholder="Masukkan Pendidikan Terakhir" required value="<?= isset($rowEdit['education'])? $rowEdit['education'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">No Telp *</label>
                        <input type="number" class="form-control" name="phone" placeholder="Masukkan Nomor Telp" required value="<?= isset($rowEdit['phone'])? $rowEdit['phone'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">Email *</label>
                        <input type="text" class="form-control" name="email" placeholder="Masukkan Email" required value="<?= isset($rowEdit['email'])? $rowEdit['email'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">Password *</label>
                        <input type="password" class="form-control" name="password" placeholder="Masukkan Password" <?php echo empty($_GET['edit']) ? 'required' : '' ?>>
                        <small>*jika ingin diubah, silahkan diisi</small>
                    </div>
                    <div class="mb-3">
                        <label for="">Alamat *</label>
                        <textarea name="address" id="summernote" cols="100" rows="5" ><?= isset($rowEdit['address'])? $rowEdit['address'] : '' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="save" value="save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>