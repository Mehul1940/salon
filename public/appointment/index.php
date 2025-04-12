<?php
include_once "../../init.php";
include DB_ROOT . 'database.php';

enable_protected_route();

$auth_user = get_auth_user();

$services = $connection->findAll("services");

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $service_id = parse_input($_POST["service_id"]);
    $date = parse_input($_POST["date"]);

    $errors = [];

    if (empty($service_id)) {
        $errors["service"] = "Please select a service";
    }

    if (empty($date)) {
        $errors["date"] = "Please select a date";
    }

    if (empty($errors)) {

        $booking = [
            "customer_id" => $auth_user["id"],
            "service_id" => $service_id,
            "appointment_date" => $date
        ];

        $connection->save("bookings", $booking);

        if ($booking) {
            redirect("profile/bookings", "Appointment submitted");
        }
    }
}

?>

<?php include_once '../../includes/header.php' ?>
<?php include_once '../../includes/nav.php' ?>


<div class="container my-5">
    <h2 class="text-center mb-4">Book Appointment</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="booking-card">
                <form id="bookingForm" method="POST">
                    <div class="mb-3">
                        <label for="service" class="form-label">Select Service</label>
                        <select class="form-select" id="service" name="service_id" required>
                            <option value="" disabled selected>Choose a service</option>
                            <?php foreach ($services as $service): ?>
                                <option value="<?= $service['id'] ?>"><?= $service['name'] ?> (₹<?= number_format($service['min_price'], 0) ?> - ₹<?= number_format($service['max_price'], 0) ?>)</option>
                            <?php endforeach; ?>
                            <p class="fw-semibold text-danger"><?= $errors["service"] ?? "" ?></p>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter your name" value="<?= $auth_user["name"] ?? "" ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter your email" value="<?= $auth_user["email"] ?? "" ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" placeholder="Enter your phone" value="<?= $auth_user["phone"] ?? "" ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Select Date</label>
                        <input type="datetime-local" class="form-control" id="date" name="date" required>
                        <p class="fw-semibold text-danger"><?= $errors["date"] ?? "" ?></p>
                    </div>

                    <button type="submit" class="btn btn-primary text-uppercase mt-3">Book Now</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include_once '../../includes/footer.php' ?>