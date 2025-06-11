<?php

// jika pakai soft delete (delete yang tidak sepenuhnya menghapus) pakainya bukan DELETE, melainkan UPDATE
if(isset($_GET['delete'])){
    $id_menu = $_GET['delete'];
    $queryDelete = mysqli_query($config, "DELETE FROM menus WHERE id='$id_menu'");
    if($queryDelete){
        header("location:?page=menu&hapus=berhasil");
    }else{
        header("location:?page=menu&hapus=gagal");
    }
}

$id_menu = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($config, "SELECT * FROM menus WHERE id= '$id_menu'");
$rowEdit= mysqli_fetch_assoc($queryEdit);
// print_r($rowEdit);
// die;

if(isset($_POST['name'])){
    // mengecek ada tidak sebuah parameter bernama edit, kalo ada jalankan perintah edit/update
    // kalo tidak ada jalankan perintah data baru / insert
    $name = $_POST['name'];
    $parent_id = $_POST['parent_id'];
    $urutan = $_POST['urutan'];
    $url = $_POST['url'];
    $icon = $_POST['icon'];


    if(!isset($_GET['edit'])){
        $insert = mysqli_query($config, "INSERT INTO menus (name, parent_id, icon, url, urutan) VALUES ('$name','$parent_id','$icon','$url','$urutan')");
        header("location:?page=menu&tambah=berhasil");
    }else{
        $id = $_GET['edit'];
        $update = mysqli_query($config, "UPDATE menus SET name='$name', parent_id='$parent_id', icon='$icon', url='$url', urutan='$urutan' WHERE id='$id'");
        // print_r($update);
        // die;
        header("location:?page=menu&ubah=berhasil");
    }
}

$queryParentId = mysqli_query($config, "SELECT * FROM menus WHERE parent_id = 0 OR parent_id=''");
$rowParentId = mysqli_fetch_all($queryParentId, MYSQLI_ASSOC);

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Menu</h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="">Menu *</label>
                        <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Menu" required value="<?= isset($rowEdit['name'])? $rowEdit['name'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">Parent Id </label>
                            <select name="parent_id" id="" class="form-control">
                                <option value="">--Pilih Satu--</option>
                                <?php foreach ($rowParentId as $ParentId): ?>
                                    <option value="<?php echo $ParentId['id']?>"><?php echo $ParentId['name']?></option>    
                                <?php endforeach ?>
                            </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Ikon *</label>
                        <input type="text" class="form-control" name="icon" placeholder="Masukkan Ikon Menu" required value="<?= isset($rowEdit['icon'])? $rowEdit['icon'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">URL </label>
                        <input type="text" class="form-control" name="url" placeholder="Masukkan URL Menu" value="<?= isset($rowEdit['url'])? $rowEdit['url'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">Urutan </label>
                        <input type="number" class="form-control" name="urutan" placeholder="Masukkan Urutan Menu" required value="<?= isset($rowEdit['urutan'])? $rowEdit['urutan'] : '' ?>">
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