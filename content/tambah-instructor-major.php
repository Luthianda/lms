<?php

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $id_instructor = $_GET['id_instructor'];
    $queryDelete = mysqli_query($config, "DELETE FROM instructor_majors WHERE id='$id'");
    if($queryDelete){
        header("location:?page=tambah-instructor-major&id=" . $id_instructor . "&hapus=berhasil");
    }else{
        header("location:?page=tambah-instructor-major&id=" . $id_instructor . "&hapus=gagal");
    }
}

$id_instructor = isset($_GET['id']) ? $_GET['id'] : '';

$edit = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($config, "SELECT * FROM instructor_majors WHERE id= '$edit'");
$rowEdit= mysqli_fetch_assoc($queryEdit);
    

if(isset($_POST['id_major'])){
    // mengecek ada tidak sebuah parameter bernama edit, kalo ada jalankan perintah edit/update
    // kalo tidak ada jalankan perintah data baru / insert
    $id_major = $_POST['id_major'];
    if(isset($_GET['edit'])){
        $update = mysqli_query($config, "UPDATE instructor_majors SET id_major='$id_major' WHERE id='$edit'");
        header("location:?page=tambah-instructor-major&id=" . $id_instructor . "&ubah=berhasil");
    }else{
        $insert = mysqli_query($config, "INSERT INTO instructor_majors (id_major, id_instructor) VALUES ('$id_major','$id_instructor')");
        header("location:?page=tambah-instructor-major&id=" . $id_instructor . "&tambah=berhasil");
    }
}

$queryMajors = mysqli_query($config, "SELECT * FROM majors ORDER BY id DESC");
$rowMajors = mysqli_fetch_all($queryMajors, MYSQLI_ASSOC);


$queryInstructor = mysqli_query($config, "SELECT * FROM instructors WHERE id= '$id_instructor'");
$rowInstructor= mysqli_fetch_assoc($queryInstructor);


$queryInstMajor = mysqli_query($config, "SELECT majors.name, instructor_majors.id, id_instructor FROM instructor_majors 
LEFT JOIN majors ON majors.id = instructor_majors.id_major WHERE id_instructor='$id_instructor' ORDER BY instructor_majors.id DESC");
$rowInstMajors= mysqli_fetch_all($queryInstMajor, MYSQLI_ASSOC);

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Jurusan Instruktur : <?php echo $rowInstructor['name']?></h5>
                <!-- Form Edit -->
                    <?php if (isset($_GET['edit'])): ?>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="" class="form-label">Nama Jurusan</label>
                                <select name="id_major" id="" class="form-control">
                                    <option value="">--Pilih Salah Satu--</option>
                                        <?php foreach ($rowMajors as $rowMajor): ?>
                                            <option <?php echo ($rowMajor['id'] == $rowEdit['id_major']) ? 'selected' : '' ?> value="<?php echo $rowMajor['id']?>"><?php echo $rowMajor['name']?></option>    
                                        <?php endforeach ?>
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary" type="sumbit">Simpan Perubahan</button>
                            </div>
                        </form>

                 <!-- End Form Edit -->
                    <?php else: ?>
                        <div align="right">
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Add Jurusan
                            </button>
                        </div>
                
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Jurusan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php foreach ($rowInstMajors as $index => $rowInstMajor): ?>
                                        <tr>
                                            <!-- jika pakai sama dengan (=) tidak perlu menulis echo lagi -->
                                            <td><?= $index += 1 ?></td>
                                            <td><?php echo $rowInstMajor['name']?></td>
                                            <td>
                                                <a href="?page=tambah-instructor-major&id=<?php echo $rowInstMajor['id_instructor'] ?>&edit=<?php echo $rowInstMajor['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a onclick="return confirm('Are you sure??')"
                                                    href="?page=tambah-instructor-major&delete=<?php echo $rowInstMajor['id'] ?> &id_instructor=<?php echo $rowInstMajor['id_instructor'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tr>
                            </tbody>
                        </table>
            
                    <?php endif ?>
                 <!-- Listing Table -->
                
            </div> 
        </div>
    </div>
</div>

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Jurusan Baru</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form action="" method="post">
            <div class="modal-body">
              <div class="mb-3">
                <label for="" class="form-label">Nama Jurusan</label>
                <select name="id_major" id="" class="form-control">
                    <option value="">--Pilih Salah Satu--</option>

                    <option value="">
                        <?php foreach ($rowMajors as $rowMajor): ?>
                            <option <?= isset($rowMajor['name'])? ($rowMajor['name'] == 1) ? 'checked' : '' :'' ?> value="<?php echo $rowMajor['id']?>"><?php echo $rowMajor['name']?></option>    
                        <?php endforeach ?>
                    </option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        
        </form>
    </div>
  </div>
</div>