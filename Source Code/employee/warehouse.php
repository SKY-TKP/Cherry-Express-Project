<?php
include 'db.php'; // Include database connection

// Function to fetch all warehouses with parcel counts
function getWarehouses($conn) {
    $sql = "
        SELECT 
            W.WarehouseID, 
            COUNT(PM.ParcelID) AS ParcelCount
        FROM warehouse_table AS W
        LEFT JOIN employee_table
        ON W.WarehouseID = employee_table.WarehouseID
        LEFT JOIN parcel_table AS PM
        ON PM.EmployeeID = employee_table.EmployeeID
        WHERE W.OperationalStatus = 'Operational'
        GROUP BY W.WarehouseID
        ORDER BY W.WarehouseID
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
    latest_status_table.Status OverallStatus
        FROM warehouse_table AS W
        LEFT JOIN employee_table
        ON W.WarehouseID = employee_table.WarehouseID
        LEFT JOIN parcel_table AS PM
        ON PM.EmployeeID = employee_table.EmployeeID
JOIN (SELECT parcel_status_history_table.ParcelID, parcel_status_history_table.Status
FROM parcel_status_history_table JOIN 
	(SELECT ParcelID ,MAX(Timestamp) latest_timestamp
    FROM parcel_status_history_table
    GROUP BY ParcelID) latest_timestamp_table
ON parcel_status_history_table.ParcelID = latest_timestamp_table.ParcelID
AND parcel_status_history_table.Timestamp = latest_timestamp_table.latest_timestamp
JOIN parcel_table
ON parcel_table.ParcelID = parcel_status_history_table.ParcelID
JOIN order_table ON order_table.OrderID = parcel_table.OrderID JOIN customer_table ON customer_table.CustomerID = order_table.CustomerID
GROUP BY parcel_table.ParcelID) latest_status_table
ON latest_status_table.ParcelID = PM.ParcelID
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
    latest_status_table.Status OverallStatus
        FROM warehouse_table AS W
        LEFT JOIN employee_table
        ON W.WarehouseID = employee_table.WarehouseID
        LEFT JOIN parcel_table AS PM
        ON PM.EmployeeID = employee_table.EmployeeID
JOIN (SELECT parcel_status_history_table.ParcelID, parcel_status_history_table.Status
FROM parcel_status_history_table JOIN 
	(SELECT ParcelID ,MAX(Timestamp) latest_timestamp
    FROM parcel_status_history_table
    GROUP BY ParcelID) latest_timestamp_table
ON parcel_status_history_table.ParcelID = latest_timestamp_table.ParcelID
AND parcel_status_history_table.Timestamp = latest_timestamp_table.latest_timestamp
JOIN parcel_table
ON parcel_table.ParcelID = parcel_status_history_table.ParcelID
JOIN order_table ON order_table.OrderID = parcel_table.OrderID JOIN customer_table ON customer_table.CustomerID = order_table.CustomerID
GROUP BY parcel_table.ParcelID) latest_status_table
ON latest_status_table.ParcelID = PM.ParcelID
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

// Function to search for a parcel and its associated warehouse
function searchParcel($conn, $parcelID) {
    $sql = "
        SELECT 
            W.WarehouseID, 
            PM.ParcelID,
            PM.ReceiverFirstName,
            PM.ReceiverLastName,
            PM.ReceiverAddressLine1,
            PM.ReceiverPostCode
        FROM warehouse_table AS W
        LEFT JOIN employee_table
        ON W.WarehouseID = employee_table.WarehouseID
        LEFT JOIN parcel_table AS PM
        ON PM.EmployeeID = employee_table.EmployeeID
        WHERE PM.ParcelID = '$parcelID';
    ";

    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

// Fetch the list of warehouses and parcels
$selectedWarehouse = isset($_GET['warehouse']) ? $_GET['warehouse'] : 'All';
$warehouses = getWarehouses($conn);
$filteredParcels = getParcelData($conn, $selectedWarehouse);

// Handle search request
$searchResult = null;
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $searchResult = searchParcel($conn, $searchQuery);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#header").load("./include/header.html");
            $("#footer").load("./include/footer.html");
        });
    </script>
    <title>Warehouse Parcel Viewer</title>
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            font-weight: 300;
        }
        .dark-red {
            background-color: #9c0101;
        }
        .dark-red-text {
            color: #9c0101;
        }
        .dark-red-border {
            border-color: #9c0101;
        }
        .bg-red-50 {
            background-color: #f2f2f2 !important;
        }
        button.secondary {
            margin-right: 20px;
            width: 400px;
            height: 50px;
        }
        .search {
            border-radius: 8px;
        }
        .side {
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-red-50 flex flex-col"> <!-- Keeping the light red background -->
    <div id="header"></div>

    <!-- Search Bar -->
    <div class="flex justify-center items-center dark-red text-black p-4 search">
        <form action="" method="GET" class="flex w-full max-w-lg">
        <button type="button" class="secondary" onclick="document.location='./manageWH.php'">Manage Warehouses</button>
            <input 
                type="text" 
                name="search" 
                placeholder="Enter Parcel ID..." 
                class="flex-grow p-2 border border-gray-300 rounded-l-md focus:outline-none"
                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
            />
            <button 
                type="submit" 
                class="dark-red text-white px-4 py-2 rounded-r-md hover:bg-opacity-90"
            >
                Search
            </button>
        </form>
    </div>

    <!-- Search Results -->
    <?php if ($searchResult): ?>
        <div class="p-4 bg-green-100 border border-green-500 rounded-md">
            <h3 class="text-green-800 font-bold text-lg mb-2">Search Result</h3>
            <p><strong>Parcel ID:</strong> <?= $searchResult['ParcelID'] ?></p>
            <p><strong>Warehouse ID:</strong> <?= $searchResult['WarehouseID'] ?></p>
            <p><strong>Receiver Name:</strong> <?= $searchResult['ReceiverFirstName'] . ' ' . $searchResult['ReceiverLastName'] ?></p>
            <p><strong>Receiver Address:</strong> <?= $searchResult['ReceiverAddressLine1'] ?></p>
            <p><strong>Postcode:</strong> <?= $searchResult['ReceiverPostCode'] ?></p>
        </div>
    <?php elseif (isset($_GET['search'])): ?>
        <div class="p-4 bg-red-100 border dark-red-border rounded-md">
            <p class="dark-red-text font-bold">No results found for Parcel ID: <?= htmlspecialchars($_GET['search']) ?></p>
        </div>
    <?php endif; ?>

    <div class="flex flex-row max-h-screen">
        <!-- Sidebar with Warehouse List -->
        <div class="flex flex-col dark-red text-white w-[15%] p-4 side">
            <h3 class="text-white font-semibold text-xl">Warehouses</h3>
            <ul class="overflow-y-scroll">
                <li class="p-2 border-b dark-red-border"><a href="?warehouse=All" class="hover:text-gray-500">All Warehouses</a></li>
                <?php foreach ($warehouses as $warehouse): ?>
                    <li class="p-2 border-b dark-red-border">
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

    <div id="footer"></div>
</body>
</html>
