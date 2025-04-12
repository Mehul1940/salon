<?php
include_once '../../../init.php';
include DB_ROOT . 'database.php';
enable_admin_route();

$quote_requests = $connection->findAll("quote_requests");
?>

<?php include_once '../../../includes/header.php'; ?>
<div class="d-flex">
    <?php
    $active = "quotes";
    include_once '../../../includes/admin-sidebar.php';
    ?>

    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="section-title">Quote Requests</h2>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Event Type</th>
                        <th>Event Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($quote_requests) > 0): ?>
                        <?php foreach ($quote_requests as $quote): ?>
                            <tr class="text-center">
                                <td><?= $quote['id']; ?></td>
                                <td><?= htmlspecialchars($quote['name']); ?></td>
                                <td><?= htmlspecialchars($quote['email']); ?></td>
                                <td><?= htmlspecialchars($quote['phone']); ?></td>
                                <td><?= htmlspecialchars($quote['event_type']); ?></td>
                                <td><?= htmlspecialchars($quote['event_date']); ?></td>
                                <td>
                                    <span class="text-uppercase badge <?= $quote['status'] === 'pending' ? 'bg-dark' : ($quote['status'] === 'contacted' ? 'bg-info' : 'bg-danger'); ?>">
                                        <?= $quote['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="view?id=<?= $quote['id']; ?>" class="btn btn-sm btn-primary fw-semibold text-uppercase">
                                        View <i class="bi bi-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">No quote requests found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once '../../../includes/admin_footer.php'; ?>