<!DOCTYPE html>
<head>
    <title>Search PAge</title>
    <style>
        h2 {
            /* text-align: center; */
            margin-left: 10%;
            margin-top: 5%;
            width: 100%;
        }
            table {
            width: 100%;
            padding-right: 20px;
            margin-right: 20px;
            border-collapse: collapse;
            background: white;
            margin-top: 50px;
            margin-left: 60%;
            
            }
            th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

th {
    background: #34495e;
    color: white;
    width: 100px;
}

tr:hover {
    background: #ecf0f1;
}
        
    </style>
    </head>
<body>
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
$total_cost = $_GET['total_cost'] ?? '';
$min_total_cost = $_GET['min_total_cost'] ?? '';
$max_total_cost = $_GET['max_total_cost'] ?? '';

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

// **🔹 Total Cost Filters**
if (!empty($total_cost) && is_numeric($total_cost)) {
    $queryInvoices .= " AND total_amount = ?";
    $paramsInvoices[] = (float)$total_cost;
    $showInvoiceTable = true;
}

// if (!empty($min_total_cost) && !empty($max_total_cost) && is_numeric($min_total_cost) && is_numeric($max_total_cost)) {
//     $queryInvoices .= " AND total_amount BETWEEN ? AND ?";
//     array_push($paramsInvoices, (float)$min_total_cost, (float)$max_total_cost);
//     $showInvoiceTable = true;
// }
// if (!empty($min_total_cost) && !empty($max_total_cost) && is_numeric($min_total_cost) && is_numeric($max_total_cost)) {
//     $queryInvoices .= " AND total_amount BETWEEN ? AND ?";
//     array_push($paramsInvoices, (float)$min_total_cost, (float)$max_total_cost);
//     $showInvoiceTable = true;
// }

if (isset($min_total_cost, $max_total_cost) && is_numeric($min_total_cost) && is_numeric($max_total_cost)) {
    $queryInvoices .= " AND total_amount BETWEEN ? AND ?";
    $paramsInvoices[] = (float) $min_total_cost;
    $paramsInvoices[] = (float) $max_total_cost;
    $showInvoiceTable = true;
}


// **🔹 If Invoice Range is Selected, Filter Products Based on It**
$invoiceFilterApplied = !empty($invoice_start) && !empty($invoice_end);
if ($invoiceFilterApplied) {
    $queryProducts .= " AND invoice_no IN (SELECT invoice_no FROM invoice_master WHERE invoice_no BETWEEN ? AND ?)";
    array_push($paramsProducts, $invoice_start, $invoice_end);
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

// **🔹 Debugging - Print Query**
// echo "<pre>Invoice Query: $queryInvoices\n";
// print_r($paramsInvoices);
// echo "</pre>";

$invoiceResults = $stmtInvoices->fetchAll(PDO::FETCH_ASSOC);

$stmtProducts = $conn->prepare($queryProducts);
$stmtProducts->execute($paramsProducts);
$productResults = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);

// **🔹 Output Results**
if ($showInvoiceTable && !empty($invoiceResults)) {
    echo "<h2>Invoice Details</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Invoice No</th><th>Customer Name</th><th>Invoice Date</th><th>Total Amount</th><th>Action</th></tr>";
    foreach ($invoiceResults as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['invoice_no']) . "</td>";
        echo "<td>" . htmlspecialchars($row['customer_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['invoice_date']) . "</td>";
        echo "<td>" . number_format($row['total_amount'], 2) . "</td>";
        echo "<td><a href='generate_bill.php?invoice_no=" . urlencode($row['invoice_no']) . "'>Generate Bill</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}

if ($showProductTable && !empty($productResults)) {
    echo "<h2>Product Details</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Serial Number</th><th>Product Name</th><th>HSN/SAC</th><th>Quantity</th><th>Unit Cost</th><th>Total Cost</th><th>Invoice No</th><th>Action</th></tr>";
    foreach ($productResults as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['product_serial_no']) . "</td>";
        echo "<td>" . htmlspecialchars($row['product_title']) . "</td>";
        echo "<td>" . htmlspecialchars($row['hsn_sac']) . "</td>";
        echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
        echo "<td>" . number_format($row['unit_cost'], 2) . "</td>";
        echo "<td>" . number_format($row['total_cost'], 2) . "</td>";
        echo "<td>" . htmlspecialchars($row['invoice_no']) . "</td>";
        echo "<td><a href='generate_bill.php?invoice_no=" . urlencode($row['invoice_no']) . "'>Generate Bill</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>
</body>
</html>