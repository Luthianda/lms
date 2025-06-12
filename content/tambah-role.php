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

if(isset($_GET['add-role-menu'])){
    $id_role = $_GET['add-role-menu'];

    $rowEditRoleMenu = [];
    $editRoleMenu = mysqli_query($config, "SELECT * FROM menu_roles WHERE id_role= '$id_role'");
    // $rowEditRoleMenu = mysqli_fetch_all($editRoleMenu, MYSQLI_ASSOC);
    while($editMenu = mysqli_fetch_assoc($editRoleMenu)){
        $rowEditRoleMenu[] = $editMenu['id_menu'];
    }

    $menus = mysqli_query($config, "SELECT * FROM menus ORDER BY parent_id, urutan");

    $rowMenu = [];
    while($m = mysqli_fetch_assoc($menus)){
        $rowMenu[] = $m;
    };
    
}

if(isset($_POST['save'])){
    $id_role = $_GET['add-role-menu'];
    $id_menus = $_POST['id_menus'] ?? [];
//     if($_POST['id_menus']){
//         $id_menus = $_POST['id_menus'];
//     }else{
//         $id_menus = [];
//     } (kepanjangan maksud dari isi $id_menus)

    mysqli_query($config, "DELETE FROM menu_roles WHERE id_role ='$id_role'" );
    foreach($id_menus as $m){
        $id_menu = $m;
        mysqli_query($config, "INSERT INTO menu_roles (id_role, id_menu) VALUE ('$id_role','$id_menu') ");
    }
        header("location:?page=tambah-role&add-role-menu" . $id_role . "&tambah=berhasil");
}



?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Role</h5>
                <?php if(isset($_GET['add-role-menu'])): ?>
                    <form action="" method="post">
                        <div class="mb-3">
                            <ul>
                                <?php foreach($rowMenu as $mainMenu): ?>
                                    <?php if($mainMenu['parent_id'] == 0 OR $mainMenu['parent_id'] == ""): ?>
                                    <li>
                                        <label for="">
                                            <!-- jika id value id_menu dari table menu nilainya 1 
                                             == jika nilai id_menu dari table menu nilainya sama dengan 1  -->
                                            <input <?= in_array($mainMenu['id'], $rowEditRoleMenu) ? 'checked' : '' ?> type="checkbox" name="id_menus[]" value="<?= $mainMenu['id'] ?>"><?= $mainMenu['name'] ?>
                                        </label>
                                        <ul>
                                            <?php foreach($rowMenu as $subMenu): ?>
                                                <?php if($subMenu['parent_id'] ==  $mainMenu['id']): ?>
                                            <li>
                                                <label for="">
                                                    <input <?= in_array($subMenu['id'], $rowEditRoleMenu) ? 'checked' : '' ?> type="checkbox" name="id_menus[]" value="<?= $subMenu['id'] ?>"><?= $subMenu['name'] ?>
                                                </label>
                                            </li>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        </ul>
                                    </li>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </ul>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" name="save">Simpan Perubahan</button>
                        </div>
                    </form>
                <?php elseif(isset($_GET['edit'])): ?>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="">Role *</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan Role" required value="<?= isset($rowEdit['name'])? $rowEdit['name'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="btn btn-success" name="save" value="save">
                        </div>
                    </form>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>