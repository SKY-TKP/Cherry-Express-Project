<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Warehouse Monitor</title>
</head>
<body>
<h1>Warehouse Stock</h1>
<br>

<form method="GET" action="">
    <label for="WarehouseID">Warehouse</label>
    <select name="WarehouseID" id="WarehouseID">
        <option value="">All</option>
        <option value="WH001">Warehouse 1</option>
        <option value="WH002">Warehouse 2</option>
        <option value="WH003">Warehouse 3</option>
        <option value="WH004">Warehouse 4</option>
        <option value="WH005">Warehouse 5</option>
        <option value="WH006">Warehouse 6</option>
        <?php
        // ตัวอย่างการเพิ่ม option จากฐานข้อมูล
        // เชื่อมต่อฐานข้อมูล
        $servername = "127.0.0.1";
        $db_username = "d67g9";
        $db_password = "d67g9";
        $dbname = "d67g9";
        $conn = new mysqli($servername, $db_username, $db_password, $dbname);

        if ($conn->connect_error) {
            die("Fail to connect to database: " . $conn->connect_error);
        }

        // ดึงข้อมูล warehouse ทั้งหมดจากฐานข้อมูล
        $sql_warehouse = "SELECT warehouse_id FROM warehouses_table";
        $result_warehouse = $conn->query($sql_warehouse);

        if ($result_warehouse->num_rows > 0) {
            while ($row = $result_warehouse->fetch_assoc()) {
                echo "<option value='" . $row['warehouse_id'] . "'>" . $row['warehouse_id'] . "</option>";
            }
        }
        ?>
    </select>
    <button type="submit">Sort by</button>
</form>

<!-- ส่วนการแสดงข้อมูลจากฐานข้อมูล -->
<?php
$selected_warehouse = isset($_GET['WarehouseID']) ? $_GET['WarehouseID'] : "";

// เขียน query สำหรับดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT 
            w.WarehouseID,
            p.ParcelID,
            p.TrackingNumber, 
            p.Status 
        FROM 
            warehouses_table w 
        LEFT JOIN 
            parcels_table p ON w.WarehouseID = p.WarehouseID";

// ถ้าเลือก warehouse ใด warehouse หนึ่ง ให้เพิ่มเงื่อนไขใน query
if ($selected_warehouse != "") {
    $sql .= " WHERE w.WarehouseID = ?";
}

$sql .= " ORDER BY w.WarehouseID";

// เตรียม statement และ bind parameter ถ้ามี warehouse ที่เลือก
$stmt = $conn->prepare($sql);
if ($selected_warehouse != "") {
    $stmt->bind_param("s", $selected_warehouse); // เปลี่ยนเป็น "s" สำหรับ string
}

$stmt->execute();
$result = $stmt->get_result();

// แสดงข้อมูลในรูปแบบตาราง
echo "<table>";
echo "
    <tr>
        <th>Warehouse ID</th>
        <th>Parcel ID</th>
        <th>Tracking number</th>
        <th>Status</th>
    </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['WarehouseID'] . "</td>";
    echo "<td>" . $row['ParcelID'] . "</td>";
    echo "<td>" . $row['TrackingNumber'] . "</td>";
    echo "<td>" . $row['Status'] . "</td>";
    echo "</tr>";
}

echo "</table>";

// ปิด statement และ connection
$stmt->close();
$conn->close();
?>

</body>
</html>
