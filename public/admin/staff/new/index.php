<?php
include_once '../../../../init.php';
include DB_ROOT . 'database.php';

enable_admin_route();

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = parse_input($_POST['name']);
    $email = parse_input($_POST['email']);
    $phone = parse_input($_POST['phone']);
    $password = parse_input($_POST['password']);

    $errors = validate_staff_info($connection, $name, $email, $phone, $password);

    if (count($errors) === 0) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $result = $connection->save("users", [
            "name" => $name,
            "email" => $email,
            "phone" => $phone,
            "password" => $hashedPassword,
            "role" => "staff"
        ]);

        if ($result) {
            redirect("admin/staff");
        }
    }
}

function validate_staff_info($connection, $name, $email, $phone, $password)
{
    $errors = [];

    if (empty($name) || strlen($name) < 4) {
        $errors['name_error'] = 'Staff name must be at least 4 characters long';
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email_error'] = 'Please enter a valid email';
    } else {
        $result = $connection->find("users", ['email' => $email]);
        if ($result) $errors['email_error'] = 'Email already exists. Please use another email.';
    }

    if (empty($phone) || !preg_match('/^[0-9]{10}$/', $phone)) {
        $errors['phone_error'] = 'Please enter a valid 10-digit phone number';
    }

    if (empty($password) || strlen($password) < 8) {
        $errors['password_error'] = 'Password must be at least 8 characters long';
    }

    return $errors;
}
?>

<?php include_once '../../../../includes/header.php'; ?>
<div class="d-flex">
    <?php
    $active = "staff";
    include_once '../../../../includes/admin-sidebar.php';
    ?>
    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2>Add New Staff Member</h2>
                <a href="<?= ROOT . 'admin/staff' ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Staff
                </a>
            </div>
        </div>
        <div class="card border">
            <div class="card-body py-5">
                <form action="" method="POST">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" name="name" class="form-control" required>
                            <p class="text-danger fw-semibold"><?= $errors['name_error'] ?? "" ?></p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" required>
                            <p class="text-danger fw-semibold"><?= $errors['email_error'] ?? "" ?></p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" name="phone" class="form-control" required>
                            <p class="text-danger fw-semibold"><?= $errors['phone_error'] ?? "" ?></p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control" required>
                            <p class="text-danger fw-semibold"><?= $errors['password_error'] ?? "" ?></p>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Staff
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once '../../../../includes/admin_footer.php'; ?>