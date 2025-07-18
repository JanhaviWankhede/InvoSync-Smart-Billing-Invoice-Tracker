<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 20px;
            background-color: #dde7f0;
        }
        .aboutus-title {
            font-size: 32px; /* Increase only this title */
        }

        .aboutus-text {
            font-size: 18px; /* Make text bigger */
        }

        .sidebar {
            width: 250px; /* Keep sidebar width fixed */
            font-size: 16px; /* Ensure the sidebar text remains normal */
        }

        .aboutus-section {
            padding: 90px 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            max-width: 1100px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 30px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }
        .aboutus {
            width: 45%;
        }
        .aboutus-title {
            font-size: 32px;
            text-transform: uppercase; letter-spacing: 1.5px;
            color: #000;
            margin-bottom: 10px;
        }
        .aboutus-title::after {
            content: "";
            display: block;
            width: 58px;
            height: 3px;
            background: #5a8db6;
            margin-top: 5px;
        }
        .aboutus-text {
            color: #4a4a4a;
            font-size: 14px;
            line-height: 24px;
            margin-bottom: 15px;
        }
        .aboutus-more {
            display: inline-block;
            border: 1px solid #5a8db6;
            border-radius: 25px;
            color: #5a8db6;
            font-size: 14px;
            font-weight: 700;
            padding: 10px 20px;
            text-transform: uppercase;
            text-decoration: none;
        }
        .aboutus-more:hover {
            background-color: #5a8db6;
            color: white;
        }
        .feature {
            width: 50%;
        }
        .feature-box {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        .iconset {
            width: 58px;
            height: 58px;
            border: 2px solid #5a8db6;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 20px;
        }
        .icon {
            font-size: 30px;
            color: #5a8db6;
        }
        .feature-content h4 {
            font-size: 18px;
            color: #000;
            margin-bottom: 5px;
        }
        .feature-content p {
            font-size: 14px;
            color: #4a4a4a;
            line-height: 22px;
        }
    </style>
</head>
<body>
    <div class="aboutus-section">
        <div class="container">
            <div class="aboutus">
                <h2 class="aboutus-title">About Us</h2>
                <p class="aboutus-text">We help businesses unlock hidden value from their data by providing advanced data analysis, insightful reports, and smart filtering solutions. Our expertise ensures that organizations can make data-driven decisions with clarity and confidence.</p>
                <p class="aboutus-text">With a strong focus on data analytics, we empower businesses to transform raw data into meaningful insights, optimize performance, and drive innovation.</p>
                <p class="aboutus-text">Our solutions integrate seamlessly with existing business workflows, ensuring a smooth transition from data collection to strategic execution. We prioritize security, scalability, and efficiency in every solution we offer.</p>
                <a class="aboutus-more" href="#">Read More</a>
                <a class="aboutus-more" href="index.html">Go Back</a>
            </div>
            <div class="feature">
                <div class="feature-box">
                    <div class="iconset">
                        <span class="icon">📊</span>
                    </div>
                    <div class="feature-content">
                        <h4>Data-Driven Insights</h4>
                        <p>We extract meaningful patterns and trends from data, enabling businesses to make informed decisions and stay ahead in the market.</p>
                    </div>
                </div>
                <div class="feature-box">
                    <div class="iconset">
                        <span class="icon">📈</span>
                    </div>
                    <div class="feature-content">
                        <h4>Custom Reports</h4>
                        <p>Our customized reports provide clear, actionable insights tailored to the unique needs of each business.</p>
                    </div>
                </div>
                <div class="feature-box">
                    <div class="iconset">
                        <span class="icon">🔍</span>
                    </div>
                    <div class="feature-content">
                        <h4>Advanced Data Filtering</h4>
                        <p>We streamline data analysis with intelligent filtering, helping businesses find the most relevant information quickly and efficiently.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>