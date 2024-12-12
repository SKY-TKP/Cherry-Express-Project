<!DOCTYPE html>
<meta charset="utf-8">
<html>
<head>
<title>
    Warehouse Monitor
</title>
</head>
<body>
<h1>
    Warehouse Stock
</h1>
<br>
<form method ="GET" action="">
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
        // กะจะเขียนให้เพิ่ม option โดยดึงข้อมูล warehouse ทั้งหมดจาก database เลย แต่ทำไม่เป็น

        //$sql_warehouse = "SELECT WarehouseID FROM warehouses_table";
        //$result_warehouse = $conn->query($sql_warehouse);
        //if ($result_warehouse->num_rows > 0) {
        //    while ($row = $result_warehouse->fetch_assoc()) {
        //        echo "<option value='" . $row['WarehouseID'] . "'>" . $row['WarehouseID'] . "</option>";
        //    }
        //}
        ?>
    </select>
    <button type="submit">Sort by</button>
</form>
<!-- เชื่อมเข้ากับ database -->
<?php
$servername = "127.0.0.1";
$db_username ="d67g9";
$db_password = "d67g9";
$dbname = "d67g9";
$conn = new mysqli($servername,$db_username,$db_password,$dbname);

//ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error){
    die("Fail to connect to database :" . $conn->connect_error);
}
?>

<!-- รับข้อมูลwarehouseที่เลือกไว้ -->
<?php
$selected_warehouse = isset($_GET['WarehouseID']) ? $_GET['WarehouseID'] : "";

$sql = "SELECT 
            w.WarehouseID ,
            p.ParcelID ,
            p.TrackingNumber, 
            p.Status 
        FROM 
            warehouses_table w
        LEFT JOIN
            parcels_table p ON w.WarehouseID = p.WarehouseID";

if ($selected_warehouse != ""){
    $sql .= " WHERE w.WarehouseID = ?";
}


$sql .= " ORDER BY w.WarehouseID";

$stmt = $conn->prepare($sql);
if ($selected_warehouse != "") {
    $stmt->bind_param("s", $selected_warehouse);
}

$stmt->execute();

$stmt->bind_result($WarehouseID,$ParcelID,$TrackingNumber,$Status);

$result = $stmt->get_result();

echo "<table>" ;
echo "
    <tr>
        <th>Warehouse ID</th>
        <th>Parcel ID</th>
        <th>Tracking number</th>
        <th>Status</th>
    </tr>
    " ;

$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['WarehouseID'] . "</td>";
    echo "<td>" . $row['ParcelID'] . "</td>";
    echo "<td>" . $row['TrackingNumber'] . "</td>";
    echo "<td>" . $row['Status'] . "</td>";
    echo "</tr>";
}
    
echo "</table>";

$stmt->close();
$conn->close();
?>

</body>
</html>