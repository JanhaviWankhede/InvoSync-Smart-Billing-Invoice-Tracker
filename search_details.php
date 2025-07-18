<?php 
include 'database.php';

$query = "SELECT * FROM invoice_master WHERE 1=1"; // Base query
$params = [];

// Initialize input values to retain user input
$invoice_no = $_GET['invoice_no'] ?? '';
$invoice_start = $_GET['invoice_start'] ?? '';
$invoice_end = $_GET['invoice_end'] ?? '';
$product_serial_no = $_GET['product_serial_no'] ?? '';
$serial_start = $_GET['serial_start'] ?? '';
$serial_end = $_GET['serial_end'] ?? '';
$customer_name = $_GET['customer_name'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
$payment_mode = $_GET['payment_mode'] ?? '';

// ✅ Search by multiple invoice numbers (comma-separated)
if (!empty($invoice_no)) {
    $invoiceNumbers = explode(',', str_replace(' ', '', $invoice_no)); // Remove spaces and split by comma
    $placeholders = implode(',', array_fill(0, count($invoiceNumbers), '?'));
    $query .= " AND invoice_no IN ($placeholders)";
    $params = array_merge($params, $invoiceNumbers);
}

// ✅ Search by invoice number range
if (!empty($invoice_start) && !empty($invoice_end)) {
    $query .= " AND invoice_no BETWEEN ? AND ?";
    array_push($params, $invoice_start, $invoice_end);
}

// ✅ Search by multiple product serial numbers (comma-separated)
if (!empty($product_serial_no)) {
    $serialNumbers = explode(',', str_replace(' ', '', $product_serial_no));
    $placeholders = implode(',', array_fill(0, count($serialNumbers), '?'));
    $query .= " AND invoice_id IN (SELECT invoice_id FROM invoice_details WHERE product_serial_no IN ($placeholders))";
    $params = array_merge($params, $serialNumbers);
}

// ✅ Search by product serial number range
if (!empty($serial_start) && !empty($serial_end)) {
    $query .= " AND invoice_id IN (
        SELECT invoice_id FROM invoice_details 
        WHERE product_serial_no BETWEEN ? AND ?
    )";
    array_push($params, $serial_start, $serial_end);
}

// ✅ Search by customer name
if (!empty($customer_name)) {
    $query .= " AND customer_name LIKE ?";
    $params[] = "%" . $customer_name . "%";
}

// ✅ Search by invoice date range
if (!empty($start_date) && !empty($end_date)) {
    $query .= " AND invoice_date BETWEEN ? AND ?";
    array_push($params, $start_date, $end_date);
}

// ✅ Search by payment mode
if (!empty($payment_mode)) { 
    $query .= " AND payment_mode = ?";
    $params[] = $payment_mode;
}

