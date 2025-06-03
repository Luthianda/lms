<?php
include 'config/koneksi.php';
$queryInst = mysqli_query($config, "SELECT * FROM instructors ORDER BY id DESC");
$rowInst = mysqli_fetch_all($queryInst, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Instruktur</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-user" class="btn btn-primary">Add Instructor</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Pendidikan</th>
                                <th>No Telp</th>
                                <th>Alamat</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                                foreach ($rowInst as $key => $data): ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $data['name'] ?></td>
                                        <td><?= $data['gender'] ?></td>
                                        <td><?= $data['education'] ?></td>
                                        <td><?= $data['phone'] ?></td>
                                        <td><?= $data['email'] ?></td>
                                        <td><?= $data['address'] ?></td>
                                        <td>
                                            <a href="?page=tambah-user&edit=<?php echo $data['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a onclick="return confirm('Are you sure??')"
                                                href="?page=tambah-user&delete=<?php echo $data['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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