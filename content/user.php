<?php
include 'config/koneksi.php';
$queryUser = mysqli_query($config, "SELECT * FROM users WHERE deleted_at = 0 ORDER BY id DESC");
$rowUser = mysqli_fetch_all($queryUser, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data User</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-user" class="btn btn-primary">Add User</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($rowUser as $key => $data): ?>
                                    <tr>
                                        <!-- jika pakai sama dengan (=) tidak perlu menulis echo lagi -->
                                        <td><?= $key += 1 ?></td>
                                        <td><?= $data['name'] ?></td>
                                        <td><?= $data['email'] ?></td>
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