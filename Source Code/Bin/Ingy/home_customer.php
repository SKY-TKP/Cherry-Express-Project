<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cherry Express - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Faster+One&display=swap" rel="stylesheet">
    
    <!-- CSS directly in the HTML file -->
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Apply Browalia font except for the logo */
        body {
            font-family: 'Browalia', Arial, sans-serif;
            background-color: #9c0101;
            color: white;
        }

        /* Top Bar */
        .top-bar {
            background-color: #333;
            padding: 10px 0;
            text-align: right;
        }

        .top-bar .top-nav {
            list-style: none;
            display: inline-block;
            font-family: 'Browalia', Arial, sans-serif;
        }

        .top-bar .top-nav li {
            display: inline;
            margin-left: 20px;
        }

        .top-bar .top-nav li a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .top-bar .top-nav li a:hover {
            text-decoration: underline;
        }

        /* Logo and Navigation */
        .logo-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }

        .logo h1 {
            font-family: 'Faster One', cursive;
            font-size: 40px;
            color: white;
        }

        .main-nav ul {
            list-style: none;
            font-family: 'Browalia', Arial, sans-serif;
        }

        .main-nav ul li {
            display: inline-block;
            margin-left: 30px;
        }

        .main-nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .main-nav ul li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
     <?
        $name = "poom" ;
     ?>
    <header>
        <div class="top-bar">
            <ul class="top-nav">
                <li><a href="customer_profile.php">Hello <? echo $name ?></a></li>
                <li><a href="home.html"> Log out </a></li>
            </ul>
        </div>
        <div class="logo-nav">
            <div class="logo">
                <h1>Cherry Express</h1>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="order_tracking.php">Track & Trace</a></li>
                    <li><a href="pre-calculation.php">Pre-Calculation</a></li>
                    <li><a href="preparation.php">Preparation to Ship</a></li>
                    <li><a href="branches.html">Nearby Branches</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <br>
    <br>
    <a href="customer_profile.php">Edit Customer profile</a><br>
    <a href="customer_order.php">Check all parcel</a><br>


</body>
</html>