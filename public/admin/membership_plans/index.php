<?php
include_once '../../../init.php';
include DB_ROOT . 'database.php';
enable_admin_route();

$plans = $connection->findAll("membership_plans");
?>

<?php include_once '../../../includes/header.php'; ?>
<div class="d-flex">
    <?php
    $active = "membership_plans";
    include_once '../../../includes/admin-sidebar.php';
    ?>

    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="section-title">Membership Plans</h2>
                <a href="new" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add New</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Duration</th>
                        <th>Price (₹)</th>
                        <th>Order Discount (%)</th>
                        <th>Service Discount (%)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($plans) > 0): ?>
                        <?php foreach ($plans as $plan): ?>
                            <tr class="text-center">
                                <td><?= $plan['id']; ?></td>
                                <td><?= htmlspecialchars($plan['name']); ?></td>
                                <td><?= htmlspecialchars($plan['duration']); ?></td>
                                <td>₹<?= number_format($plan['price'], 2); ?></td>
                                <td><?= number_format($plan['order_discount'], 2); ?>%</td>
                                <td><?= number_format($plan['service_discount'], 2); ?>%</td>
                                <td>
                                    <a href="view?id=<?= $plan['id']; ?>" class="btn btn-sm btn-primary fw-semibold text-uppercase">
                                        View <i class="bi bi-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No membership plans found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once '../../../includes/admin_footer.php'; ?>