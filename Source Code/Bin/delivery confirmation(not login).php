<?php
$servername = "localhost";
$username = "d67g9";
$password = "d67g9";
$dbname = "d67g9";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcel Delivery Confirmation</title>
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
            max-width: 600px;
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
        .parcel-details, .status-section, .comments-section, .signature-section {
            margin: 15px 0;
            text-align: left;
        }
        .parcel-details p, .status-section label, .comments-section label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        select, textarea, canvas, button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            font-size: 18px;
        }
        select, textarea {
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        canvas {
            border: 1px solid #ccc;
            height: 100px;
        }
        button {
            background-color: #9c0101;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            padding: 10px;
            font-size: 18px;
            margin-top: 10px;
        }
        button:hover {
            background-color: #b30d0d;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        let signaturePad;

        window.onload = function() {
            const canvas = document.getElementById("signatureCanvas");
            signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgba(255, 255, 255, 0)', // Optional background color
            });
        };

        function clearSignature() {
            signaturePad.clear();
        }

        function submitForm() {
            if (!signaturePad.isEmpty()) {
                const signatureData = signaturePad.toDataURL("image/png");
                document.getElementById("signatureData").value = signatureData;
            }
            return true; // Allow form submission
        }
    </script>
</head>
<body>
    <div class="header">Cherry Express</div>
    <div class="container">
        <h1>Confirm Parcel Delivery</h1>

        <div class="parcel-details">
            <p>Tracking Number: <!-- Display tracking number here --></p>
            <p>Destination: <!-- Display destination here --></p>
            <p>Recipient Name: <!-- Display recipient name here --></p>
        </div>

        <div class="status-section">
            <label for="deliveryStatus">Delivery Status:</label>
            <select id="deliveryStatus" name="delivery_status">
                <option value="In Transit">In Transit</option>
                <option value="Failed">Failed</option>
                <option value="Returned">Returned</option>
            </select>
        </div>

        <div class="comments-section">
            <label for="comments">Comments:</label>
            <textarea id="comments" name="comments" placeholder="Add comments if needed..."></textarea>
        </div>

        <div class="signature-section">
            <h3>Customer Signature</h3>
            <canvas id="signatureCanvas"></canvas>
            <button type="button" onclick="clearSignature()">Clear Signature</button>
        </div>

        <form method="POST" action="process_confirmation.php" onsubmit="return submitForm()">
            <input type="hidden" name="tracking_number" value="<!-- Tracking number value here -->">
            <input type="hidden" name="signature_data" id="signatureData">
            <button type="submit">Update Status</button>
        </form>
    </div>
</body>
</html>
