<?php
include_once '../../../../init.php';
include DB_ROOT . 'database.php';
enable_admin_route();

$booking_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$booking_id) redirect("admin/bookings");

$booking = $connection->findById("bookings", $booking_id);
if (!$booking) redirect("admin/bookings");

$user = $connection->findById("users", $booking["customer_id"]);
$staff_members = $connection->find("users", ["role" => "staff"]);

$status_classes = [
    "pending" => "bg-secondary",
    "Confirmed" => "bg-success",
    "Completed" => "bg-primary",
    "Cancelled" => "bg-danger"
];

$status_options = ["pending", "confirmed", "completed", "cancelled"];
$status_badge = $status_classes[$booking["status"]] ?? "bg-secondary";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_status = parse_input($_POST["status"]) ?? $booking["status"];
    $assigned_staff = parse_input($_POST["staff_id"]) ?? $booking["staff_id"];

    $update_data = [
        "status" => $new_status,
        "staff_id" => $assigned_staff
    ];

    $connection->update("bookings", $booking_id, $update_data);
    redirect("admin/bookings/view?id=" . $booking["id"]);
}
?>

<?php include_once '../../../../includes/header.php'; ?>

<div class="d-flex">
    <?php
    $active = "bookings";
    include_once '../../../../includes/admin-sidebar.php';
    ?>

    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Booking Details</h2>
            <a href="<?= ROOT . 'admin/bookings' ?>" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Back to Bookings
            </a>
        </div>

        <div class="row">
            <!-- Booking Info -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="my-0 py-2">Booking Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Booking ID:</strong> #<?= $booking['id']; ?></p>
                        <p><strong>User Name:</strong> <?= $user ? $user['name'] : 'N/A'; ?></p>
                        <p><strong>Appointment Date :</strong> <?= date('d M Y, h:i A', strtotime($booking['appointment_date'])); ?></p>
                        <p><strong>Status:</strong>
                            <span class="badge text-uppercase <?= $status_badge; ?> px-3 py-2">
                                <?= ucfirst($booking['status']); ?>
                            </span>
                        </p>

                        <!-- Status and Staff Update Form -->
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

                            <label for="staff_id" class="form-label">Assign Staff:</label>
                            <div class="input-group mb-2">
                                <select name="staff_id" id="staff_id" class="form-select">
                                    <option value="">Select Staff</option>
                                    <?php foreach ($staff_members as $staff): ?>
                                        <option value="<?= $staff['id']; ?>" <?= $booking['staff_id'] == $staff['id'] ? "selected" : ""; ?>>
                                            <?= $staff['name']; ?>
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

<?php include_once '../../../../includes/admin_footer.php'; ?>