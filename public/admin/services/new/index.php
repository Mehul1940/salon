<?php
include_once '../../../../init.php';
include DB_ROOT . 'database.php';

enable_admin_route();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = parse_input($_POST['category']);
    $name = parse_input($_POST['name']);
    $description = parse_input($_POST['description']);
    $min_price = parse_input($_POST['min_price']);
    $max_price = !empty($_POST['max_price']) ? parse_input($_POST['max_price']) : null;

    $result = $connection->save("services", [
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
                <h2>Add New Service</h2>
                <a href="<?= ROOT . 'admin/services' ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back to Services</a>
            </div>
        </div>

        <div class="card border">
            <div class="card-body py-5">
                <form action="" method="POST">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-semibold">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="Hair Services">Hair Services</option>
                                <option value="Beauty Services">Beauty Services</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-semibold">Service Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" required rows="3"></textarea>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-semibold">Minimum Price (₹)</label>
                            <input type="number" name="min_price" class="form-control" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-semibold">Maximum Price (₹)</label>
                            <input type="number" name="max_price" class="form-control">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add Service</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once '../../../../includes/admin_footer.php'; ?>