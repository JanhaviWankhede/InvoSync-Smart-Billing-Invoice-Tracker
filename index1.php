<!DOCTYPE html>
<html lang="en">
<head>
    <title>Billing System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- <h2>Search & Billing System</h2> -->
    <div class="container">
        <div class="sidebar">
            <h2>Filters</h2>
            <form method="GET" action="search.php">
                <label>Invoice Numbers (Comma-Separated):</label>
                <input type="text" name="invoice_no">

                <label>Invoice Number Range:</label>
                <input type="text" name="invoice_start" placeholder="Start Invoice No">
                <input type="text" name="invoice_end" placeholder="End Invoice No">

                <label>Product Serial Numbers (Comma-Separated):</label>
                <input type="text" name="product_serial_no">

                <label>Product Serial Number Range:</label>
                <input type="text" name="serial_start" placeholder="Start Serial No">
                <input type="text" name="serial_end" placeholder="End Serial No">

                <label>Customer Name:</label>
                <input type="text" name="customer_name">

                <label>Invoice Date Range:</label>
                <input type="date" name="start_date">
                <input type="date" name="end_date">

                <label>Payment Mode:</label>
                <select name="payment_mode">
                    <option value="">Select</option>
                    <option value="Cash">Cash</option>
                    <option value="UPI">UPI</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Debit Card">Debit Card</option>
                </select>

                <button type="submit">Search</button>
                <button type="button" onclick="clearFilters()">🧹 Clear</button>
            </form>

    <h6>Upload Excel File</h6>
    <form method="POST" action="upload_excel.php" enctype="multipart/form-data">
        <input type="file" name="excel_file" required>
        <button type="submit">Upload & Fetch Details</button>
    </form>
    <script>
    function clearFilters() {
        window.location.href = "index.php"; // Reloads the page to reset all fields
    }
    </script>
</body>
</html>
