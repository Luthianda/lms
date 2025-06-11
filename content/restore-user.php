<?php

$queryReUser = mysqli_query($config, "SELECT * FROM users WHERE deleted_at = 1 ORDER BY id DESC");
$rowReUser = mysqli_fetch_all($queryReUser, MYSQLI_ASSOC);

if(isset($_GET['restore'])){
    $idRestore = $_GET['restore'];
    $queryRestore = mysqli_query($config, "UPDATE users SET deleted_at = 0 WHERE id = $idRestore");
    if($queryRestore){
        header("location:?page=user");
    }
}
if (isset($_GET['delete'])) {
    $idDel = $_GET['delete'];

    $qDelete = mysqli_query($config, "DELETE FROM users WHERE id = $idDel");
    if ($qDelete) {
        header("location:?page=user ");
    }
}
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data User</h5>
                <div class="mb-3 d-flex justify-content-between">
                    <a href="?page=user" class="btn btn-secondary">Back</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered datatable">
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
                                foreach ($rowReUser as $key => $data): ?>
                                    <tr>
                                        <!-- jika pakai sama dengan (=) tidak perlu menulis echo lagi -->
                                        <td><?= $key += 1 ?></td>
                                        <td><?= $data['name'] ?></td>
                                        <td><?= $data['email'] ?></td>
                                        <td>
                                            <a href="?page=restore-user&restore=<?php echo $data['id'] ?>" class="btn btn-warning btn-sm">Restore</a>
                                            <a onclick="return confirm('Are you sure??')"
                                                href="?page=restore-user&delete=<?php echo $data['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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