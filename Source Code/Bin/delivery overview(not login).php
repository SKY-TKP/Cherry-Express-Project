<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Overview</title>
    <link href="https://fonts.googleapis.com/css2?family=Faster+One&display=swap&family=Browallia+New&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Browallia New', sans-serif;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        .header {
            background-color: #9c0101;
            color: white;
            width: 100%;
            padding: 15px 20px;
            font-family: 'Faster One', cursive;
            font-size: 24px;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 90%;
            text-align: center;
            margin-top: 100px; /* Offset to position below fixed header */
            font-family: 'Browallia New', sans-serif;
            font-size: 20px;
        }
        h1 {
            font-size: 26px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 18px;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        a {
            color: #9c0101;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">Cherry Express</div>
    <div class="container">
        <h1>Today's Deliveries</h1>

        <div class="delivery-summary">
            <?php
            // Include your database connection here
            // Assuming $conn is the connection object
            $sql = "SELECT tracking_number, destination, status FROM parcel_merge_table";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<thead><tr><th>Tracking Number</th><th>Destination</th><th>Status</th></tr></thead>";
                echo "<tbody>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><a href='delivery_confirmation.php?tracking_number=" . $row['tracking_number'] . "'>" . $row['tracking_number'] . "</a></td>";
                    echo "<td>" . $row['destination'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>No parcels to deliver today.</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
