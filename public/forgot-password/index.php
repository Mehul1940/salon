<?php
include_once '../../init.php';
include_once DB_ROOT . 'database.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = parse_input($_POST["email"]);

    $user = $connection->findOne("users", ["email" => $email]);

    if (!$user) {
        show_alert("No account found");
    } else {
        $token = bin2hex(random_bytes(32));

        $connection->update("users", $user['id'], [
            "token" => $token,
        ]);

        $reset_link =  "http://localhost/$PROJECT_NAME/reset-password?token=$token";
        $subject = "Password Reset Request";
        $message = "<p>Hello,</p>
                        <p>You requested a password reset. Click the link below to reset your password:</p>
                        <p><a href='$reset_link'>Reset Password</a></p>";

        $email_sent = sendEmail($email, $subject, $message);

        if ($email_sent) {
            show_alert("A password reset link has been sent to your email.");
        } else {
            show_alert("Failed to send email. Try again later.");
        }
    }
}



?>

<?php include_once "../../includes/header.php" ?>
<div class="d-flex vh-100">
    <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center p-5 auth-image" style="background: linear-gradient(rgba(0,0,0,.2), rgba(0,0,0,.2)), url('<?= ASSETS_PATH . 'images/auth-hero.jpg' ?>') no-repeat center center; background-size: cover; height: 100vh;">
        <div class="text-white text-center">
            <h1 class="display-5 fw-bold mb-3 text-white text-uppercase">
                Reset Your Password
            </h1>
            <p class="lead">Enter your email to receive password reset instructions.</p>
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

                <button type="submit" class="btn btn-primary w-100 mb-3 text-uppercase">Send Reset Link</button>
            </form>

            <div class="auth-footer text-center">
                <p>Remember your password? <a href="<?= ROOT . '/login' ?>" class="text-primary">Sign in</a></p>
            </div>
        </div>
    </div>
</div>
<?php include_once "../../includes/footer.php" ?>