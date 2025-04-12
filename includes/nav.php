<?php

$user = get_auth_user();
?>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand" href="<?= ROOT ?>">
            <img src="<?= ASSETS_PATH . 'images/logo.svg' ?>" alt="Dhwani's Salon" height="50" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link active" href="<?= ROOT ?>">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= ROOT . '#salon' ?>">OUR SALON</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= ROOT . '#services' ?>">SERVICES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= ROOT . '#products' ?>">PRODUCTS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= ROOT . '#membership' ?>">MEMBERSHIP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="<?= ROOT . 'cart' ?>">
                        <i class="bi bi-cart fs-4"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="<?= ROOT . 'profile' ?>">
                        <i class="bi bi-person fs-4"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<main style="overflow-x: hidden;">