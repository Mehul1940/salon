<?php
include_once '../../init.php';
include_once DB_ROOT . 'database.php';

enable_unprotected_route();

$errors = [];
$user_info = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = validate_user_info();
    $user_info["email"] = parse_input($_POST["email"]);
    $user_info["password"] = parse_input($_POST["password"]);

    if (count($errors) === 0) {
        $users = $connection->find("users", ["email" => $user_info["email"]]);

        if (count($users) === 0) {
            show_alert("Invalid email or password");
        } else {
            $user = $users[0];

            if (!password_verify($user_info["password"], $user["password"])) {
                show_alert("Invalid email or password");
            } else {
                login($user);
                redirect("");
            }
        }
    }
}

function validate_user_info()
{
    $errors = [];

    if (empty($_POST['email'])) {
        $errors['email_error'] = 'Please enter your email';
    }

    if (empty($_POST['password'])) {
        $errors['password_error'] = 'Please enter your password';
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
                        <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password" required>
                    </div>
                    <p class="text-danger fw-semibold"><?= $errors['password_error'] ?? "" ?></p>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <a href="<?= ROOT . '/forgot-password' ?>" class="text-decoration-none text-primary">Forgot password?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3 text-uppercase">Sign In</button>
            </form>

            <div class="auth-footer text-center">
                <p>Don't have an account? <a href="<?= ROOT . '/register' ?>" class="text-primary">Sign up</a></p>
            </div>
        </div>
    </div>
</div>
<?php include_once "../../includes/admin_footer.php" ?>