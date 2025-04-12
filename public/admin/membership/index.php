<?php
include_once '../../../init.php';
include DB_ROOT . 'database.php';
enable_admin_route();

$memberships = $connection->findAll("membership");

?>

<?php include_once '../../../includes/header.php'; ?>
<div class="d-flex">
  <?php
  $active = "memberships";
  include_once '../../../includes/admin-sidebar.php';
  ?>
  <div class="container-fluid px-4 py-4">
    <div class="row mb-4">
      <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="section-title">Membership Requests</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="table-responsive" id="printable">
          <table class="table table-hover">
            <thead class="bg-secondary">
              <tr class="text-center">
                <th>#</th>
                <th>Customer</th>
                <th>Request Date</th>
                <th>Status</th>
                <th>Expiry Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($memberships)): ?>
                <?php foreach ($memberships as $index => $membership) : ?>
                  <?php
                  $customer = $connection->findById("users", $membership["user_id"]);

                  $status_classes = [
                    "pending" => "bg-secondary",
                    "approved" => "bg-success",
                    "rejected" => "bg-danger",
                    "expired" => "bg-warning",
                    "suspended" => "bg-dark"
                  ];
                  $status_badge = $status_classes[$membership["status"]] ?? "bg-secondary";
                  ?>
                  <tr class="text-center">
                    <td><?= $membership['id']; ?></td>
                    <td><?= $customer ? $customer['name'] : 'N/A'; ?></td>
                    <td><?= date('d M Y, h:i A', strtotime($membership['request_date'])); ?></td>
                    <td><span class="badge text-uppercase <?= $status_badge; ?>"><?= ucfirst($membership['status']); ?></span></td>
                    <td><?= $membership['expiry_date'] ? $membership['expiry_date'] : 'N/A'; ?></td>
                    <td>
                      <a href="view?id=<?= $membership['id']; ?>" class="fw-semibold btn btn-sm btn-primary text-uppercase">
                        View <i class="bi bi-arrow-right"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center">No membership requests found</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once '../../../includes/admin_footer.php'; ?>