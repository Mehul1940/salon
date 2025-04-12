<?php
include_once '../../../init.php';
include DB_ROOT . 'database.php';
enable_staff_route();

$booking_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$booking_id) redirect("staff");

$booking = $connection->findById("bookings", $booking_id);
$user = $connection->findById("users", $booking["customer_id"]);

$status_classes = [
    "pending" => "bg-secondary",
    "Confirmed" => "bg-success",
    "Completed" => "bg-info",
    "Cancelled" => "bg-danger"
];

$status_options = ["confirmed", "completed", "cancelled"];
$status_badge = $status_classes[$booking["status"]] ?? "bg-secondary";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_status = parse_input($_POST["status"]) ?? $booking["status"];

    $update_data = ["status" => $new_status];

    $connection->update("bookings", $booking_id, $update_data);
    redirect("staff/view?id=" . $booking["id"]);
}
?>

<?php include_once '../../../includes/header.php'; ?>

<div class="d-flex">
    <?php
    $active = "home";
    include_once '../../../includes/staff-sidebar.php';
    ?>

    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Booking Details</h2>
            <a href="<?= ROOT . 'staff/bookings' ?>" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Back to Bookings
            </a>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="my-0 py-2">Booking Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Booking ID:</strong> #<?= $booking['id']; ?></p>
                        <p><strong>User Name:</strong> <?= $user ? $user['name'] : 'N/A'; ?></p>
                        <p><strong>Appointment Date:</strong> <?= date('d M Y, h:i A', strtotime($booking['appointment_date'])); ?></p>
                        <p><strong>Status:</strong>
                            <span class="badge text-uppercase <?= $status_badge; ?> px-3 py-2">
                                <?= ucfirst($booking['status']); ?>
                            </span>
                        </p>

                        <form method="POST" class="mt-3">
                            <label for="status" class="form-label">Change Status:</label>
                            <div class="input-group mb-2">
                                <select name="status" id="status" class="form-select">
                                    <?php foreach ($status_options as $status): ?>
                                        <option value="<?= $status; ?>" <?= $booking["status"] === $status ? "selected" : ""; ?>>
                                            <?= ucfirst($status); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Save</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- User Info -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="my-0 py-2 text-white">User Details</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> <?= $user ? $user['name'] : 'N/A'; ?></p>
                        <p><strong>Email:</strong> <?= $user ? $user['email'] : 'N/A'; ?></p>
                        <p><strong>Phone:</strong> <?= $user ? $user['phone'] : 'N/A'; ?></p>
                        <p><strong>Registered On:</strong> <?= date('d M Y, h:i A', strtotime($user['created_at'])); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once '../../../includes/admin_footer.php'; ?>