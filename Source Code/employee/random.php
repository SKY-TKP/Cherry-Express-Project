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
        $priceBase = $_POST['PriceBase'];
        $priceMultiplier = $_POST['PriceMultiplier'];
        $boxPrice = $_POST['BoxPrice'];

        $sql = "INSERT INTO box_type_table (BoxType, BoxSize, Width, Length, Height, Weight, PriceBase, PriceMultiplier, BoxPrice)
                VALUES ('$boxType', '$boxSize', '$width', '$length', '$height', '$weight', '$priceBase', '$priceMultiplier', '$boxPrice')";
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
        $priceBase = $_POST['PriceBase'];
        $priceMultiplier = $_POST['PriceMultiplier'];
        $boxPrice = $_POST['BoxPrice'];

        $sql = "UPDATE box_type_table 
                SET BoxSize='$boxSize', Width='$width', Length='$length', 
                    Height='$height', Weight='$weight', PriceBase='$priceBase', 
                    PriceMultiplier='$priceMultiplier', BoxPrice='$boxPrice'
                WHERE BoxType='$boxType'";
        $conn->query($sql);
    }
}

$result = $conn->query("SELECT * FROM box_type_table");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Box Type Management</title>
</head>
<body>
    <h1>Manage Box Types</h1>
    <table border="1">
        <tr>
            <th>BoxType</th>
            <th>BoxSize</th>
            <th>Width</th>
            <th>Length</th>
            <th>Height</th>
            <th>Weight</th>
            <th>PriceBase</th>
            <th>PriceMultiplier</th>
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
            <td><?= $row['PriceBase'] ?></td>
            <td><?= $row['PriceMultiplier'] ?></td>
            <td><?= $row['BoxPrice'] ?></td>
            <td>
                <form method="post" style="display: inline-block;">
                    <input type="hidden" name="BoxType" value="<?= $row['BoxType'] ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
                <form method="post" style="display: inline-block;">
                    <input type="hidden" name="BoxType" value="<?= $row['BoxType'] ?>">
                    <input type="hidden" name="BoxSize" value="<?= $row['BoxSize'] ?>">
                    <input type="hidden" name="Width" value="<?= $row['Width'] ?>">
                    <input type="hidden" name="Length" value="<?= $row['Length'] ?>">
                    <input type="hidden" name="Height" value="<?= $row['Height'] ?>">
                    <input type="hidden" name="Weight" value="<?= $row['Weight'] ?>">
                    <input type="hidden" name="PriceBase" value="<?= $row['PriceBase'] ?>">
                    <input type="hidden" name="PriceMultiplier" value="<?= $row['PriceMultiplier'] ?>">
                    <input type="hidden" name="BoxPrice" value="<?= $row['BoxPrice'] ?>">
                    <button type="submit" name="edit_mode">Edit</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php if (isset($_POST['edit_mode'])): ?>
        <h2>Edit Box Information</h2>
        <form method="post">
            <input type="hidden" name="BoxType" value="<?= $_POST['BoxType'] ?>">
            <label for="BoxSize">Box Size:</label>
            <input type="text" id="BoxSize" name="BoxSize" value="<?= $_POST['BoxSize'] ?>" required><br><br>
            <label for="Width">Width:</label>
            <input type="number" id="Width" name="Width" value="<?= $_POST['Width'] ?>" required><br><br>
            <label for="Length">Length:</label>
            <input type="number" id="Length" name="Length" value="<?= $_POST['Length'] ?>" required><br><br>
            <label for="Height">Height:</label>
            <input type="number" id="Height" name="Height" value="<?= $_POST['Height'] ?>" required><br><br>
            <label for="Weight">Weight:</label>
            <input type="number" id="Weight" name="Weight" value="<?= $_POST['Weight'] ?>" required><br><br>
            <label for="PriceBase">Price Base:</label>
            <input type="number" id="PriceBase" name="PriceBase" value="<?= $_POST['PriceBase'] ?>" required><br><br>
            <label for="PriceMultiplier">Price Multiplier:</label>
            <input type="number" id="PriceMultiplier" name="PriceMultiplier" value="<?= $_POST['PriceMultiplier'] ?>" required><br><br>
            <label for="BoxPrice">Box Price:</label>
            <input type="number" id="BoxPrice" name="BoxPrice" value="<?= $_POST['BoxPrice'] ?>" required><br><br>
            <button type="submit" name="edit">Save Changes</button>
        </form>
    <?php else: ?>
        <h2>Add New Box</h2>
        <form method="post">
            <label for="BoxType">Box Type:</label>
            <input type="text" name="BoxType" placeholder="Box Type" required>
            <label for="BoxSize">Box Size:</label>
            <input type="text" name="BoxSize" placeholder="Box Size" required>
            <label for="Width">Width:</label>
            <input type="number" name="Width" placeholder="Width" required>
            <label for="Length">Length:</label>
            <input type="number" name="Length" placeholder="Length" required>
            <label for="Height">Height:</label>
            <input type="number" name="Height" placeholder="Height" required>
            <label for="Weight">Weight:</label>
            <input type="number" name="Weight" placeholder="Weight" required>
            <label for="PriceBase">Price Base:</label>
            <input type="number" name="PriceBase" placeholder="Price Base" required>
            <label for="PriceMultiplier">Price Multiplier:</label>
            <input type="number" name="PriceMultiplier" placeholder="Price Multiplier" required>
            <label for="BoxPrice">Box Price:</label>
            <input type="number" name="BoxPrice" placeholder="Box Price" required>
            <button type="submit" name="add">Add Box</button>
        </form>
    <?php endif; ?>
</body>
</html>
