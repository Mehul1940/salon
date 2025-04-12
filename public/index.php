<?php
include_once "../init.php";

include_once DB_ROOT . 'database.php';


$products = $connection->paginate("products", 4);
$hair_services = $connection->find("services", ["category" => "Hair Services"]);
$beauty_services = $connection->find("services", ["category" => "Beauty Services"]);


?>



<?php include_once '../includes/header.php' ?>
<?php include_once '../includes/nav.php' ?>



<!-- Hero Section -->
<section class="hero-section position-relative">
    <div
        class="hero-image"
        style="
          background-image: url('<?= ASSETS_PATH . 'images/hero.jpg' ?>');
        min-height: 70vh;
        height: 85vh;
        background-size: cover;
        background-position: center; "></div>
    <div
        class=" hero-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center text-center"
        style="background-color: rgba(0, 0, 0, 0.4)">
        <div class="container text-white px-3">
            <h1 class="display-4 fw-bold mb-3 text-white">
                CREATE YOUR OWN<br class="d-none d-md-block" />UNIQUE HAIR STORY
            </h1>
            <p class="lead mb-4">AWARD WINNING HAIR SALON BASED IN AHMEDABAD</p>
            <div
                class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                <a href="shop" class="btn btn-primary px-4 py-2">SHOP NOW</a>
                <a href="<?= ROOT . 'appointment' ?>" class="btn btn-outline-light px-4 py-2">BOOK ONLINE</a>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-5 my-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <img
                            src="<?= ASSETS_PATH . 'images/hair-style.jpg' ?>"
                            alt="Hair styling"
                            class="img-fluid" />
                    </div>
                    <div class="col-md-6 mb-4">
                        <img src="<?= ASSETS_PATH . 'images/hair-wash.jpg' ?>" alt="Hair washing" class="img-fluid" />
                    </div>
                </div>
            </div>
            <div class="col-lg-6 ps-lg-5">
                <h2 class="section-title">WHO WE ARE</h2>
                <p>
                    An award winning Hair Salon based in Ahmedabad. Dhwani's Salon
                    offers a haven of calm and indulgent luxury from salon chair at
                    street-conventional showroom. And lets discover modern decadent
                    salon experience with our premium services and products.
                </p>
                <p>
                    Our team of skilled professionals is dedicated to providing you
                    with the highest quality services using premium products. We
                    believe in creating personalized experiences for each client that
                    walks through our doors.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="feature-icon mb-3">
                    <i class="bi bi-scissors fs-1 text-primary"></i>
                </div>
                <h3 class="h4 mb-3">OUR SALON</h3>
                <p>
                    Experience luxury and relaxation at our state-of-the-art salon in
                    Ahmedabad. Our modern facilities and welcoming atmosphere ensure
                    you feel pampered throughout your visit.
                </p>
                <a href="<?= ROOT . 'appointment' ?>" class="btn btn-primary mt-3">BOOK A SERVICE</a>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="feature-icon mb-3">
                    <i class="bi bi-bag-heart fs-1 text-primary"></i>
                </div>
                <h3 class="h4 mb-3">PREMIUM PRODUCTS</h3>
                <p>
                    We use and sell only the finest hair care and beauty products from
                    internationally renowned brands, ensuring quality results every
                    time.
                </p>
                <a href="<?= ROOT . 'shop' ?>" class="btn btn-primary mt-3">SHOP PRODUCTS</a>
            </div>
            <div class="col-md-4">
                <div class="feature-icon mb-3">
                    <i class="bi bi-gift fs-1 text-primary"></i>
                </div>
                <h3 class="h4 mb-3">MEMBERSHIP BENEFITS</h3>
                <p>
                    Join our exclusive membership program to enjoy special discounts,
                    priority booking, complimentary services, and more exclusive
                    perks.
                </p>
                <a href="<?= ROOT . 'membership' ?>" class="btn btn-primary mt-3">JOIN NOW</a>
            </div>
        </div>
    </div>
</section>

