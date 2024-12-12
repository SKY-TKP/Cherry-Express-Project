<?php
// Include the database connection file
include 'db.php';

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add new entry
    // Add new entry
    if (isset($_POST['add'])) {
        $WarehouseID = $_POST['WarehouseID'];
        $Capacity = $_POST['Capacity'];
        $Location = $_POST['Location'];
        $OperationalStatus = $_POST['OperationalStatus'];
        $Postcode = $_POST['Postcode'];

        // Check if WarehouseID already exists
        $checkSql = "SELECT * FROM warehouse_table WHERE WarehouseID = '$WarehouseID'";
        $checkResult = $conn->query($checkSql);

        if ($checkResult->num_rows > 0) {
            echo "<script>alert('Warehouse ID already exists! Please use a unique ID.');</script>";
        } else {
        $sql = "INSERT INTO warehouse_table (Capacity, Location, OperationalStatus, Postcode, WarehouseID)
                VALUES ('$Capacity', '$Location', '$OperationalStatus', '$Postcode', '$WarehouseID')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Warehouse added successfully!'); window.location.href = window.location.href;</script>";
        } else {
            echo "<script>alert('Error adding warehouse: " . $conn->error . "');</script>";
        }
    }
}


    // Delete entry
    elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM warehouse_table WHERE id='$id'";
        $conn->query($sql);
    }

    // Edit entry
    elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $WarehouseID = $_POST['WarehouseID'];
        $Capacity = $_POST['Capacity'];
        $Location = $_POST['Location'];
        $OperationalStatus = $_POST['OperationalStatus'];
        $Postcode = $_POST['Postcode'];

        $sql = "UPDATE warehouse_table 
                SET WarehouseID='$WarehouseID', Capacity='$Capacity', Location='$Location', 
                    OperationalStatus='$OperationalStatus', Postcode='$Postcode'
                WHERE id='$id'";
        $conn->query($sql);
    }
}

$result = $conn->query("SELECT * FROM warehouse_table");
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../styles.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#header").load("./include/header.html");
            $("#footer").load("./include/footer.html");
        });
    </script>

    <title>Warehouse Management</title>
    <style>
        body {
            display:flex;
            flex-direction: column;
        }
        h1, h2 {
            color: #9c0101;
        }
        .table-container {
            max-width: 100%;
            max-height: 400px;
            overflow-x: auto; /* Enable horizontal scrolling */
            border: 1px solid #9c0101;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #9c0101;
        }
        th {
            background-color: #9c0101;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #ffe6e6;
        }
        tr:nth-child(odd) {
            background-color: #fffafa;
        }
        button {
            background-color: #9c0101;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-family: 'Kanit', sans-serif;
        }
        button:hover {
            background-color: #730101;
        }
        form {
            display: inline-block;
        }
        input[type="text"], input[type="number"] {
            padding: 5px;
            margin: 5px 0;
            width: calc(100% - 10px);
        }
        input[type="submit"], button {
            width: 100%;
        }
        .form-container {
            background-color: white;
            border: 1px solid #9c0101;
            padding: 20px;
            border-radius: 5px;
            max-width: 600px;
            margin: auto;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this warehouse?");
        }
    </script>

    <div id="header"></div>

    <h1>Manage Warehouses</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Warehouse ID</th>
                    <th>Capacity</th>
                    <th>Location</th>
                    <th>Operational Status</th>
                    <th>Postcode</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['WarehouseID'] ?></td>
                    <td><?= $row['Capacity'] ?></td>
                    <td><?= $row['Location'] ?></td>
                    <td><?= $row['OperationalStatus'] ?></td>
                    <td><?= $row['Postcode'] ?></td>
                    <td>
                        <form method="post" onsubmit="return confirmDelete();">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="WarehouseID" value="<?= $row['WarehouseID'] ?>">
                            <input type="hidden" name="Capacity" value="<?= $row['Capacity'] ?>">
                            <input type="hidden" name="Location" value="<?= $row['Location'] ?>">
                            <input type="hidden" name="OperationalStatus" value="<?= $row['OperationalStatus'] ?>">
                            <input type="hidden" name="Postcode" value="<?= $row['Postcode'] ?>">
                            <button type="submit" name="edit_mode">Edit</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php if (isset($_POST['edit_mode'])): ?>
        <div class="form-container">
            <h2>Edit Warehouse Information</h2>
            <form method="post">
                <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
                <label for="WarehouseID">Warehouse ID:</label>
                <input type="text" name="WarehouseID" value="<?= $_POST['WarehouseID'] ?>" required>
                <label for="Capacity">Capacity:</label>
                <input type="number" name="Capacity" value="<?= $_POST['Capacity'] ?>" required>
                <label for="Location">Location:</label>
                <input type="text" name="Location" value="<?= $_POST['Location'] ?>" required>
                <label for="OperationalStatus">Operational Status:</label>
                <input type="text" name="OperationalStatus" value="<?= $_POST['OperationalStatus'] ?>" required>
                <label for="Postcode">Postcode:</label>
                <input type="text" name="Postcode" value="<?= $_POST['Postcode'] ?>" required>
                <button type="submit" name="edit">Save Changes</button>
            </form>
        </div>
    <?php else: ?>
        <div class="form-container">
            <h2>Add New Warehouse</h2>
            <form method="post">
                <label for="WarehouseID">Warehouse ID:</label>
                <input type="text" name="WarehouseID" required>
                <label for="Capacity">Capacity:</label>
                <input type="number" name="Capacity" required>
                <label for="Location">Location:</label>
                <input type="text" name="Location" required>
                <label for="OperationalStatus">Operational Status:</label>
                <input type="text" name="OperationalStatus" required>
                <label for="Postcode">Postcode:</label>
                <input type="text" name="Postcode" required>
                <button type="submit" name="add">Add Warehouse</button>
            </form>
        </div>
    <?php endif; ?>

    <div id="footer"></div>


</body>
</html>

