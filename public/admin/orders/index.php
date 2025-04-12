<?php
include_once '../../../init.php';
include DB_ROOT . 'database.php';
enable_admin_route();

$orders = $connection->findAll("orders");

?>

<?php include_once '../../../includes/header.php'; ?>
<div class="d-flex">
    <?php
    $active = "orders";
    include_once '../../../includes/admin-sidebar.php';
    ?>
    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="section-title">Orders</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#printModal">
                    <i class="bi bi-printer"></i> Print Report
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive" id="printable">
                    <a class="justify-content-center mb-2 d-none" href="<?= ROOT ?>" id="print-logo">
                        <img src="<?= ASSETS_PATH . 'images/logo.svg' ?>" alt="Dhwani's Salon" height="50" />
                    </a>
                    <h2 class="text-center text-uppercase mb-3 d-none" id="print-heading">Order Report</h2>
                    <table class="table table-hover">
                        <thead class="bg-secondary">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th class="print-hide">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orders)): ?>
                                <?php foreach ($orders as $index => $order) : ?>
                                    <?php
                                    $customer = $connection->findById("users", $order["user_id"]);

                                    $status_classes = [
                                        "pending" => "bg-secondary",
                                        "processing" => "bg-info",
                                        "completed" => "bg-success",
                                        "cancelled" => "bg-danger"
                                    ];
                                    $status_badge = $status_classes[$order["status"]] ?? "bg-secondary";
                                    ?>
                                    <tr class="text-center" data-date="<?= date('Y-m', strtotime($order['created_at'])); ?>">
                                        <td><?= $order['id']; ?></td>
                                        <td><?= $customer ? $customer['name'] : 'N/A'; ?></td>
                                        <td><?= date('d M Y, h:i A', strtotime($order['created_at'])); ?></td>
                                        <td>₹<?= number_format($order['total_amount'], 2); ?></td>
                                        <td><span class="badge text-uppercase <?= $status_badge; ?>"><?= ucfirst($order['status']); ?></span></td>
                                        <td class="print-hide">
                                            <a href="view?id=<?= $order['id']; ?>" class="fw-semibold btn btn-sm btn-primary text-uppercase">
                                                View <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No orders found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Modal -->
<div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printModalLabel">Generate Orders Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="printForm">
                    <div class="mb-3">
                        <label for="month" class="form-label">Select Month</label>
                        <select id="month" class="form-select">
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Select Year</label>
                        <input type="number" id="year" class="form-control" min="2000" max="2099" value="<?= date('Y'); ?>">
                    </div>
                    <button type="button" class="btn btn-primary w-100" onclick="printReport()">Generate Report</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function printReport() {
        var month = document.getElementById("month").value;
        var year = document.getElementById("year").value;
        var selectedDate = year + "-" + month;

        var rows = document.querySelectorAll("#printable tbody tr");
        rows.forEach(row => {
            if (row.dataset.date) {
                row.style.display = row.dataset.date === selectedDate ? "" : "none";
            }
        });

        var style = document.createElement("style");
        style.innerHTML = `
                            @media print {
                                body * { visibility: hidden; }
                                #printable, #printable * { visibility: visible; }
                                #printable { position: absolute; left: 0; top: 0; width: 100%; }
                                #print-logo, #print-heading { display: flex !important; justify-content: center; }
                                .print-hide { display: none; }
                            }
                        `;
        document.head.appendChild(style);

        window.print();

        document.head.removeChild(style);
        rows.forEach(row => row.style.display = "");
    }
</script>

<?php include_once '../../../includes/admin_footer.php'; ?>