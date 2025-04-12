<?php
include_once '../../../../init.php';
include DB_ROOT . 'database.php';
enable_admin_route();

$plan = null;

if (isset($_GET['id'])) {
    $planId = parse_input($_GET['id']);
    $plan = $connection->findById("membership_plans", $planId);

    if (!$plan) {
        redirect("admin/membership_plans");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $name = parse_input($_POST['name']);
    $description = parse_input($_POST['description']);
    $price = parse_input($_POST['price']);
    $order_discount = parse_input($_POST['order_discount']);
    $service_discount = parse_input($_POST['service_discount']);
    $duration = parse_input($_POST['duration']);

    $payment_qr = $plan['payment_qr'];
    if (!empty($_FILES["payment_qr"]["name"])) {
        $targetDir = "../../../assets/images/";
        $qrName = time() . "_" . basename($_FILES["payment_qr"]["name"]);
        $targetFile = $targetDir . $qrName;

        if (move_uploaded_file($_FILES["payment_qr"]["tmp_name"], $targetFile)) {
            $payment_qr = $qrName;
        }
    }

    $result = $connection->update("membership_plans", $plan["id"], [
        "name" => $name,
        "description" => $description,
        "price" => $price,
        "order_discount" => $order_discount,
        "service_discount" => $service_discount,
        "duration" => $duration,
        "payment_qr" => $payment_qr
    ]);

    if ($result) {
        redirect("admin/membership_plans");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $connection->delete("membership_plans",  $planId);
    redirect("admin/membership_plans");
}
?>

<?php include_once '../../../../includes/header.php'; ?>
<div class="d-flex">
    <?php
    $active = "membership_plans";
    include_once '../../../../includes/admin-sidebar.php';
    ?>

    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2><?= $plan ? "Edit Membership Plan" : "Plan Not Found"; ?></h2>
                <?php if ($plan) : ?>
                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this plan?');">
                        <button type="submit" name="delete" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete Plan</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($plan) : ?>
            <div class="card border">
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Plan Name</label>
                                <input type="text" name="name" class="form-control" value="<?= $plan['name']; ?>" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Price (₹)</label>
                                <input type="number" name="price" class="form-control" value="<?= $plan['price']; ?>" required>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" class="form-control" required rows="3"><?= $plan['description']; ?></textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Order Discount (%)</label>
                                <input type="number" name="order_discount" class="form-control" value="<?= $plan['order_discount']; ?>" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Service Discount (%)</label>
                                <input type="number" name="service_discount" class="form-control" value="<?= $plan['service_discount']; ?>" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Duration</label>
                                <select name="duration" class="form-select" required>
                                    <option value="3 months" <?= $plan['duration'] == '3 months' ? 'selected' : ''; ?>>3 months</option>
                                    <option value="6 months" <?= $plan['duration'] == '6 months' ? 'selected' : ''; ?>>6 months</option>
                                    <option value="1 year" <?= $plan['duration'] == '1 year' ? 'selected' : ''; ?>>1 year</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Current Payment QR</label><br>
                                <img src="<?= ASSETS_PATH . 'images/' . $plan['payment_qr']; ?>" alt="Payment QR" class="rounded border img-fluid" style="max-width: 150px;">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-semibold">Upload New QR Code (Optional)</label>
                                <input type="file" name="payment_qr" class="form-control" accept="image/*" id="qrUpload">
                                <div class="mt-2">
                                    <img id="qrPreview" class="rounded border img-fluid d-none" style="max-width: 150px;">
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" name="update" class="btn btn-primary"><i class="fas fa-save"></i> Update Plan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php else : ?>
            <p class="text-danger text-center">Plan not found.</p>
        <?php endif; ?>
    </div>
</div>

<!-- QR Code Preview Script -->
<script>
    document.getElementById("qrUpload").addEventListener("change", function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const qrPreview = document.getElementById("qrPreview");
                qrPreview.src = e.target.result;
                qrPreview.classList.remove("d-none");
            };
            reader.readAsDataURL(file);
        }
    });
</script>

<?php include_once '../../../../includes/admin_footer.php'; ?>