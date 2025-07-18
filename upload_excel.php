<?php
include 'database.php';
require 'vendor/autoload.php'; // Include PHPSpreadsheet library

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['excel_file'])) {
    $file = $_FILES['excel_file']['tmp_name'];

    $spreadsheet = IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();
    $data = $worksheet->toArray();

    $invoiceNumbers = [];
    $serialNumbers = [];

    foreach ($data as $row) {
        if (!empty($row[0])) {
            $invoiceNumbers[] = $row[0]; // Assuming invoice number is in column A
        }
        if (!empty($row[1])) {
            $serialNumbers[] = $row[1]; // Assuming serial number is in column B
        }
    }

    if (!empty($invoiceNumbers)) {
        $placeholders = implode(',', array_fill(0, count($invoiceNumbers), '?'));
        $stmt = $conn->prepare("SELECT invoice_no, customer_name, invoice_date, total_amount FROM invoice_master WHERE invoice_no IN ($placeholders)");
        $stmt->execute($invoiceNumbers);
        $invoiceResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    if (!empty($serialNumbers)) {
        $placeholders = implode(',', array_fill(0, count($serialNumbers), '?'));
        $stmt = $conn->prepare("SELECT invoice_no, product_title, product_serial_no, unit_cost FROM invoice_details WHERE product_serial_no IN ($placeholders)");
        $stmt->execute($serialNumbers);
        $serialResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload Invoice Excel</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>

<h2>Invoice Summary</h2>
<table border="1">
    <tr>
        <th>Invoice No</th>
        <th>Customer Name</th>
        <th>Invoice Date</th>
        <th>Total Amount</th>
        <th>Action</th>
    </tr>
    <?php if (!empty($invoiceResults)) { ?>
        <?php foreach ($invoiceResults as $invoice) { ?>
            <tr>
                <td><?= $invoice['invoice_no']; ?></td>
                <td><?= $invoice['customer_name']; ?></td>
                <td><?= $invoice['invoice_date']; ?></td>
                <td><?= $invoice['total_amount']; ?></td>
                <td>
                    <a href="generate_bill.php?invoice_no=<?= $invoice['invoice_no']; ?>">
                        <button>Generate Bill</button>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr><td colspan="5">No invoices found.</td></tr>
    <?php } ?>
</table>

<h2>Serial Number Details</h2>
<table border="1">
    <tr>
        <th>Serial Number</th>
        <th>Invoice No</th>
        <th>Product Name</th>
        <th>Unit price</th>
        <th>Action</th>
    </tr>
    <?php if (!empty($serialResults)) { ?>
        <?php foreach ($serialResults as $serial) { ?>
            <tr>
                <td><?= $serial['product_serial_no']; ?></td>
                <td><?= $serial['invoice_no']; ?></td>
                <td><?= $serial['product_title']; ?></td>
                <td><?= $serial['unit_cost']; ?></td>
                <td>
                    <a href="generate_bill.php?invoice_no=<?= $invoice['invoice_no']; ?>">
                        <button>Generate Bill</button>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr><td colspan="3">No serial numbers found.</td></tr>
    <?php } ?>
</table>

</body>
</html>
