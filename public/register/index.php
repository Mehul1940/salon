<?php
include_once '../../init.php';
include_once DB_ROOT . 'database.php';

enable_unprotected_route();

$errors = [];
$user_info = [];



if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $errors = validate_user_info($connection);

    $user_info["name"] = parse_input($_POST["name"]);
    $user_info["email"] = parse_input($_POST["email"]);
    $user_info["password"] = password_hash(parse_input($_POST["password1"]), PASSWORD_DEFAULT);


    if (count($errors) === 0) {


        $user_info['profile_pic'] = 'default-profile.png';
        $user_info['role'] = 'customer';
        $result  = $connection->save('users', $user_info);

        if ($result) {
            redirect("login");
        }
    }
}

function validate_user_info($connection)
{
    $errors = [];

    $name = parse_input($_POST["name"]);
    $email = parse_input($_POST["email"]);
    $password1 = parse_input($_POST["password1"]);
    $password2 = parse_input($_POST["password2"]);

    if (empty($name)) {
        $errors['name_error'] = 'Please enter your name';
    } else if (strlen($name) < 4) {
        $errors['name_error'] = 'Please enter a valid name';
    }

    if (empty($email)) {
        $errors['email_error'] = 'Please enter your email';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email_error'] = 'Please enter valid email';
    } else {
        $result = $connection->find("users", ['email' => $email]);

        if (count($result) !== 0) $errors['email_error'] = 'Email already exits. Please login';
    }

    if (empty($password1)) {
        $errors['password1_error'] = 'Please enter your password';
    } else if (strlen($password1) < 8) {
        $errors['password1_error'] = 'Password must be 8 characters long';
    }

    if (empty($password2)) {
        $errors['password2_error'] = 'Please confirm your password';
    } else if ($password1 !== $password2) {
        $errors['password2_error'] = 'Confirm password does not match';
    }

    return $errors;
}
?>

<?php include_once "../../includes/header.php" ?>
<div class="d-flex vh-100">
    <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center p-5 auth-image" style="background: linear-gradient(rgba(0,0,0,.2), rgba(0,0,0,.2)), url('<?= ASSETS_PATH . 'images/auth-hero.jpg' ?>') no-repeat center center; background-size: cover; height: 100vh;">
        <div class="text-white text-center">
            <h1 class="display-5 fw-bold mb-3 text-white text-uppercase">
                Welcome to Dhwani's Salon
            </h1>
            <p class="lead">Your beauty, our passion. Experience the best salon services with us.</p>
        </div>
    </div>

    <div class="col-md-6 auth-form-container d-flex align-items-center justify-content-center p-5" style="height: 100vh;">
        <div class="p-4 rounded bg-white w-100" style="max-width: 450px;">
            <div class="text-center mb-4">
                <img src="<?= ASSETS_PATH . 'images/logo.svg' ?>" alt="Dhwani's Salon" height="80" />
            </div>

            <form method="POST" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="name" placeholder="Enter your full name" name="name" required>
                    </div>
                    <p class="text-danger fw-semibold"><?= $errors['name_error'] ?? "" ?></p>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email" required>
                    </div>
                    <p class="text-danger fw-semibold"><?= $errors['email_error'] ?? "" ?></p>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                        <input type="password" class="form-control" id="password" placeholder="Create a password" name="password1" required>
                    </div>
                    <p class="text-danger fw-semibold"><?= $errors['password1_error'] ?? "" ?></p>
                </div>

                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                        <input type="password" class="form-control" id="confirm-password" placeholder="Confirm your password" name="password2" required>
                    </div>
                    <p class="text-danger fw-semibold"><?= $errors['password2_error'] ?? "" ?></p>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3 text-uppercase">Sign Up</button>
            </form>

            <div class="auth-footer text-center">
                <p>Already have an account? <a href="<?= ROOT . '/login' ?>" class="text-primary">Sign in</a></p>
            </div>
        </div>
    </div>
</div>
<?php include_once "../../includes/footer.php" ?>