<?php
include_once '../../../../init.php';
include DB_ROOT . 'database.php';
enable_admin_route();

$service = null;

if (isset($_GET['id'])) {
    $serviceId = parse_input($_GET['id']);
    $service = $connection->findById("services", $serviceId);

    if (!$service) {
        redirect("admin/services");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $category = parse_input($_POST['category']);
    $name = parse_input($_POST['name']);
    $description = parse_input($_POST['description']);
    $min_price = parse_input($_POST['min_price']);
    $max_price = !empty($_POST['max_price']) ? parse_input($_POST['max_price']) : null;

    $result = $connection->update("services", $service["id"], [
        "category" => $category,
        "name" => $name,
        "description" => $description,
        "min_price" => $min_price,
        "max_price" => $max_price
    ]);

    if ($result) {
        redirect("admin/services");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $connection->delete("services",  $serviceId);
    redirect("admin/services");
}
?>

<?php include_once '../../../../includes/header.php'; ?>
<div class="d-flex">
    <?php
    $active = "services";
    include_once '../../../../includes/admin-sidebar.php';
    ?>

    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2><?= $service ? "Edit Service" : "Service Not Found"; ?></h2>
                <?php if ($service) : ?>
                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');">
                        <button type="submit" name="delete" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete Service</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($service) : ?>
            <div class="card border">
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Category</label>
                                <select name="category" class="form-select" required>
                                    <option value="Hair Services" <?= $service['category'] == "Hair Services" ? "selected" : ""; ?>>Hair Services</option>
                                    <option value="Beauty Services" <?= $service['category'] == "Beauty Services" ? "selected" : ""; ?>>Beauty Services</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Service Name</label>
                                <input type="text" name="name" class="form-control" value="<?= $service['name']; ?>" required>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" class="form-control" required rows="3"><?= $service['description']; ?></textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Minimum Price (₹)</label>
                                <input type="number" name="min_price" class="form-control" value="<?= $service['min_price']; ?>" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Maximum Price (₹) (Optional)</label>
                                <input type="number" name="max_price" class="form-control" value="<?= $service['max_price']; ?>">
                            </div>
                            <div class="col-12">
                                <button type="submit" name="update" class="btn btn-primary"><i class="fas fa-save"></i> Update Service</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php else : ?>
            <p class="text-danger text-center">Service not found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include_once '../../../../includes/admin_footer.php'; ?>