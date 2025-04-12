<?php
include_once "../../../init.php";
include_once DB_ROOT . 'database.php';

enable_protected_route();


$errors = [];
$user_info = [];
$auth_user = get_auth_user();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_info["password"] = password_hash(parse_input($_POST["new_password"]), PASSWORD_DEFAULT);

    $errors = validate_password();

    if (count($errors) === 0) {
        $connection->update("users", $auth_user["id"], $user_info);
        show_alert("Password updated!");
    }
}

function validate_password()
{
    global $auth_user;
    $errors = [];

    $current_password =  parse_input($_POST["current_password"]);
    $new_password =  parse_input($_POST["new_password"]);
    $confirm_password =  parse_input($_POST["confirm_password"]);

    if (!password_verify($current_password, $auth_user["password"])) {
        $errors["current_password"] = "Current password is incorrect.";
    }

    if (empty($new_password)) {
        $errors["new_password"] = "New password is required.";
    } elseif (strlen($new_password) < 8) {
        $errors["new_password"] = "Password must be at least 8 characters long.";
    }

    if ($new_password !== $confirm_password) {
        $errors["confirm_password"] = "Passwords do not match.";
    }

    return $errors;
}

?>


<?php include_once '../../../includes/header.php' ?>
<?php include_once '../../../includes/nav.php' ?>
<div class="container py-5">
    <div class="row">
        <?php $active = "change-password";
        include_once '../../../includes/user_sidebar.php' ?>
        <div class="col-md-9">
            <div class="profile-content bg-white p-4 rounded border">
                <h3 class="mb-4">Change Password</h3>
                <form method="POST" novalidate>
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" placeholder="Enter current password" name="current_password" required>
                        <p class="text-danger fw-semibold"><?= $errors['current_password'] ?? "" ?></p>
                    </div>

                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" placeholder="Enter new password" name="new_password" required>
                        <p class="text-danger fw-semibold"><?= $errors['new_password'] ?? "" ?></p>
                    </div>

                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password" name="confirm_password" required>
                        <p class="text-danger fw-semibold"><?= $errors['confirm_password'] ?? "" ?></p>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once '../../../includes/footer.php' ?>