$stmt = $conn->prepare($query);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Invoices</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <h2>Search Invoices</h2>

    <form method="GET">
        <label>Invoice Numbers (Comma-Separated):</label>
        <input type="text" name="invoice_no" value="<?= htmlspecialchars($invoice_no); ?>">

        <label>Invoice Number Range:</label>
        <input type="text" name="invoice_start" placeholder="Start Invoice No" value="<?= htmlspecialchars($invoice_start); ?>">
        <input type="text" name="invoice_end" placeholder="End Invoice No" value="<?= htmlspecialchars($invoice_end); ?>">

        <label>Product Serial Numbers (Comma-Separated):</label>
        <input type="text" name="product_serial_no" value="<?= htmlspecialchars($product_serial_no); ?>">

        <label>Product Serial Number Range:</label>
        <input type="text" name="serial_start" placeholder="Start Serial No" value="<?= htmlspecialchars($serial_start); ?>">
        <input type="text" name="serial_end" placeholder="End Serial No" value="<?= htmlspecialchars($serial_end); ?>">

        <label>Customer Name:</label>
        <input type="text" name="customer_name" value="<?= htmlspecialchars($customer_name); ?>">

        <label>Invoice Date Range:</label>
        <input type="date" name="start_date" value="<?= htmlspecialchars($start_date); ?>">
        <input type="date" name="end_date" value="<?= htmlspecialchars($end_date); ?>">

        <label>Payment Mode:</label>
        <select name="payment_mode">
            <option value="">Select</option>
            <option value="Cash" <?= ($payment_mode == 'Cash') ? 'selected' : ''; ?>>Cash</option>
            <option value="UPI" <?= ($payment_mode == 'UPI') ? 'selected' : ''; ?>>UPI</option>
            <option value="Credit Card" <?= ($payment_mode == 'Credit Card') ? 'selected' : ''; ?>>Credit Card</option>
            <option value="Debit Card" <?= ($payment_mode == 'Debit Card') ? 'selected' : ''; ?>>Debit Card</option>
        </select>

        <button type="submit">Search</button>
    </form>

    <h2>Search Results</h2>
    <table border="1">
        <tr>
            <th>Invoice No</th>
            <th>Customer Name</th>
            <th>Invoice Date</th>
            <th>Total Amount</th>
            <th>Action</th>
        </tr>
        <?php foreach ($results as $row) { ?>
            <tr>
                <td><?= htmlspecialchars($row['invoice_no']); ?></td>
                <td><?= htmlspecialchars($row['customer_name']); ?></td>
                <td><?= htmlspecialchars($row['invoice_date']); ?></td>
                <td><?= htmlspecialchars($row['total_amount']); ?></td>
                <td><a href="generate_bill.php?invoice_no=<?= urlencode($row['invoice_no']); ?>">Generate Bill</a></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<!-- 
Final search1 file
<?php
include 'database.php';

// **🔹 Invoice Search Query**
$queryInvoices = "SELECT invoice_no, customer_name, invoice_date, total_amount FROM invoice_master WHERE 1=1";
$paramsInvoices = [];
$showInvoiceTable = false;

// **🔹 Product Search Query**
$queryProducts = "SELECT product_serial_no, product_title, hsn_sac, quantity, unit_cost, total_cost, invoice_no 
                  FROM invoice_details WHERE 1=1";
$paramsProducts = [];
$showProductTable = false;

// **🔹 Retain User Inputs**
$invoice_no = $_GET['invoice_no'] ?? '';
$invoice_start = $_GET['invoice_start'] ?? '';
$invoice_end = $_GET['invoice_end'] ?? '';
$product_serial_no = $_GET['product_serial_no'] ?? '';
$serial_start = $_GET['serial_start'] ?? '';
$serial_end = $_GET['serial_end'] ?? '';
$customer_name = $_GET['customer_name'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
$payment_mode = $_GET['payment_mode'] ?? '';

// **🔹 Invoice Filters**
if (!empty($invoice_no)) {
    $invoiceNumbers = explode(',', str_replace(' ', '', $invoice_no)); 
    $placeholders = implode(',', array_fill(0, count($invoiceNumbers), '?'));
    $queryInvoices .= " AND invoice_no IN ($placeholders)";
    $paramsInvoices = array_merge($paramsInvoices, $invoiceNumbers);
    $showInvoiceTable = true;
}

if (!empty($invoice_start) && !empty($invoice_end)) {
    $queryInvoices .= " AND invoice_no BETWEEN ? AND ?";
    array_push($paramsInvoices, $invoice_start, $invoice_end);
    $showInvoiceTable = true;
}

if (!empty($customer_name)) {
    $queryInvoices .= " AND customer_name LIKE ?";
    $paramsInvoices[] = "%" . $customer_name . "%";
    $showInvoiceTable = true;
}

if (!empty($start_date) && !empty($end_date)) {
    $queryInvoices .= " AND invoice_date BETWEEN ? AND ?";
    array_push($paramsInvoices, $start_date, $end_date);
    $showInvoiceTable = true;
}

if (!empty($payment_mode)) { 
    $queryInvoices .= " AND payment_mode = ?";
    $paramsInvoices[] = $payment_mode;
    $showInvoiceTable = true;
}

// **🔹 Product Filters**
if (!empty($product_serial_no)) {
    $serialNumbers = explode(',', str_replace(' ', '', $product_serial_no));
    $placeholders = implode(',', array_fill(0, count($serialNumbers), '?'));
    $queryProducts .= " AND product_serial_no IN ($placeholders)";
    $paramsProducts = array_merge($paramsProducts, $serialNumbers);
    $showProductTable = true;
}

if (!empty($serial_start) && !empty($serial_end)) {
    $queryProducts .= " AND product_serial_no BETWEEN ? AND ?";
    array_push($paramsProducts, $serial_start, $serial_end);
    $showProductTable = true;
}

// **🔹 Execute Queries**
$stmtInvoices = $conn->prepare($queryInvoices);
$stmtInvoices->execute($paramsInvoices);
$invoiceResults = $stmtInvoices->fetchAll(PDO::FETCH_ASSOC);

$stmtProducts = $conn->prepare($queryProducts);
$stmtProducts->execute($paramsProducts);
$productResults = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);

// **🔹 Output Results**
if ($showInvoiceTable && !empty($invoiceResults)) {
    echo "<h2>Invoice Results</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Invoice No</th><th>Customer Name</th><th>Invoice Date</th><th>Total Amount</th><th>Action</th></tr>";
    foreach ($invoiceResults as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['invoice_no']) . "</td>";
        echo "<td>" . htmlspecialchars($row['customer_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['invoice_date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total_amount']) . "</td>";
        echo "<td><a href='generate_bill.php?invoice_no=" . urlencode($row['invoice_no']) . "'>Generate Bill</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}

if ($showProductTable && !empty($productResults)) {
    echo "<h2>Product Serial Number Results</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Serial Number</th><th>Product Name</th><th>HSN/SAC</th><th>Quantity</th><th>Unit Cost</th><th>Total Cost</th><th>Invoice No</th><th>Action</th></tr>";
    foreach ($productResults as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['product_serial_no']) . "</td>";
        echo "<td>" . htmlspecialchars($row['product_title']) . "</td>";
        echo "<td>" . htmlspecialchars($row['hsn_sac']) . "</td>";
        echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
        echo "<td>" . htmlspecialchars($row['unit_cost']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total_cost']) . "</td>";
        echo "<td>" . htmlspecialchars($row['invoice_no']) . "</td>";
        echo "<td><a href='generate_bill.php?invoice_no=" . urlencode($row['invoice_no']) . "'>Generate Bill</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}
?> -->