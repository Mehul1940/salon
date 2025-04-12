<?php
include_once '../../../../init.php';
include DB_ROOT . 'database.php';

$brand = null;

if (isset($_GET['id'])) {
    $brandId = parse_input($_GET['id']);
    $brand = $connection->findById("brands", $brandId);

    if (!$brand) {
        redirect("admin/brands");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $name = parse_input($_POST['name']);

    $result = $connection->update("brands", $brand["id"], [
        "name" => $name
    ]);

    if ($result) {
        redirect("admin/brands");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $connection->delete("brands", $brandId);
    redirect("admin/brands");
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
            <div class="col-12 d-flex justify-content-between">
                <h2 class="section-title"><?= $brand ? "Edit Brand" : "Brand Not Found"; ?></h2>
                <?php if ($brand) : ?>
                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this brand?');">
                        <button type="submit" name="delete" class="fw-semibold btn btn-danger">Delete Brand</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($brand) : ?>
            <form action="" method="POST">
                <div class="row">
                    <div class="mb-3">
                        <label class="form-label">Brand Name</label>
                        <input type="text" name="name" class="form-control" value="<?= $brand['name']; ?>" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" name="update" class="btn btn-primary">Update Brand</button>
                    </div>
                </div>
            </form>
        <?php else : ?>
            <p class="text-danger">Brand not found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include_once '../../../../includes/admin_footer.php'; ?>