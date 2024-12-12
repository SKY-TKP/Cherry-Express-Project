<?php
// Include the database connection file
include 'db.php';

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add new entry
    if (isset($_POST['add'])) {
        $boxType = $_POST['BoxType'];
        $boxSize = $_POST['BoxSize'];
        $width = $_POST['Width'];
        $length = $_POST['Length'];
        $height = $_POST['Height'];
        $weight = $_POST['Weight'];
        $DeliveryPrice = $_POST['DeliveryPrice'];
        $boxPrice = $_POST['BoxPrice'];

        $sql = "INSERT INTO box_type_table (BoxType, BoxSize, Width, Length, Height, Weight, DeliveryPrice, BoxPrice)
                VALUES ('$boxType', '$boxSize', '$width', '$length', '$height', '$weight', '$DeliveryPrice', '$boxPrice')";
        $conn->query($sql);
    }

    // Delete entry
    elseif (isset($_POST['delete'])) {
        $boxType = $_POST['BoxType'];
        $sql = "DELETE FROM box_type_table WHERE BoxType='$boxType'";
        $conn->query($sql);
    }

    // Edit entry
    elseif (isset($_POST['edit'])) {
        $boxType = $_POST['BoxType'];
        $boxSize = $_POST['BoxSize'];
        $width = $_POST['Width'];
        $length = $_POST['Length'];
        $height = $_POST['Height'];
        $weight = $_POST['Weight'];
        $DeliveryPrice = $_POST['DeliveryPrice'];
        $boxPrice = $_POST['BoxPrice'];

        $sql = "UPDATE box_type_table 
                SET BoxSize='$boxSize', Width='$width', Length='$length', 
                    Height='$height', Weight='$weight', DeliveryPrice='$DeliveryPrice', 
                    BoxPrice='$boxPrice'
                WHERE BoxType='$boxType'";
        $conn->query($sql);
    }
}

$result = $conn->query("SELECT * FROM box_type_table");
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
    <title>Box Type Management</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
        }
        h1, h2 {
            color: #9c0101;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #9c0101;
        }
        th, td {
            padding: 10px;
            text-align: center;
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
    <div id="header"></div>

    <h1>Manage Box Types</h1>
    <table>
        <tr>
            <th>BoxType</th>
            <th>BoxSize</th>
            <th>Width</th>
            <th>Length</th>
            <th>Height</th>
            <th>Weight</th>
            <th>DeliveryPrice</th>
            <th>BoxPrice</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['BoxType'] ?></td>
            <td><?= $row['BoxSize'] ?></td>
            <td><?= $row['Width'] ?></td>
            <td><?= $row['Length'] ?></td>
            <td><?= $row['Height'] ?></td>
            <td><?= $row['Weight'] ?></td>
            <td><?= $row['DeliveryPrice'] ?></td>
            <td><?= $row['BoxPrice'] ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="BoxType" value="<?= $row['BoxType'] ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
                <form method="post">
                    <input type="hidden" name="BoxType" value="<?= $row['BoxType'] ?>">
                    <input type="hidden" name="BoxSize" value="<?= $row['BoxSize'] ?>">
                    <input type="hidden" name="Width" value="<?= $row['Width'] ?>">
                    <input type="hidden" name="Length" value="<?= $row['Length'] ?>">
                    <input type="hidden" name="Height" value="<?= $row['Height'] ?>">
                    <input type="hidden" name="Weight" value="<?= $row['Weight'] ?>">
                    <input type="hidden" name="DeliveryPrice" value="<?= $row['DeliveryPrice'] ?>">
                    <input type="hidden" name="BoxPrice" value="<?= $row['BoxPrice'] ?>">
                    <button type="submit" name="edit_mode">Edit</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php if (isset($_POST['edit_mode'])): ?>
        <div class="form-container">
            <h2>Edit Box Information</h2>
            <form method="post">
                <input type="hidden" name="BoxType" value="<?= $_POST['BoxType'] ?>">
                <label for="BoxSize">Box Size:</label>
                <input type="text" name="BoxSize" value="<?= $_POST['BoxSize'] ?>" required>
                <label for="Width">Width:</label>
                <input type="number" name="Width" value="<?= $_POST['Width'] ?>" required>
                <label for="Length">Length:</label>
                <input type="number" name="Length" value="<?= $_POST['Length'] ?>" required>
                <label for="Height">Height:</label>
                <input type="number" name="Height" value="<?= $_POST['Height'] ?>" required>
                <label for="Weight">Weight:</label>
                <input type="number" name="Weight" value="<?= $_POST['Weight'] ?>" required>
                <label for="DeliveryPrice">Delivery Price:</label>
                <input type="number" name="DeliveryPrice" value="<?= $_POST['DeliveryPrice'] ?>" required>
                <label for="BoxPrice">Box Price:</label>
                <input type="number" name="BoxPrice" value="<?= $_POST['BoxPrice'] ?>" required>
                <button type="submit" name="edit">Save Changes</button>
            </form>
        </div>
    <?php else: ?>
        <div class="form-container">
            <h2>Add New Box</h2>
            <form method="post">
                <label for="BoxType">Box Type:</label>
                <input type="text" name="BoxType" required>
                <label for="BoxSize">Box Size:</label>
                <input type="text" name="BoxSize" required>
                <label for="Width">Width:</label>
                <input type="number" name="Width" required>
                <label for="Length">Length:</label>
                <input type="number" name="Length" required>
                <label for="Height">Height:</label>
                <input type="number" name="Height" required>
                <label for="Weight">Weight:</label>
                <input type="number" name="Weight" required>
                <label for="DeliveryPrice">Delivery Price:</label>
                <input type="number" name="DeliveryPrice" required>
                <label for="BoxPrice">Box Price:</label>
                <input type="number" name="BoxPrice" required>
                <button type="submit" name="add">Add Box</button>
            </form>
        </div>
    <?php endif; ?>

    <div id="footer"></div>
</body>
</html>
