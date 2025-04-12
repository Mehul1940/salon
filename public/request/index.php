<?php
include_once "../../init.php";
include_once DB_ROOT . 'database.php';

enable_protected_route();

$auth_user = get_auth_user();
$errors = [];
$user_info = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = validate_quote_request();

    $user_info["name"] = parse_input($_POST["name"]);
    $user_info["email"] = parse_input($_POST["email"]);
    $user_info["phone"] = parse_input($_POST["phone"]);
    $user_info["event_type"] = parse_input($_POST["event_type"]);
    $user_info["event_date"] = parse_input($_POST["event_date"]);
    $user_info["message"] = parse_input($_POST["message"]);

    if (count($errors) === 0) {
        $result = save_quote_request($user_info);

        if ($result) {
            redirect("", "Quote Added. We will contact you.");
        }
    }
}

function validate_quote_request()
{
    $errors = [];

    $name = parse_input($_POST["name"]);
    $email = parse_input($_POST["email"]);
    $phone = parse_input($_POST["phone"]);
    $event_type = parse_input($_POST["event_type"]);
    $event_date = parse_input($_POST["event_date"]);
    $message = parse_input($_POST["message"]);

    if (empty($name)) {
        $errors['name_error'] = 'Please enter your full name';
    } else if (strlen($name) < 4) {
        $errors['name_error'] = 'Please enter a valid name';
    }

    if (empty($email)) {
        $errors['email_error'] = 'Please enter your email';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email_error'] = 'Please enter a valid email';
    }

    if (empty($phone)) {
        $errors['phone_error'] = 'Please enter your phone number';
    }

    if (empty($event_type)) {
        $errors['event_type_error'] = 'Please select an event type';
    }

    if (empty($event_date)) {
        $errors['event_date_error'] = 'Please enter the event date';
    }

    if (empty($message)) {
        $errors['message_error'] = 'Please enter additional details or message';
    }

    return $errors;
}

function save_quote_request($user_info)
{
    global $connection;
    return $connection->save('quote_requests', $user_info);
}
?>

<?php include_once '../../includes/header.php'; ?>
<?php include_once '../../includes/nav.php'; ?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Get a Quote</h2>
    <p class="text-center">Fill in the details below and we'll get back to you with a quote for your service request or event.</p>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card border mb-4">
                <div class="card-body">
                    <form action="" method="POST" novalidate>
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($auth_user['name']); ?>" required>
                            <p class="text-danger"><?= $errors['name_error'] ?? "" ?></p>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($auth_user['email']); ?>" required>
                            <p class="text-danger"><?= $errors['email_error'] ?? "" ?></p>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($auth_user['phone']); ?>" required>
                            <p class="text-danger"><?= $errors['phone_error'] ?? "" ?></p>
                        </div>
                        <div class="mb-3">
                            <label for="event_type" class="form-label">Event Type</label>
                            <select id="event_type" name="event_type" class="form-select" required>
                                <option value="">Select a option</option>
                                <option value="Wedding">Wedding</option>
                                <option value="Engagement">Engagement</option>
                                <option value="Birthday">Birthday</option>
                                <option value="Party">Party</option>
                                <option value="Corporate">Corporate</option>
                                <option value="Other">Other</option>
                            </select>
                            <p class="text-danger"><?= $errors['event_type_error'] ?? "" ?></p>
                        </div>
                        <div class="mb-3">
                            <label for="event_date" class="form-label">Event Date</label>
                            <input type="date" id="event_date" name="event_date" class="form-control" required>
                            <p class="text-danger"><?= $errors['event_date_error'] ?? "" ?></p>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Additional Message</label>
                            <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
                            <p class="text-danger"><?= $errors['message_error'] ?? "" ?></p>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-50 text-uppercase">Submit Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once '../../includes/footer.php'; ?>