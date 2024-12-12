<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cherry Express - Order Input</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Order Tracking Input</h1>
        </header>
        
        <section class="order-form">
            <form action="save_order.php" method="post">
                <div class="form-group">
                    <label for="trackingNumber">Tracking Number:</label>
                    <input type="text" id="trackingNumber" name="trackingNumber" pattern="[0-9]{10}" title="Tracking number must be 10 digits" required>
                </div>
                <div class="form-group">
                    <label for="customerName">Customer Name:</label>
                    <input type="text" id="customerName" name="customerName" required>
                </div>
                <div class="form-group">
                    <label for="destination">Destination:</label>
                    <input type="text" id="destination" name="destination" required>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <input type="text" id="status" name="status" required>
                </div>
                <button type="submit" class="btn">Save Order</button>
            </form>
        </section>

        <footer>
            <p>&copy; 2024 Cherry Express</p>
        </footer>
    </div>

    <script>
        // ตรวจสอบว่า Tracking Number เป็นตัวเลข 10 หลัก
        document.querySelector('form').addEventListener('submit', function(e) {
            var trackingNumber = document.getElementById('trackingNumber').value;
            if (!/^\d{10}$/.test(trackingNumber)) {
                alert('Tracking number must be 10 digits.');
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
