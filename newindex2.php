<!DOCTYPE html> 
<html lang="en">
<head>
    <title>Billing System</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery for AJAX -->
   
</head>

<body>
<!-- <div class="header-container">
    <h1>Invoice and Product Detail</h1>
</div> -->
<!-- <h1>Invoice and Product Detail</h1> -->
<!-- <h1>Invoice and Product Detail</h1> -->
    
    <div class="container">
        <div class="sidebar">
            <h2>Filters</h2>
            <form id="searchForm" method="GET">
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

                <label for="total_cost">Total Cost:</label>
                <input type="number" name="total_cost" id="total_cost" placeholder="Enter exact total cost">

                <label for="min_total_cost">Min Total Cost:</label>
                <input type="number" name="min_total_cost" id="min_total_cost" placeholder="Min cost">

                <label for="max_total_cost">Max Total Cost:</label>
                <input type="number" name="max_total_cost" id="max_total_cost" placeholder="Max cost">

                <button type="button" id="searchButton">Search</button>
                <button type="button" onclick="clearFilters()">Clear</button>
            </form>

            <!-- <h6>Upload Excel File</h6> -->
            <form method="POST" action="upload_excel.php" enctype="multipart/form-data">
                <label>Upload excel file</label>
                <input type="file" name="excel_file" required>
                <button type="submit">Upload & Fetch Details</button>
            </form>
        </div>

        <!-- Add a div to display search results -->
        <div id="searchResults"></div>
    </div>

    <script>
        function clearFilters() {
            window.location.href = "newindex2.php"; // Reloads the page to reset all fields
        }

        // AJAX to fetch search results
        $(document).ready(function() {
            $("#searchButton").click(function() {
                var formData = $("#searchForm").serialize(); // Serialize form data
                $.ajax({
                    url: "search1.php", // Send request to search.php
                    type: "GET",
                    data: formData,
                    success: function(response) {
                        $("#searchResults").html(response); // Display results in the div
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + error);
                    }
                });
            });
        });
    </script>
</body>
</html>