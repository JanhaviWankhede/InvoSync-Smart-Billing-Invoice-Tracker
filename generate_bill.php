<?php 
include 'database.php';

if (isset($_GET['invoice_no'])) {
    $invoice_no = $_GET['invoice_no'];

    // Fetch invoice details from invoice_master
    $query = "SELECT * FROM invoice_master WHERE invoice_no = :invoice_no";
    $stmt = $conn->prepare($query);
    $stmt->execute([':invoice_no' => $invoice_no]);
    $invoice = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch product details from invoice_details
    $query = "SELECT * FROM invoice_details WHERE invoice_no = :invoice_no";
    $stmt = $conn->prepare($query);
    $stmt->execute([':invoice_no' => $invoice_no]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Invoice - <?= htmlspecialchars($invoice['invoice_no']); ?></title>
    <link rel="stylesheet" href="../assets/styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <!-- <style>
    @media print {
        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        a[href]:after {
            content: none !important; /* Hides the URL of links */
        }
        button {
            display: none !important; /* Hides the print and export buttons */
        }
    }
</style> -->

    
    <style>
        /* Hide buttons when printing */
        @media print {
            #printBtn, #exportToExcel {
                display: none;
            }
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a[href]:after {
        content: none !important; /* Hides link URLs */
    }
    </style>
</head>
<body>

    <div id="invoice">
        <h1>Invoice - <?= htmlspecialchars($invoice['invoice_no']); ?></h1>
        <p><strong>Customer:</strong> <?= htmlspecialchars($invoice['customer_name']); ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($invoice['customer_address']); ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($invoice['customer_phone']); ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($invoice['invoice_date']); ?></p>
        <p><strong>Due Date:</strong> <?= htmlspecialchars($invoice['due_date']); ?></p>

        <table  cellpadding="5" cellspacing="0" style="width: 600px; margin: left; font-size: 14px;">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>HSN/SAC</th>
                    <th>Quantity</th>
                    <th>Unit Cost</th>
                    <th>Total Cost</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) { ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product_title']); ?></td>
                        <td><?= htmlspecialchars($item['hsn_sac']); ?></td>
                        <td><?= htmlspecialchars($item['quantity']); ?></td>
                        <td><?= htmlspecialchars($item['unit_cost']); ?></td>
                        <td><?= htmlspecialchars($item['total_cost']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3>Total Amount: <?= htmlspecialchars($invoice['total_amount']); ?></h3>
    </div>

    <!-- Buttons (Hidden When Printing) -->
    <button id="printBtn" onclick="window.print()">🖨 Print</button>
    <button id="exportToExcel">📂 Save as Excel</button>

    <script>
        document.getElementById("exportToExcel").addEventListener("click", function() {
            let table = document.querySelector("table");
            let wb = XLSX.utils.table_to_book(table, {sheet: "Invoice"});
            XLSX.writeFile(wb, "Invoice_<?= htmlspecialchars($invoice_no); ?>.xlsx");
        });
    </script>

</body>
</html>