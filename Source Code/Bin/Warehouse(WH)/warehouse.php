<?php
include 'db.php'; // Include database connection

// Function to fetch all warehouses with parcel counts
function getWarehouses($conn) {
    $sql = "
        SELECT 
            W.WarehouseID, 
            COUNT(PM.ParcelID) AS ParcelCount
        FROM warehouse_table AS W
        LEFT JOIN parcel_table AS PM
        ON PM.ReceiverPostCode = W.Postcode
        GROUP BY W.WarehouseID
        ORDER BY W.WarehouseID;
    ";

    $warehouses = $conn->query($sql);
    $result = [];
    while ($warehouse = $warehouses->fetch_assoc()) {
        $result[] = $warehouse;
    }
    return $result;
}

// Function to fetch parcels based on the selected warehouse
function getParcelData($conn, $warehouseID) {
    if ($warehouseID === "All") {
        $sql = "
            SELECT
                W.WarehouseID,
                PM.ParcelID,
                PM.EmployeeID,
                PM.OrderID,
                PM.TrackingNumber,
                PM.ReceiverFirstName,
                PM.ReceiverLastName,
                PM.ReceiverAddressLine1,
                PM.ReceiverPostCode,
                PM.OverallStatus
            FROM parcel_table AS PM
            JOIN warehouse_table AS W
            ON PM.ReceiverPostCode = W.Postcode
            GROUP BY PM.ParcelID
            ORDER BY W.WarehouseID, PM.ParcelID;
        ";
    } else {
        $sql = "
            SELECT
                W.WarehouseID,
                PM.ParcelID,
                PM.EmployeeID,
                PM.OrderID,
                PM.TrackingNumber,
                PM.ReceiverFirstName,
                PM.ReceiverLastName,
                PM.ReceiverAddressLine1,
                PM.ReceiverPostCode,
                PM.OverallStatus
            FROM parcel_table AS PM
            JOIN warehouse_table AS W
            ON PM.ReceiverPostCode = W.Postcode
            WHERE W.WarehouseID = '$warehouseID'
            GROUP BY PM.ParcelID
            ORDER BY W.WarehouseID, PM.ParcelID;
        ";
    }

    $parcels = $conn->query($sql);
    $result = [];
    while ($parcel = $parcels->fetch_assoc()) {
        $result[] = $parcel;
    }
    return $result;
}

// Fetch the list of warehouses and parcels
$selectedWarehouse = isset($_GET['warehouse']) ? $_GET['warehouse'] : 'All';
$warehouses = getWarehouses($conn);
$filteredParcels = getParcelData($conn, $selectedWarehouse);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Warehouse Parcel Viewer</title>
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            font-weight: 300;
        }
    </style>
</head>
<body class="bg-red-50 flex flex-col"> <!-- Light red background for the body -->

    <section class="relative h-[50vh] bg-cover bg-center" style="background-image: url('http://win.ie.eng.chula.ac.th/~thursday2024/d9/Cherry%20Express%20Project/employee/image/thumbnail/1.png');">
        <div class="absolute inset-0 bg-black bg-opacity-60 hover:bg-opacity-65 duration-100 flex items-center justify-center">
            <h1 class="text-white text-4xl font-bold">Welcome to Cherry Logistics</h1>
        </div>
    </section>

    <div class="flex flex-row max-h-screen">
        <!-- Sidebar with Warehouse List -->
        <div class="flex flex-col bg-red-600 text-white w-[15%] p-4"> <!-- Light red background for sidebar -->
            <h3 class="text-white font-semibold text-xl">Warehouses</h3>
            <ul class="overflow-y-scroll">
                <li class="p-2 border-b border-red-300"><a href="?warehouse=All" class="hover:text-gray-500">All Warehouses</a></li>
                <?php foreach ($warehouses as $warehouse): ?>
                    <li class="p-2 border-b border-red-300">
                        <a href="?warehouse=<?= $warehouse['WarehouseID'] ?>" class="hover:text-gray-500">
                            <?= $warehouse['WarehouseID'] ?> (<?= $warehouse['ParcelCount'] ?>)
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div class="p-4 overflow-y-auto">
            <h3 class="text-black font-bold text-2xl mb-4">Parcels for Warehouse: <?= $selectedWarehouse ?></h3>
            <table class="table-auto text-black">
                <thead class="bg-red-200">
                    <tr>
                        <th class="p-2 text-center">Warehouse ID</th>
                        <th class="p-2 text-center">Parcel ID</th>
                        <th class="p-2 text-center">Employee ID</th>
                        <th class="p-2 text-center">Order ID</th>
                        <th class="p-2 text-center">Tracking Number</th>
                        <th class="p-2 text-center">Receiver First Name</th>
                        <th class="p-2 text-center">Receiver Last Name</th>
                        <th class="p-2 text-center">Receiver Address</th>
                        <th class="p-2 text-center">Postcode</th>
                        <th class="p-2 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($filteredParcels)): ?>
                        <?php foreach ($filteredParcels as $parcel): ?>
                            <tr class="hover:bg-red-100">
                                <td class="p-2"><?= $parcel['WarehouseID'] ?></td>
                                <td class="p-2"><?= $parcel['ParcelID'] ?></td>
                                <td class="p-2"><?= $parcel['EmployeeID'] ?></td>
                                <td class="p-2"><?= $parcel['OrderID'] ?></td>
                                <td class="p-2"><?= $parcel['TrackingNumber'] ?></td>
                                <td class="p-2"><?= $parcel['ReceiverFirstName'] ?></td>
                                <td class="p-2"><?= $parcel['ReceiverLastName'] ?></td>
                                <td class="p-2"><?= $parcel['ReceiverAddressLine1'] ?></td>
                                <td class="p-2"><?= $parcel['ReceiverPostCode'] ?></td>
                                <td class="p-2"><?= $parcel['OverallStatus'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center p-4">No parcels found for this warehouse.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
