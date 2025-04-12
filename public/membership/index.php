<?php
include_once '../../init.php';
include_once DB_ROOT . 'database.php';

enable_protected_route();

$auth_user = get_auth_user();

$existingRequest = $connection->findOne("membership", ["user_id" => $auth_user["id"]]);

$plans = $connection->findAll("membership_plans");

$plan_id = isset($_GET['plan_id']) ? (int)$_GET['plan_id'] : 0;

if ($plan_id <= 0) {
    redirect("membership-plans");
}

$selectedPlan = $connection->findOne("membership_plans", ["id" => $plan_id]);

if (!$selectedPlan) {
    redirect("membership-plans");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!$existingRequest) {
        if (isset($_FILES['payment_proof'])) {
            $payment_proof = upload_payment_proof($_FILES['payment_proof']);
        }
        $connection->save("membership", [
            "user_id" => $auth_user["id"],
            "status" => "pending",
            "plan_id" => $plan_id,
            "payment_proof" => $payment_proof ?? null,
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s")
        ]);
    } else {
        $connection->update("membership", $existingRequest["id"], [
            "status" => "pending",
            "plan_id" => $plan_id,
            "updated_at" => date("Y-m-d H:i:s")
        ]);
    }
    redirect("membership?plan_id=" . $plan_id);
}

function upload_payment_proof($file)
{
    $targetDir = "../assets/images/";

    $timestamp = time();
    $originalName = basename($file["name"]);
    $newFileName = $timestamp . "_" . $originalName;

    $targetFile = $targetDir . $newFileName;

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $newFileName;
    }

    return false;
}

?>

<?php include_once '../../includes/header.php'; ?>
<?php include_once '../../includes/nav.php'; ?>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <?php if ($existingRequest): ?>
        <?php if ($existingRequest['status'] == 'approved'): ?>
            <div class="card p-4 text-center" style="max-width: 500px; width: 100%;">
                <div class="badge bg-success text-uppercase py-3 px-3 mb-3">Your Membership</div>
                <h2 class="mb-2"><?= htmlspecialchars($selectedPlan['name']); ?></h2>
                <h3 class="fw-bold text-primary mb-4">₹<?= number_format($selectedPlan['price'], 2); ?> / <?= $selectedPlan['duration']; ?></h3>

                <ul class="list-unstyled text-start mx-auto" style="max-width: 350px;">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> <?= $selectedPlan['order_discount']; ?>% off all products</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> <?= $selectedPlan['service_discount']; ?>% off all services</li>
                </ul>

                <div class="alert alert-success">
                    <strong>Status: Approved!</strong>
                    <p>Your membership has been approved! Enjoy all the benefits.</p>
                </div>
            </div>
        <?php elseif ($existingRequest['status'] == 'pending'): ?>
            <div class="card p-4 text-center" style="max-width: 500px; width: 100%;">
                <div class="badge bg-secondary text-uppercase py-3 px-3 mb-3">Your Membership</div>
                <h2 class="mb-2"><?= htmlspecialchars($selectedPlan['name']); ?></h2>
                <h3 class="fw-bold text-primary mb-4">₹<?= number_format($selectedPlan['price'], 2); ?> / <?= $selectedPlan['duration']; ?></h3>

                <ul class="list-unstyled text-start mx-auto" style="max-width: 350px;">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> <?= $selectedPlan['order_discount']; ?>% off all products</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> <?= $selectedPlan['service_discount']; ?>% off all services</li>
                </ul>

                <div class="alert alert-info">
                    <strong>Status: Pending!</strong>
                    <p>Your membership is currently under review. You will be notified once a decision is made.</p>
                </div>
            </div>
        <?php elseif ($existingRequest['status'] == 'expired' || $existingRequest['status'] == 'rejected'): ?>
            <div class="card p-4 text-center" style="max-width: 500px; width: 100%;">
                <div class="badge bg-danger text-uppercase py-3 px-3 mb-3">
                    <?= $existingRequest['status'] == 'expired' ? 'Expired Membership' : 'Rejected Membership'; ?>
                </div>
                <h2 class="mb-2"><?= htmlspecialchars($selectedPlan['name']); ?></h2>
                <h3 class="fw-bold text-primary mb-4">₹<?= number_format($selectedPlan['price'], 2); ?> / <?= $selectedPlan['duration']; ?></h3>

                <ul class="list-unstyled text-start mx-auto" style="max-width: 350px;">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> <?= $selectedPlan['order_discount']; ?>% off all products</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> <?= $selectedPlan['service_discount']; ?>% off all services</li>
                </ul>

                <div class="d-flex justify-content-center">
                    <img src="<?= ASSETS_PATH . 'images/' . $selectedPlan['payment_qr']; ?>" alt="Payment QR" class="img-fluid mb-4" width="300" />
                </div>


                <div class="alert alert-warning">
                    <strong>Status: <?= ucfirst($existingRequest['status']); ?>!</strong>
                    <p>Your membership has been <?= $existingRequest['status'] == 'expired' ? 'expired' : 'rejected'; ?>. You may submit a new request.</p>
                </div>



                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="payment_proof" class="form-label">Upload Payment Proof (Screenshot/QR Code)</label>
                        <input type="file" class="form-control" id="payment_proof" name="payment_proof" required>
                    </div>
                    <button type="submit" class="btn btn-primary text-uppercase w-100">Reapply Now</button>
                </form>
            </div>
        <?php elseif ($existingRequest['status'] == 'suspended'): ?>
            <div class="card p-4 text-center" style="max-width: 500px; width: 100%;">
                <div class="badge bg-warning text-uppercase py-3 px-3 mb-3">Suspended Membership</div>
                <h2 class="mb-2"><?= htmlspecialchars($selectedPlan['name']); ?></h2>
                <h3 class="fw-bold text-primary mb-4">₹<?= number_format($selectedPlan['price'], 2); ?> / <?= $selectedPlan['duration']; ?></h3>

                <ul class="list-unstyled text-start mx-auto" style="max-width: 350px;">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> <?= $selectedPlan['order_discount']; ?>% off all products</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> <?= $selectedPlan['service_discount']; ?>% off all services</li>
                </ul>

                <div class="alert alert-danger">
                    <strong>Status: Suspended!</strong>
                    <p>Your membership has been suspended. Please contact support.</p>
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="card p-4 text-center" style="max-width: 500px; width: 100%;">
            <div class="badge bg-secondary text-uppercase py-3 px-3 mb-3">Exclusive Benefits</div>
            <h2 class="mb-2"><?= htmlspecialchars($selectedPlan['name']); ?></h2>
            <h3 class="fw-bold text-primary mb-4">₹<?= number_format($selectedPlan['price'], 2); ?> / <?= $selectedPlan['duration']; ?></h3>

            <ul class="list-unstyled text-start mx-auto" style="max-width: 350px;">
                <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> <?= $selectedPlan['order_discount']; ?>% off all products</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> <?= $selectedPlan['service_discount']; ?>% off all services</li>
            </ul>

            <div class="d-flex justify-content-center">
                <img src="<?= ASSETS_PATH . 'images/' . $selectedPlan['payment_qr']; ?>" alt="Payment QR" class="img-fluid mb-4" width="300" />
            </div>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="payment_proof" class="form-label">Upload Payment Proof (Screenshot/QR Code)</label>
                    <input type="file" class="form-control" id="payment_proof" name="payment_proof" required>
                </div>
                <button type="submit" class="btn btn-primary text-uppercase w-100">Join Now</button>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php include_once '../../includes/footer.php'; ?>