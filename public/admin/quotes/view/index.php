<?php
include_once '../../../../init.php';
include DB_ROOT . 'database.php';
enable_admin_route();

$quote_id = $_GET['id'] ?? null;

if (!$quote_id) {
    redirect("quote_requests");
}

$quote_request = $connection->findOne("quote_requests", ['id' => $quote_id]);

if (!$quote_request) {
    redirect("quote_requests");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_status = $_POST['status'] ?? null;

    if (in_array($new_status, ['pending', 'contacted', 'closed'])) {
        $connection->update('quote_requests', $quote_id, ['status' => $new_status]);
        $quote_request['status'] = $new_status;
    }
}

?>

<?php include_once '../../../../includes/header.php'; ?>
<div class="d-flex">
    <?php
    $active = "quotes";
    include_once '../../../../includes/admin-sidebar.php';
    ?>

    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="section-title">Quote Request - View</h2>
                <a href="<?= ROOT . 'admin/quotes' ?>" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Back to List</a>
            </div>
        </div>

        <div class="card border pt-5 px-4">
            <div class="card-header">
                <h5 class="mb-0">Quote Request Details</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> <?= isset($quote_request['name']) ? htmlspecialchars($quote_request['name']) : ''; ?></p>
                <p><strong>Email:</strong> <?= isset($quote_request['email']) ? htmlspecialchars($quote_request['email']) : ''; ?></p>
                <p><strong>Phone:</strong> <?= isset($quote_request['phone']) ? htmlspecialchars($quote_request['phone']) : ''; ?></p>
                <p><strong>Event Type:</strong> <?= isset($quote_request['event_type']) ? htmlspecialchars($quote_request['event_type']) : ''; ?></p>
                <p><strong>Event Date:</strong> <?= isset($quote_request['event_date']) ? htmlspecialchars($quote_request['event_date']) : ''; ?></p>
                <p><strong>Message:</strong> <?= isset($quote_request['message']) ? nl2br(htmlspecialchars($quote_request['message'])) : ''; ?></p>
                <p><strong>Status:</strong>
                    <span class="text-uppercase badge <?= $quote_request['status'] === 'pending' ? 'bg-dark' : ($quote['status'] === 'contacted' ? 'bg-info' : 'bg-danger'); ?>">
                        <?= $quote_request['status']; ?>
                    </span>
                </p>

                <form method="POST" class="mt-4">
                    <div class="mb-3">
                        <label for="status" class="form-label">Change Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="pending" <?= isset($quote_request['status']) && $quote_request['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="contacted" <?= isset($quote_request['status']) && $quote_request['status'] === 'contacted' ? 'selected' : ''; ?>>Contacted</option>
                            <option value="closed" <?= isset($quote_request['status']) && $quote_request['status'] === 'closed' ? 'selected' : ''; ?>>Closed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once '../../../../includes/admin_footer.php'; ?>