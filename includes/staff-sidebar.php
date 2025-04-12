<div id="sidebar-wrapper" class="bg-secondary text-white p-3 vh-100">
    <div class="text-center mb-4">
        <img src="<?= ASSETS_PATH . 'images/logo-white.svg' ?>" alt="Dhwani's Salon" height="80" class="my-2" />
    </div>
    <hr class="text-light">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="<?= ROOT . 'staff' ?>" class="nav-link text-white <?= $active === "home" ? "bg-primary" : "" ?>">
                <i class="bi bi-house-door me-2"></i> Home
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= ROOT . 'staff/settings' ?>" class="nav-link text-white <?= $active === "settings" ? "bg-primary" : "" ?>">
                <i class="bi bi-gear me-2"></i> Settings
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= ROOT . 'staff/logout' ?>" class="nav-link text-white">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </li>
    </ul>
</div>

<div id="page-content-wrapper" class="flex-grow-1">
    <nav class="navbar navbar-light bg-white border-bottom px-4 py-3 d-flex justify-content-between">
        <div class="d-flex align-items-center">
            <span class="fw-bold fs-5">Staff Dashboard</span>
        </div>
        <div>
            <span class="text-muted">Welcome, Staff</span>
        </div>
    </nav>