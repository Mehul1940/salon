<style>
    body {
        height: 100vh;
        overflow: hidden;
    }

    main {
        overflow-y: auto;
    }
</style>

<div id="sidebar-wrapper" class="bg-secondary text-white p-3 vh-100">
    <div class="text-center mb-4">
        <img src="<?= ASSETS_PATH . 'images/logo-white.svg' ?>" alt="Dhwani's Salon" height="80" class="my-2" />

    </div>
    <hr class="text-light">
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a href="<?= ROOT . 'admin' ?>" class="nav-link text-white <?= $active === "index" ? "bg-primary" :  "" ?>">
                <i class="bi bi-bar-chart-line me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="<?= ROOT . 'admin/brands' ?>" class="nav-link text-white <?= $active === "brands" ? "bg-primary" :  "" ?>">
                <i class="bi bi-buildings me-2"></i> Manage Brands
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="<?= ROOT . 'admin/categories' ?>" class="nav-link text-white <?= $active === "categories" ? "bg-primary" :  "" ?>">
                <i class="bi bi-tags me-2"></i> Manage Categories
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="<?= ROOT . 'admin/products' ?>" class="nav-link text-white <?= $active === "products" ? "bg-primary" :  "" ?>">
                <i class="bi bi-box-seam me-2"></i> Manage Products
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="<?= ROOT . 'admin/services' ?>" class="nav-link text-white <?= $active === "services" ? "bg-primary" :  "" ?>">
                <i class="bi bi-scissors me-2"></i> Manage Services
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="<?= ROOT . 'admin/staff' ?>" class="nav-link text-white <?= $active === "staff" ? "bg-primary" :  "" ?>">
                <i class="bi bi-person-badge me-2"></i> Manage Staff
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="<?= ROOT . 'admin/orders' ?>" class="nav-link text-white <?= $active === "orders" ? "bg-primary" :  "" ?>">
                <i class="bi bi-cart me-2"></i> Manage Orders
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="<?= ROOT . 'admin/bookings' ?>" class="nav-link text-white <?= $active === "bookings" ? "bg-primary" :  "" ?>">
                <i class="bi bi-calendar me-2"></i> Manage Bookings
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="<?= ROOT . 'admin/membership_plans' ?>" class="nav-link text-white <?= $active === "membership_plans" ? "bg-primary" : "" ?>">
                <i class="bi bi-card-list me-2"></i> Membership Plans
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="<?= ROOT . 'admin/membership' ?>" class="nav-link text-white <?= $active === "memberships" ? "bg-primary" :  "" ?>">
                <i class="bi bi-person-check me-2"></i> Manage Membership
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="<?= ROOT . 'admin/quotes' ?>" class="nav-link text-white <?= $active === "quotes" ? "bg-primary" :  "" ?>">
                <i class="bi bi-chat-left-quote me-2"></i> Manage Quotes
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="<?= ROOT . 'admin/customers' ?>" class="nav-link text-white <?= $active === "customers" ? "bg-primary" :  "" ?>">
                <i class="bi bi-people me-2"></i> View Customers
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="<?= ROOT . 'admin/payments' ?>" class="nav-link text-white <?= $active === "payments" ? "bg-primary" :  "" ?>">
                <i class="bi bi-credit-card me-2"></i> Payment & Billing
            </a>
        </li>
    </ul>

    <hr class="text-light">

    <ul class="nav flex-column mt-auto">
        <li class="nav-item">
            <a href="<?= ROOT . 'admin/settings' ?>" class="nav-link text-white <?= $active === "settings" ? "bg-primary" :  "" ?>">
                <i class="bi bi-gear me-2"></i> Settings
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= ROOT . 'admin/logout' ?>" class="nav-link text-white">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </li>
    </ul>
</div>

<div id="page-content-wrapper" class="flex-grow-1" style="height: 100vh; overflow-y:scroll;">
    <nav class="navbar navbar-light bg-white border-bottom px-4 py-3 d-flex justify-content-between">
        <div class="d-flex align-items-center">
            <span class="fw-bold fs-5">Dashboard</span>
        </div>
        <div>
            <span class="text-muted">Welcome, Admin</span>
        </div>
    </nav>