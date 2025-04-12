<?php
include_once '../../../init.php';
include DB_ROOT . 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = parse_input($_POST['email']);
    $password = parse_input($_POST['password']);

    if (empty($email) || empty($password)) {
        show_alert("Please enter both email and password.");
    } else {
        $admin = $connection->findOne("users", ["email" => $email, "role" => "admin"]);
        if ($admin && password_verify($password, $admin["password"])) {
            login($admin);
            redirect("admin");
        } else {
            show_alert("Invalid email or password.");
        }
    }
}
?>

<?php include_once "../../../includes/header.php" ?>

<div class="d-flex vh-100">
    <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center p-5 auth-image"
        style="background: linear-gradient(rgba(0,0,0,.3), rgba(0,0,0,.3)), url('<?= ASSETS_PATH . 'images/auth-hero.jpg' ?>') no-repeat center center; 
               background-size: cover; height: 100vh;">
        <div class="text-white text-center">
            <h1 class="display-5 fw-bold mb-3 text-uppercase text-white">Admin Panel</h1>
            <p class="lead">Manage Dhwani's Salon services efficiently and effortlessly.</p>
        </div>
    </div>

    <div class="col-md-6 auth-form-container d-flex align-items-center justify-content-center p-5"
        style="height: 100vh;">
        <div class="p-4 rounded bg-white w-100" style="max-width: 450px;">
            <div class="text-center mb-4">
                <img src="<?= ASSETS_PATH . 'images/logo.svg' ?>" alt="Dhwani's Salon Admin" height="80" />
            </div>

            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control" id="email" placeholder="admin@example.com" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3 text-uppercase">Sign In</button>
            </form>

            <div class="text-center">
                <p><a href="<?= ROOT . '/forgot-password' ?>" class="text-decoration-none text-primary">Forgot password?</a></p>
            </div>
        </div>
    </div>
</div>

<?php include_once "../../../includes/admin_footer.php" ?>