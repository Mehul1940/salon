<?php
include_once '../../../../init.php';
include DB_ROOT . 'database.php';
enable_admin_route();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = parse_input($_POST['name']);

    $result = $connection->save("brands", [
        "name" => $name
    ]);

    if ($result) {
        redirect("admin/brands");
    }
}
?>

<?php include_once '../../../../includes/header.php'; ?>
<div class="d-flex">
    <?php
    $active = "brands";
    include_once '../../../../includes/admin-sidebar.php';
    ?>
    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="section-title">Add New Brand</h2>
            </div>
        </div>
        <form action="" method="POST">
            <div class="row">
                <div class="mb-3">
                    <label class="form-label">Brand Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Add Brand</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include_once '../../../../includes/admin_footer.php'; ?>