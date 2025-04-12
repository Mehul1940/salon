<?php
include_once '../../../init.php';
include DB_ROOT . 'database.php';

$brands = $connection->findAll("brands");
?>

<?php include_once '../../../includes/header.php'; ?>
<div class="d-flex">
    <?php
    $active = "brands";
    include_once '../../../includes/admin-sidebar.php';
    ?>
    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="section-title">Brands</h2>
                <a href="new" id="print-btn" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add new</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive" id="printable">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Brand Name</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($brands) > 0): ?>
                                <?php foreach ($brands as $brand): ?>
                                    <tr class="text-center">
                                        <td><?= $brand['id']; ?></td>
                                        <td><?= htmlspecialchars($brand['name']); ?></td>
                                        <td><?= htmlspecialchars($brand['created_at']); ?></td>
                                        <td>
                                            <a href="view?id=<?= $brand['id']; ?>" class="fw-semibold btn btn-sm btn-outline-primary">
                                                View <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No brands found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once '../../../includes/admin_footer.php'; ?>