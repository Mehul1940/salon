<?php
include_once '../../../../init.php';
include DB_ROOT . 'database.php';

enable_admin_route();

$categories = $connection->findAll("categories");
$brands = $connection->findAll("brands");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = parse_input($_POST['name']);
    $description = parse_input($_POST['description']);
    $price = parse_input($_POST['price']);
    $stock = parse_input($_POST['stock']);
    $category_id = parse_input($_POST['category_id']);
    $brand_id = parse_input($_POST['brand_id']);

    $image = "";
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "../../../assets/images/";
        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = $imageName;
        }
    }

    $result = $connection->save("products", [
        "name" => $name,
        "description" => $description,
        "price" => $price,
        "stock" => $stock,
        "category_id" => $category_id,
        "brand_id" => $brand_id,
        "image" => $image
    ]);

    if ($result) {
        redirect("admin/products");
    }
}
?>

<?php include_once '../../../../includes/header.php'; ?>
<div class="d-flex">
    <?php
    $active = "products";
    include_once '../../../../includes/admin-sidebar.php';
    ?>

    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2>Add New Product</h2>
                <a href="<?= ROOT . 'admin/products' ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back to Products</a>
            </div>
        </div>

        <div class="card border">
            <div class="card-body py-5">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-semibold">Product Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-semibold">Price (₹)</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" required rows="3"></textarea>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-semibold">Stock</label>
                            <input type="number" name="stock" class="form-control" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-semibold">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id']; ?>"><?= htmlspecialchars($category['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-semibold">Brand</label>
                            <select name="brand_id" class="form-select" required>
                                <option value="">Select Brand</option>
                                <?php foreach ($brands as $brand): ?>
                                    <option value="<?= $brand['id']; ?>"><?= htmlspecialchars($brand['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-semibold">Product Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required id="imageUpload">
                            <div class="mt-2">
                                <img id="imagePreview" class="rounded border img-fluid d-none" style="max-width: 150px;">
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Script -->
<script>
    document.getElementById("imageUpload").addEventListener("change", function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imagePreview = document.getElementById("imagePreview");
                imagePreview.src = e.target.result;
                imagePreview.classList.remove("d-none");
            };
            reader.readAsDataURL(file);
        }
    });
</script>

<?php include_once '../../../../includes/admin_footer.php'; ?>