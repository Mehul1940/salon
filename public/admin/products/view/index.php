<?php
include_once '../../../../init.php';
include DB_ROOT . 'database.php';
enable_admin_route();

$product = null;

if (isset($_GET['id'])) {
    $productId = parse_input($_GET['id']);
    $product = $connection->findById("products", $productId);

    if (!$product) {
        redirect("admin/products");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $name = parse_input($_POST['name']);
    $description = parse_input($_POST['description']);
    $price = parse_input($_POST['price']);
    $stock = parse_input($_POST['stock']);
    $category_id = parse_input($_POST['category_id']);
    $brand_id = parse_input($_POST['brand_id']);

    $image = $product['image'];
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "../../../assets/images/";
        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = $imageName;
        }
    }

    $result = $connection->update("products", $product["id"], [
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $connection->delete("products",  $productId);
    redirect("admin/products");
}

// Fetch categories and brands for the dropdowns
$categories = $connection->findAll("categories");
$brands = $connection->findAll("brands");
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
                <h2><?= $product ? "Edit Product" : "Product Not Found"; ?></h2>
                <?php if ($product) : ?>
                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                        <button type="submit" name="delete" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete Product</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($product) : ?>
            <div class="card border">
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Product Name</label>
                                <input type="text" name="name" class="form-control" value="<?= $product['name']; ?>" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Price (₹)</label>
                                <input type="number" name="price" class="form-control" value="<?= $product['price']; ?>" required>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" class="form-control" required rows="3"><?= $product['description']; ?></textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Stock</label>
                                <input type="number" name="stock" class="form-control" value="<?= $product['stock']; ?>" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Category</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id']; ?>" <?= $product['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Brand</label>
                                <select name="brand_id" class="form-select" required>
                                    <option value="">Select Brand</option>
                                    <?php foreach ($brands as $brand): ?>
                                        <option value="<?= $brand['id']; ?>" <?= $product['brand_id'] == $brand['id'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($brand['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Current Image</label><br>
                                <img src="<?= ASSETS_PATH . 'images/' . $product['image']; ?>" alt="Product Image" class="rounded border img-fluid" style="max-width: 150px;">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Upload New Image (Optional)</label>
                                <input type="file" name="image" class="form-control" accept="image/*" id="imageUpload">
                                <div class="mt-2">
                                    <img id="imagePreview" class="rounded border img-fluid d-none" style="max-width: 150px;">
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" name="update" class="btn btn-primary"><i class="fas fa-save"></i> Update Product</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php else : ?>
            <p class="text-danger text-center">Product not found.</p>
        <?php endif; ?>
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