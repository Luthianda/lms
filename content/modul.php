<?php

// AS untuk membuat beberapa data dengan nama yang sama jadi tidak ambigu
// LEFT JOIN untuk menghubungkan data2 tersebut menjadi satu-kesatuan
// ON untuk memberitahu secara spesifik data mana yang akan dihubungkan
$queryModul = mysqli_query($config, "SELECT majors.name AS major_name, instructors.name AS instructor_name, moduls. * FROM moduls LEFT JOIN majors ON majors.id = moduls.id_major LEFT JOIN instructors ON instructors.id = moduls.id_instructor ORDER BY moduls.id DESC");
$rowModul = mysqli_fetch_all($queryModul, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Modul</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-modul" class="btn btn-primary">Add Modul</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Instruktur</th>
                                <th>Jurusan</th>
                                <th>Judul</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($rowModul as $key => $data): ?>
                                    <tr>
                                        <!-- jika pakai sama dengan (=) tidak perlu menulis echo lagi -->
                                        <td><?= $key += 1 ?></td>
                                        <td><?= $data['instructor_name'] ?></td>
                                        <td><?= $data['major_name'] ?></td>
                                        <td><?= $data['name'] ?></td>
                                        <td>
                                            <a href="?page=tambah-modul&edit=<?php echo $data['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
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