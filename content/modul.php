<?php

$id_user = isset($_SESSION['ID_USER']) ? $_SESSION['ID_USER'] : '';
$id_role = isset($_SESSION['ID_ROLE']) ? $_SESSION['ID_ROLE'] : '';

// AS untuk membuat beberapa data dengan nama yang sama jadi tidak ambigu
// LEFT JOIN untuk menghubungkan data2 tersebut menjadi satu-kesatuan
// ON untuk memberitahu secara spesifik data mana yang akan dihubungkan

$rowStudent = mysqli_fetch_assoc(mysqli_query($config, "SELECT * FROM students WHERE id = '$id_user'"));
$id_major = $rowStudent['id_major'];

if($id_role == 2){
    $where = "WHERE moduls.id_major='$id_major'";
}elseif($id_role == 1){
    $where = "WHERE moduls.id_instructor='$id_user'";
}

$queryModul = mysqli_query($config, "SELECT majors.name AS major_name, instructors.name AS instructor_name, moduls. * FROM moduls LEFT JOIN majors ON majors.id = moduls.id_major LEFT JOIN instructors ON instructors.id = moduls.id_instructor $where ORDER BY moduls.id DESC");
$rowModul = mysqli_fetch_all($queryModul, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Modul</h5>
                <?php if($_SESSION['ID_ROLE'] == 1): ?>
                    <div class="mb-3" align="right">
                        <a href="?page=tambah-modul" class="btn btn-primary">Add Modul</a>
                    </div>
                <?php endif ?>

                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Instruktur</th>
                                <th>Jurusan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($rowModul as $key => $data): ?>
                                    <tr>
                                        <!-- jika pakai sama dengan (=) tidak perlu menulis echo lagi -->
                                        <td><?= $key += 1 ?></td>
                                        <td>
                                            <a href="?page=tambah-modul&detail=<?= $data['id'] ?>">
                                                <i class="bi bi-emoji-grimace-fill"></i> 
                                                <?= $data['name'] ?>
                                            </a>
                                        </td>
                                        <td><?= $data['instructor_name'] ?></td>
                                        <td><?= $data['major_name'] ?></td>
                                        <td>
                                            <!-- <a href="?page=tambah-modul&edit=<?php echo $data['id'] ?>" class="btn btn-warning btn-sm">Edit</a> -->
                                            <a onclick="return confirm('Are you sure??')"
                                                href="?page=tambah-modul&delete=<?php echo $data['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>