<?php
include_once '../../../init.php';
include DB_ROOT . 'database.php';
enable_admin_route();

$services = $connection->findAll("services");
?>

<?php include_once '../../../includes/header.php'; ?>
<div class="d-flex">
    <?php
    $active = "services";
    include_once '../../../includes/admin-sidebar.php';
    ?>

    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="section-title">Services</h2>
                <a href="new" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add New</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Service Name</th>
                        <th>Min Price (₹)</th>
                        <th>Max Price (₹)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($services) > 0): ?>
                        <?php foreach ($services as $service): ?>
                            <tr class="text-center">
                                <td><?= $service['id']; ?></td>
                                <td><span class="badge text-uppercase bg-<?= $service['category'] == 'Hair Services' ? 'secondary' : 'info' ?>"><?= htmlspecialchars($service['category']); ?></span></td>
                                <td><?= htmlspecialchars($service['name']); ?></td>
                                <td>₹<?= number_format($service['min_price'], 2); ?></td>
                                <td>
                                    <?= $service['max_price'] ? '₹' . number_format($service['max_price'], 2) : '<span class="text-muted">N/A</span>'; ?>
                                </td>
                                <td>
                                    <a href="view?id=<?= $service['id']; ?>" class="btn btn-sm btn-primary fw-semibold text-uppercase">
                                        View <i class="bi bi-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No services found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once '../../../includes/admin_footer.php'; ?>