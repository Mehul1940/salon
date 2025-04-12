<?php
include_once "../../../init.php";
include_once DB_ROOT . 'database.php';
enable_protected_route();

$auth_user = get_auth_user();

$bookings = $connection->find("bookings", ["customer_id" => $auth_user["id"]]);


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cancel_booking"])) {
    $booking_id = intval($_POST["booking_id"]);

    $booking = $connection->findOne("bookings", ["id" => $booking_id, "customer_id" => $auth_user["id"]]);

    if ($booking && $booking["status"] === "Pending") {
        $update = $connection->update("bookings",  $booking_id, ["status" => "Cancelled"]);

        if ($update) {
            show_alert("Booking cancelled successfully.");
        } else {
            show_alert("Failed to cancel booking.");
        }

        redirect("profile/bookings");
    }
}

?>

<?php include_once '../../../includes/header.php'; ?>
<?php include_once '../../../includes/nav.php'; ?>

<div class="container py-5">
    <div class="row">
        <?php $active = "bookings";
        include_once '../../../includes/user_sidebar.php'; ?>

        <div class="col-md-9">
            <div class="profile-content bg-white p-4 rounded border">
                <h2 class="mb-4">My Bookings</h2>

                <?php if (empty($bookings)) : ?>
                    <p class="text-muted">No bookings found.</p>
                <?php else : ?>
                    <div class="accordion" id="bookingsAccordion">
                        <?php foreach ($bookings as $index => $booking) : ?>
                            <?php
                            $service = $connection->findOne("services", ["id" => $booking["service_id"]]);

                            $status_classes = [
                                "Pending" => "bg-secondary",
                                "Confirmed" => "bg-info",
                                "Completed" => "bg-success",
                                "Cancelled" => "bg-danger"
                            ];
                            $status_badge = $status_classes[$booking["status"]] ?? "bg-secondary";
                            ?>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading<?= $index; ?>">
                                    <button class="accordion-button <?= $index > 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#booking<?= $index; ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false'; ?>" aria-controls="booking<?= $index; ?>">
                                        Booking #<?= $booking["id"]; ?> - <?= $service["name"] ?>
                                        <span class="badge text-uppercase <?= $status_badge; ?> ms-3"><?= ucfirst($booking["status"]); ?></span>
                                    </button>
                                </h2>
                                <div id="booking<?= $index; ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : ''; ?>" aria-labelledby="heading<?= $index; ?>" data-bs-parent="#bookingsAccordion">
                                    <div class="accordion-body">
                                        <p><strong>Service:</strong> <?= $service["name"] ?></p>
                                        <p><strong>Appointment Date:</strong> <?= date("F j, Y", strtotime($booking["appointment_date"])); ?></p>
                                        <p><strong>Booked On:</strong> <?= date("F j, Y", strtotime($booking["created_at"])); ?></p>

                                        <div class="d-flex justify-content-between mt-3">
                                            <?php if ($booking["status"] === "Pending") : ?>
                                                <form method="POST">
                                                    <input type="hidden" name="booking_id" value="<?= $booking["id"]; ?>">
                                                    <button type="submit" name="cancel_booking" class="btn btn-outline-danger btn-sm">Cancel Booking</button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include_once '../../../includes/footer.php'; ?>