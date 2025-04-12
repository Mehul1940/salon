<?php
include_once '../../init.php';
include_once DB_ROOT . 'database.php';

$products_per_page = 8;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $products_per_page;

$products = $connection->paginate(
    "products",
    $products_per_page,
    $offset
);
$total_products = $connection->count("products");
$total_pages = ceil($total_products / $products_per_page);
?>

<?php include_once "../../includes/header.php" ?>
<?php include_once "../../includes/nav.php" ?>

<div>
    <div class="container mt-5">
        <h2 class="mb-4 section-title">Our Products</h2>

        <div class="row">
            <?php foreach ($products as $product): ?>
                <?php
                $category = $connection->findById("categories", $product['category_id']);
                $brand = $connection->findById("brands", $product['brand_id']);
                ?>
                <div class="col-md-4 mb-4 d-flex">
                    <div class="card border-0 overflow-hidden h-100 w-100 transition-all transform hover:scale-105 hover:shadow-xl">
                        <img src="<?= ASSETS_PATH . 'images/' . $product['image']; ?>"
                            alt="<?= htmlspecialchars($product['name']); ?>"
                            class="card-img-top img-fluid" style="object-fit: cover; height: 250px;" />
                        <div class="card-body p-4 text-center">
                            <h3 class="h5 mb-2 text-primary"><?= htmlspecialchars($product['name']); ?></h3>
                            <p class="text-muted mb-3"><?= htmlspecialchars($product['description']); ?></p>
                            <p class="fw-bold mb-3 text-dark">₹<?= number_format($product['price'], 2); ?></p>
                            <div class="text-muted mb-3">
                                <strong>Category:</strong> <?= $category ? htmlspecialchars($category['name']) : 'N/A'; ?><br>
                                <strong>Brand:</strong> <?= $brand ? htmlspecialchars($brand['name']) : 'N/A'; ?>
                            </div>
                        </div>
                        <div class="card-footer bg-white text-center border-0">
                            <form action="<?= ROOT . 'cart/add'; ?>" method="GET">
                                <input type="hidden" name="product_id" value="<?= $product['id']; ?>" />
                                <button type="submit" class="text-uppercase btn btn-primary w-100">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="d-flex justify-content-center py-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php
                        $base_url = "?page=";
                        $query_string = '';
                        ?>

                        <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
                            <?php if ($current_page > 1): ?>
                                <a class="page-link page-arrow" href="<?= $base_url . ($current_page - 1) . $query_string ?>">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            <?php else: ?>
                                <span class="page-link page-arrow disabled">
                                    <i class="bi bi-chevron-left"></i>
                                </span>
                            <?php endif; ?>
                        </li>

                        <li class="page-item" aria-current="page">
                            <span class="page-link active"><?= $current_page ?></span>
                        </li>

                        <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : '' ?>">
                            <?php if ($current_page < $total_pages): ?>
                                <a class="page-link page-arrow" href="<?= $base_url . ($current_page + 1) . $query_string ?>">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            <?php else: ?>
                                <span class="page-link page-arrow disabled">
                                    <i class="bi bi-chevron-right"></i>
                                </span>
                            <?php endif; ?>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php include_once "../../includes/footer.php" ?>