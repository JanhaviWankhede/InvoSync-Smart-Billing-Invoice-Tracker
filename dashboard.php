<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Panel</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            flex-direction: column;
            background: #f4f4f4;
            color: #333;
            overflow-x: hidden;
        }
        .navbar {
            width: 100%;
            height: 60px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .navbar .logo {
            font-size: 20px;
            font-weight: bold;
            color: #5A52FF;
        }
        .navbar .nav-icons {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .navbar .nav-icons i {
            font-size: 18px;
            cursor: pointer;
            color: #5A52FF;
        }
        .profile-menu {
            position: relative;
        }
        .profile-menu .dropdown {
            position: absolute;
            top: 40px;
            right: 0;
            background: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            display: none;
        }
        .profile-menu .dropdown a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: #333;
        }
        .profile-menu .dropdown a:hover {
            background: #f0f0ff;
        }
        .profile-menu.active .dropdown {
            display: block;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #ffffff;
            color: #333;
            position: fixed;
            left: 0;
            top: 60px;
            transition: width 0.3s ease-in-out;
            overflow-x: hidden;
            padding-top: 20px;
            border-right: 1px solid #ddd;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
        }
        .sidebar.closed {
            width: 70px;
        }
        .sidebar ul li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .sidebar ul li i {
            margin-right: 15px;
        }
        .sidebar ul li span {
            flex-grow: 1;
        }
        .sidebar ul li .arrow {
            transition: transform 0.3s;
        }
        .sidebar ul li.active {
            background: #d0d0ff;
            color: #333;
            font-weight: bold;
        }
        .sidebar ul li:hover {
            background: #f0f0ff;
            color: #5A52FF;
        }
        .sidebar.closed ul li span, .sidebar.closed ul li .arrow {
            display: none;
        }
        .content {
            margin-left: 250px;
            padding: 80px 20px;
            width: calc(100% - 250px);
            transition: margin-left 0.3s, width 0.3s;
            background: white;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .sidebar.closed ~ .content {
            margin-left: 70px;
            width: calc(100% - 70px);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">Dashboard</div>
        <div class="nav-icons">
            <i class="fas fa-bell"></i>
            <div class="profile-menu" onclick="toggleDropdown()">
                <i class="fas fa-user-circle"></i>
                <div class="dropdown">
                    <a href="logout.php">Logout</a> <!-- Correct Logout Link -->
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul>
            <li onclick="loadContent('profile', this)"><i class="fas fa-user"></i> <span>Profile</span></li>
            <!-- <li onclick="loadContent('past-records', this)"><i class="fas fa-history"></i> <span>Past Records</span></li> -->
            <!-- <li onclick="loadContent('newindex2', this)"><i class="fas fa-filter"></i> <span>Filters</span></li> -->
            <li onclick="loadContent('idx', this)"><i class="fas fa-filter"></i> <span>Filters</span></li>
            <li onclick="loadContent('aboutus', this)"><i class="fas fa-info-circle"></i> <span>About Us</span></li>
            <li onclick="loadContent('contact', this)"><i class="fas fa-envelope"></i> <span>Contact Us</span></li>
        </ul>
    </div>

    <!-- Main Content (Dynamic Content Will Load Here) -->
    <div class="content" id="content-area">
        <h1>Welcome to the Dashboard</h1>
        <p>Select an option from the sidebar.</p>
    </div>

    <!-- JavaScript -->
    <script>
     
       
        function toggleDropdown() {
            document.querySelector(".profile-menu").classList.toggle("active");
        }
// 
        // function loadContent(page, element) {
        //     // Remove 'active' class from all sidebar items
        //     document.querySelectorAll(".sidebar ul li").forEach(li => li.classList.remove("active"));

        //     // Add 'active' class to the clicked item
        //     element.classList.add("active");

        //     // Load the PHP file dynamically
        //     fetch(page + ".php")
        //         .then(response => {
        //             if (!response.ok) {
        //                 throw new Error("Page not found");
        //             }
        //             return response.text();
        //         })
        //         .then(data => {
        //             document.getElementById("content-area").innerHTML = data;
        //         })
        //         .catch(error => {
        //             document.getElementById("content-area").innerHTML = `<h1>Error</h1><p>Could not load ${page}.php</p>`;
        //             console.error("Error loading content:", error);
        //         });
        // }

        function loadContent(page, element) {
    document.querySelectorAll(".sidebar ul li").forEach(li => li.classList.remove("active"));
    element.classList.add("active");

    fetch(page + ".php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("content-area").innerHTML = data;

            // 🔴 Rebind event listener after dynamic load
            if (page === "newindex2") {
                setupSearchFunctionality();
            }
        })
        .catch(error => console.error("Error loading content:", error));
}

function setupSearchFunctionality() {
    $(document).ready(function () {
        $("#searchButton").off("click").on("click", function () {
            console.log("✅ Search button clicked, sending request..."); // Debugging

            var formData = $("#searchForm").serialize();
            $.ajax({
                url: "search1.php",
                type: "GET",
                data: formData,
                success: function(response) {
                    $("#searchResults").html(response);
                },
                error: function(xhr, status, error) {
                    console.error("❌ AJAX Error:", status, error);
                }
            });
        });
    });
}
function clearFilters() {
            window.location.href = "newindex2.php"; // Reloads the page to reset all fields
        }
       
    //     function loadContent(page, element) {
    // document.querySelectorAll(".sidebar ul li").forEach(li => li.classList.remove("active"));
    // element.classList.add("active");

    // fetch(page + ".php")
    //     .then(response => response.text())
    //     .then(data => {
    //         document.getElementById("content-area").innerHTML = data;

    //         // 🔴 Rebind event listener after dynamic load
    //         if (page === "index2") {
    //             setupSearchFunctionality();
    //         }
    //     })
    //     .catch(error => console.error("Error loading content:", error));
//}


    // function setupSearchFunctionality() {
    // $(document).ready(function () {
    //     // Bind Search button event
    //     $("#searchButton").off("click").on("click", function () {
    //         console.log("✅ Search button clicked, sending request..."); // Debugging

    //         var formData = $("#searchForm").serialize();
    //         $.ajax({
    //             url: "search1.php",
    //             type: "GET",
    //             data: formData,
    //             success: function(response) {
    //                 $("#searchResults").html(response);
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error("❌ AJAX Error:", status, error);
    //             }
    //         });
    //     });






        // // 🔴 Bind Clear button event
        // $("#clearButton").off("click").on("click", function () {
        //     console.log("🧹 Clear button clicked, resetting filters..."); // Debugging

        //     // Reset the form fields
        //     $("#searchForm")[0].reset();

        //     // Optionally clear the search results
        //     $("#searchResults").html("");

        //     // Reload the page (optional)
        //     // window.location.href = "index2.php"; 
        // });
//     });
// }


    </script>

</body>
</html>
