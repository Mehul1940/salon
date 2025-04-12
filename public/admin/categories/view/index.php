<?php
include_once '../../../../init.php';
include DB_ROOT . 'database.php';

$category = null;

if (isset($_GET['id'])) {
    $categoryId = parse_input($_GET['id']);
    $category = $connection->findById("categories", $categoryId);

    if (!$category) {
        redirect("admin/categories");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $name = parse_input($_POST['name']);

    $result = $connection->update("categories", $category["id"], [
        "name" => $name
    ]);

    if ($result) {
        redirect("admin/categories");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $connection->delete("categories", $categoryId);
    redirect("admin/categories");
}
?>

<?php include_once '../../../../includes/header.php'; ?>
<div class="d-flex">
    <?php
    $active = "categories";
    include_once '../../../../includes/admin-sidebar.php';
    ?>
    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between">
                <h2 class="section-title"><?= $category ? "Edit Category" : "Category Not Found"; ?></h2>
                <?php if ($category) : ?>
                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                        <button type="submit" name="delete" class="fw-semibold btn btn-danger">Delete Category</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($category) : ?>
            <form action="" method="POST">
                <div class="row">
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="name" class="form-control" value="<?= $category['name']; ?>" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" name="update" class="btn btn-primary">Update Category</button>
                    </div>
                </div>
            </form>
        <?php else : ?>
            <p class="text-danger">Category not found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include_once '../../../../includes/admin_footer.php'; ?>