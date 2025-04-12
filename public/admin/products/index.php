<?php
include_once '../../../init.php';
include DB_ROOT . 'database.php';
enable_admin_route();

$products = $connection->findAll("products");
?>

<?php include_once '../../../includes/header.php'; ?>
<div class="d-flex">
    <?php
    $active = "products";
    include_once '../../../includes/admin-sidebar.php';
    ?>

    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="section-title">Products</h2>
                <a href="new" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add New</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Stock</th>
                        <th>Price (₹)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($products) > 0): ?>
                        <?php foreach ($products as $product): ?>
                            <?php
                            $category = $connection->findById("categories", $product['category_id']);
                            $brand = $connection->findById("brands", $product['brand_id']);
                            ?>
                            <tr class="text-center">
                                <td><?= $product['id']; ?></td>
                                <td>
                                    <img src="<?= ASSETS_PATH . 'images/' . $product['image']; ?>"
                                        alt="Product Image"
                                        class="img-thumbnail rounded shadow-sm"
                                        style="width: 80px; height: 60px; object-fit: cover;">
                                </td>
                                <td><?= htmlspecialchars($product['name']); ?></td>
                                <td><?= $category ? htmlspecialchars($category['name']) : 'N/A'; ?></td>
                                <td><?= $brand ? htmlspecialchars($brand['name']) : 'N/A'; ?></td>
                                <td><?= htmlspecialchars($product['stock']); ?></td>
                                <td>₹<?= number_format($product['price'], 2); ?></td>
                                <td>
                                    <a href="view?id=<?= $product['id']; ?>" class="btn btn-sm btn-primary fw-semibold text-uppercase">
                                        View <i class="bi bi-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">No products found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once '../../../includes/admin_footer.php'; ?>