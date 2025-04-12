<?php
include_once '../../init.php';
include DB_ROOT . 'database.php';
enable_staff_route();

$staff = get_auth_user();

$bookings = $connection->find("bookings", ["staff_id" => $staff["id"]]);

?>

<?php include_once '../../includes/header.php'; ?>
<div class="d-flex">
    <?php
    $active = "home";
    include_once '../../includes/staff-sidebar.php';
    ?>
    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="section-title">My Assigned Services</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive" id="printable">
                    <table class="table table-hover">
                        <thead class="bg-secondary">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Customer</th>
                                <th>Service</th>
                                <th>Appointment Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($bookings)): ?>
                                <?php foreach ($bookings as $index => $booking) : ?>
                                    <?php
                                    $customer = $connection->findById("users", $booking["customer_id"]);
                                    $service = $connection->findById("services", $booking["service_id"]);

                                    $status_classes = [
                                        "Pending" => "bg-secondary",
                                        "Confirmed" => "bg-info",
                                        "Completed" => "bg-success",
                                        "Cancelled" => "bg-danger"
                                    ];
                                    $status_badge = $status_classes[$booking["status"]] ?? "bg-secondary";
                                    ?>
                                    <tr class="text-center">
                                        <td><?= $booking['id']; ?></td>
                                        <td><?= $customer ? $customer['name'] : 'N/A'; ?></td>
                                        <td><?= $service ? $service['name'] : 'N/A'; ?></td>
                                        <td><?= date('d M Y, h:i A', strtotime($booking['appointment_date'])); ?></td>
                                        <td><span class="badge text-uppercase <?= $status_badge; ?>"><?= ucfirst($booking['status']); ?></span></td>
                                        <td>
                                            <a href="view?id=<?= $booking['id']; ?>" class="fw-semibold btn btn-sm btn-primary text-uppercase">
                                                View <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No assigned services found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include_once '../../includes/admin_footer.php'; ?>