<?php
include_once '../../init.php';
include_once DB_ROOT . 'database.php';

$plans = $connection->findAll("membership_plans");

include_once '../../includes/header.php';
include_once '../../includes/nav.php';
?>

<section class="bg-light py-5" id="membership-plans">
    <div class="container">
        <h3 class="text-center py-5 text-uppercase">Our Membership Plans</h3>
        <div class="row g-4">
            <?php foreach ($plans as $plan): ?>
                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="card border-0 rounded-lg h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <span class="badge bg-primary fs-6 mb-3 px-3 py-2">EXCLUSIVE BENEFITS</span>
                            <h4 class="fw-bold text-uppercase text-dark"><?= htmlspecialchars($plan['name']); ?></h4>
                            <p class="fs-4 fw-bold text-primary mt-2">₹<?= number_format($plan['price'], 2); ?> / <?= $plan['duration']; ?></p>

                            <ul class="list-unstyled my-4">
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                    <strong><?= $plan['order_discount']; ?>% off</strong> all products
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                    <strong><?= $plan['service_discount']; ?>% off</strong> all services
                                </li>
                            </ul>

                            <a href="<?= ROOT . 'membership?plan_id=' . $plan["id"] ?>" class="btn btn-primary py-3 text-uppercase w-100 mt-auto">
                                JOIN NOW
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
include_once '../../includes/footer.php';
?>