<!-- Location Section -->
<section class="py-5 my-5" id="salon">
    <div class="container">
        <h2 class="section-title text-center mb-5">OUR SALON</h2>
        <div class="row">
            <div class="col-12">
                <div class="card border-0 h-100">
                    <div class="card-img-top">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3674.126087140981!2d72.5967269!3d22.945583100000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e8f003b825c6d%3A0x86cf04a7e7431c51!2sDhwani&#39;s%20salon!5e0!3m2!1sen!2sin!4v1742707384091!5m2!1sen!2sin"
                            width="100%"
                            height="400"
                            style="border: 0"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="card-body p-4 text-center">
                        <h3 class="h4 mb-3">DHWANI'S SALON - AHMEDABAD</h3>
                        <p class="mb-3">
                            SHOP NO.21, OM SHANTI GOLD PLUS, Narolgam, Ahmedabad, Gujarat
                            382440
                        </p>
                        <p class="mb-3">
                            Open Monday-Saturday: 10:00 AM - 8:00 PM | Sunday: 11:00 AM -
                            6:00 PM
                        </p>
                        <a
                            href="https://maps.app.goo.gl/UKaV49pEzfJuR7Hk9?g_st=aw"
                            target="_blank"
                            class="btn btn-primary">
                            GET DIRECTIONS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-5 bg-light" id="services">
    <div class="container">
        <h2 class="section-title text-center mb-5">OUR LADIES SERVICES</h2>
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card border-0 h-100">
                    <div class="card-body p-4">
                        <h3 class="h4 mb-4 text-center">HAIR SERVICES</h3>

                        <?php
                        $hair_services_display = array_slice($hair_services, 0, 5);
                        $total_services = count($hair_services_display);
                        ?>

                        <?php foreach ($hair_services_display as $index => $hair_service): ?>
                            <div class="row mb-3 <?= $index === $total_services - 1 ? '' : 'border-bottom' ?> pb-3">
                                <div class="col-8">
                                    <h4 class="h6 mb-0"><?= $hair_service["name"] ?></h4>
                                    <p class="small text-muted">
                                        <?= $hair_service["description"] ?>
                                    </p>
                                </div>
                                <div class="col-4 text-end">
                                    <p class="mb-0">
                                        ₹<?= number_format($hair_service["min_price"], 0) ?>
                                        - ₹<?= number_format($hair_service["max_price"], 0) ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card border-0 h-100">
                    <div class="card-body p-4">
                        <h3 class="h4 mb-4 text-center">BEAUTY SERVICES</h3>
                        <?php
                        $beauty_services_display = array_slice($beauty_services, 0, 5);
                        $total_services = count($beauty_services_display);
                        ?>

                        <?php foreach ($beauty_services_display as $index => $beauty_service): ?>
                            <div class="row mb-3 <?= $index === $total_services - 1 ? '' : 'border-bottom' ?> pb-3">
                                <div class="col-8">
                                    <h4 class="h6 mb-0"><?= $beauty_service["name"] ?></h4>
                                    <p class="small text-muted">
                                        <?= $beauty_service["description"] ?>
                                    </p>
                                </div>
                                <div class="col-4 text-end">
                                    <p class="mb-0">
                                        ₹<?= number_format($beauty_service["min_price"], 0) ?>
                                        - ₹<?= number_format($beauty_service["max_price"], 0) ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="<?= ROOT . 'request' ?>" class="btn btn-outline-primary px-4 py-2 me-2">REQUEST A QUOTE</a>
            <a href="<?= ROOT . 'appointment' ?>" class="btn btn-primary px-4 py-2">BOOK NOW</a>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-5 my-5" id="products">
    <div class="container">
        <h2 class="section-title text-center mb-5">OUR PRODUCTS</h2>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <?php
                $category = $connection->findById("categories", $product['category_id']);
                $brand = $connection->findById("brands", $product['brand_id']);
                ?>
                <div class="col-md-4 mb-4 d-flex">
                    <div class="card border-0 overflow-hidden h-100 w-100 transition-all transform hover:scale-105 hover:shadow-xl">
                        <img src="<?= ASSETS_PATH . 'images/' . $product['image']; ?>"
                            alt="<?= htmlspecialchars($product['name']); ?>"
                            class="card-img-top img-fluid" style="object-fit: cover; height: 250px;" />
                        <div class="card-body p-4 text-center">
                            <h3 class="h5 mb-2 text-primary"><?= htmlspecialchars($product['name']); ?></h3>
                            <p class="text-muted mb-3"><?= htmlspecialchars($product['description']); ?></p>
                            <p class="fw-bold mb-3 text-dark">₹<?= number_format($product['price'], 2); ?></p>
                            <div class="text-muted mb-3">
                                <strong>Category:</strong> <?= $category ? htmlspecialchars($category['name']) : 'N/A'; ?><br>
                                <strong>Brand:</strong> <?= $brand ? htmlspecialchars($brand['name']) : 'N/A'; ?>
                            </div>
                        </div>
                        <div class="card-footer bg-white text-center border-0">
                            <form action="<?= ROOT . 'cart/add'; ?>" method="GET">
                                <input type="hidden" name="product_id" value="<?= $product['id']; ?>" />
                                <button type="submit" class="text-uppercase btn btn-primary w-100">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>


        </div>
        <div class="text-center mt-4">
            <a href="shop" class="btn btn-outline-primary">SHOP ALL PRODUCTS</a>
        </div>
    </div>
</section>

<section class="bg-light" id="membership">
    <div class="container-fluid p-0">
        <div class="row align-items-center p-0" style="height: 400px;">
            <div class="position-relative overflow-hidden rounded" style="height: 100%; width: 100%;">
                <img src="<?= ASSETS_PATH . 'images/membership-hero.jpg' ?>"
                    alt="Premium Membership Benefits" class="img-fluid rounded" style="height: 100%; width:100%; object-fit: cover;">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center flex-column justify-content-center bg-dark bg-opacity-50">
                    <h2 class="text-white text-uppercase fw-bold text-center px-4 py-3 rounded">
                        JOIN OUR PREMIUM MEMBERSHIP
                    </h2>
                    <div class="d-flex justify-content-center my-3">
                        <a href="<?= ROOT . 'membership-plans' ?>" class="btn btn-primary text-uppercase">
                            Browse Plans
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>



<?php include_once '../includes/footer.php' ?>