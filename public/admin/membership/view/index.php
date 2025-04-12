<?php
include_once '../../../../init.php';
include DB_ROOT . 'database.php';
enable_admin_route();

$membership_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$membership_id) redirect("admin/memberships");

$membership = $connection->findById("membership", $membership_id);
if (!$membership) redirect("admin/memberships");

$member = $connection->findById("users", $membership["user_id"]);
$plan = $connection->findById("membership_plans", $membership["plan_id"]); // Fetch plan details

$status_classes = [
    "pending" => "bg-secondary",
    "approved" => "bg-success",
    "rejected" => "bg-danger",
    "expired" => "bg-dark",
    "suspended" => "bg-warning"
];

$status_options = ["pending", "approved", "rejected", "expired", "suspended"];
$status_badge = $status_classes[$membership["status"]] ?? "bg-secondary";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_status = parse_input($_POST["status"]) ?? $membership["status"];

    $update_data = [
        "status" => $new_status,
    ];

    if ($new_status === "approved") {
        // Set expiry date based on the duration of the selected plan
        $duration = $plan["duration"]; // Get the duration from the plan
        $expiry_date = date("Y-m-d", strtotime("+$duration"));
        $update_data["expiry_date"] = $expiry_date;
    }

    $connection->update("membership", $membership_id, $update_data);
    redirect("admin/membership/view?id=" .  $membership["id"]);
}
?>

<?php include_once '../../../../includes/header.php'; ?>

<div class="d-flex">
    <?php
    $active = "memberships";
    include_once '../../../../includes/admin-sidebar.php';
    ?>

    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title"><i class="bi bi-person-badge"></i> Membership Details</h2>
            <a href="<?= ROOT . 'admin/memberships' ?>" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Back to Memberships
            </a>
        </div>

        <div class="row">
            <!-- Membership Info -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="my-0 py-2">Membership Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Membership ID:</strong> #<?= $membership['id']; ?></p>
                        <p><strong>Member Name:</strong> <?= $member ? $member['name'] : 'N/A'; ?></p>
                        <p><strong>Request Date:</strong> <?= date('d M Y, h:i A', strtotime($membership['request_date'])); ?></p>
                        <p><strong>Expiry Date:</strong> <?= $membership['expiry_date'] ? date('d M Y', strtotime($membership['expiry_date'])) : 'N/A'; ?></p>
                        <p><strong>Status:</strong>
                            <span class="badge text-uppercase <?= $status_badge; ?> px-3 py-2"><?= ucfirst($membership['status']); ?></span>
                        </p>

                        <!-- Status Update Form -->
                        <form method="POST" class="mt-3">
                            <label for="status" class="form-label">Change Status:</label>
                            <div class="input-group mb-2">
                                <select name="status" id="status" class="form-select">
                                    <?php foreach ($status_options as $status): ?>
                                        <option value="<?= $status; ?>" <?= $membership["status"] === $status ? "selected" : ""; ?>>
                                            <?= ucfirst($status); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Member Info -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="my-0 py-2 text-white">Member Details</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> <?= $member ? $member['name'] : 'N/A'; ?></p>
                        <p><strong>Email:</strong> <?= $member ? $member['email'] : 'N/A'; ?></p>
                        <p><strong>Phone:</strong> <?= $member ? $member['phone'] : 'N/A'; ?></p>
                        <p><strong>Registered On:</strong> <?= date('d M Y, h:i A', strtotime($member['created_at'])); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Proof Section -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-info text-white">
                        <h5 class="my-0 py-2">Payment Proof</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($membership["payment_proof"]): ?>
                            <p><strong>Proof of Payment:</strong></p>
                            <img src="<?= ASSETS_PATH . 'images/' . htmlspecialchars($membership['payment_proof']); ?>" class="img-fluid" alt="Payment Proof">
                        <?php else: ?>
                            <p>No payment proof uploaded.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Print Receipt -->
        <div class="mt-4 text-center">
            <button id="print-btn" class="fw-semibold btn btn-outline-dark">
                <i class="bi bi-printer"></i> Print Membership Details
            </button>
        </div>

        <!-- Hidden Print Content -->
        <div id="receipt-content" class="d-none">
            <div class="container border rounded p-4 shadow-sm bg-white">
                <h2 class="text-center text-primary fw-bold">Membership Details</h2>
                <hr>
                <p><strong>Membership ID:</strong> #<?= $membership['id']; ?></p>
                <p><strong>Member Name:</strong> <?= $member ? $member['name'] : 'N/A'; ?></p>
                <p><strong>Email:</strong> <?= $member ? $member['email'] : 'N/A'; ?></p>
                <p><strong>Request Date:</strong> <?= date('d M Y, h:i A', strtotime($membership['request_date'])); ?></p>
                <p><strong>Expiry Date:</strong> <?= $membership['expiry_date'] ? date('d M Y', strtotime($membership['expiry_date'])) : 'N/A'; ?></p>
                <p><strong>Status:</strong> <span class="badge text-uppercase <?= $status_badge; ?>"><?= ucfirst($membership['status']); ?></span></p>
                <p><strong>Payment Proof:</strong></p>
                <?php if ($membership["payment_proof"]): ?>
                    <img src="../../../assets/images/<?= htmlspecialchars($membership['payment_proof']); ?>" class="img-fluid" alt="Payment Proof">
                <?php else: ?>
                    <p>No payment proof uploaded.</p>
                <?php endif; ?>
                <hr>
                <p class="text-center text-muted small">Thank you for your membership!</p>
            </div>
        </div>
    </div>
</div>

<!-- Print Script -->
<script>
    document.getElementById("print-btn").addEventListener("click", function() {
        var printWindow = window.open('', '_blank');
        var content = document.getElementById("receipt-content").innerHTML;
        printWindow.document.write('<html><head><title>Membership Details</title>');
        printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
        printWindow.document.write('</head><body class="container mt-4">');
        printWindow.document.write(content);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    });
</script>

<?php include_once '../../../../includes/admin_footer.php'; ?>