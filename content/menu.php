<?php
include 'config/koneksi.php';
$queryMenu = mysqli_query($config, "SELECT * FROM menus ORDER BY id ASC");
$rowMenu = mysqli_fetch_all($queryMenu, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Menu</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-menu" class="btn btn-primary">Add Menu</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Parent Id</th>
                                <th>Icon</th>
                                <th>URL</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                                foreach ($rowMenu as $index => $row): ?>
                                    <tr>
                                        <td><?= $index += 1 ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['parent_id'] ?></td>
                                        <td><?= $row['icon'] ?></td>
                                        <td><?= $row['url'] ?></td>
                                        <td>
                                            <a href="?page=tambah-menu&edit=<?php echo $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a onclick="return confirm('Are you sure??')"
                                                href="?page=tambah-menu&delete=<?php echo $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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