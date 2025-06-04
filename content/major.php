<?php
include 'config/koneksi.php';
$queryMajor = mysqli_query($config, "SELECT * FROM majors ORDER BY id DESC");
$rowMajor = mysqli_fetch_all($queryMajor, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Jurusan</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-major" class="btn btn-primary">Add Jurusan</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jurusan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                                foreach ($rowMajor as $key => $data): ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $data['name'] ?></td>
                                        <td>
                                            <a href="?page=tambah-major&edit=<?php echo $data['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a onclick="return confirm('Are you sure??')"
                                                href="?page=tambah-major&delete=<?php echo $data['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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