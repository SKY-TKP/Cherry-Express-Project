<?php
$warehouseData = [
    [
        'name' => 'Warehouse 1 (Bangkok)',
        'orders' => [
            ['order_id' => '001', 'order_name' => 'Order 1', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '002', 'order_name' => 'Order 2', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '003', 'order_name' => 'Order 3', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '004', 'order_name' => 'Order 4', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '005', 'order_name' => 'Order 5', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '006', 'order_name' => 'Order 6', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '007', 'order_name' => 'Order 7', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '008', 'order_name' => 'Order 8', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '009', 'order_name' => 'Order 9', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '010', 'order_name' => 'Order 10', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '011', 'order_name' => 'Order 11', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '012', 'order_name' => 'Order 12', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '013', 'order_name' => 'Order 13', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '014', 'order_name' => 'Order 14', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '015', 'order_name' => 'Order 15', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '016', 'order_name' => 'Order 16', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '017', 'order_name' => 'Order 17', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '018', 'order_name' => 'Order 18', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '019', 'order_name' => 'Order 19', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '020', 'order_name' => 'Order 20', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '021', 'order_name' => 'Order 21', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '022', 'order_name' => 'Order 22', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '023', 'order_name' => 'Order 23', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '024', 'order_name' => 'Order 24', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '025', 'order_name' => 'Order 25', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
        ],
    ],
    [
        'name' => 'Warehouse 2 (Pathumwan)',
        'orders' => [
            ['order_id' => '001', 'order_name' => 'Order 1', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '002', 'order_name' => 'Order 2', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
        ],
    ],
    [
        'name' => 'Warehouse 3 (Phayathai)',
        'orders' => [
            ['order_id' => '001', 'order_name' => 'Order 1', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
            ['order_id' => '002', 'order_name' => 'Order 2', 'destination' => 'Thailand', 'duedate' => '2022-05-05', 'status' => 'Pending'],
        ],
    ]
];

function getWarehouseOrders($warehouseData, $tab) {
    if ($tab === "All") {
        return $warehouseData;
    } else {
        foreach ($warehouseData as $warehouse) {
            if ($warehouse['name'] === $tab) {
                return [$warehouse];
            }
        }
    }
    return [];
}

$selectedTab = isset($_GET['tab']) ? $_GET['tab'] : 'All';
$filteredWarehouses = getWarehouseOrders($warehouseData, $selectedTab);
$totalOrders = array_reduce($warehouseData, function($carry, $warehouse) {
    return $carry + count($warehouse['orders']);
}, 0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Browalia', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen ">
    <div class="mt-8 flex flex-row w-[85%] bg-white border border-[#9C0101] h-[90vh] p-8 mx-auto gap-8 shadow-lg rounded-xl">
        <div class="flex flex-col w-[25%]">
            <h1 class="text-xl font-bold mx-auto mb-4 text-[#9C0101]">Warehouses</h1>
            <div class="overflow-y-auto">
                <div class="w-full border border-[#9C0101] px-2 py-2">
                    <a href="?tab=All" class="flex w-full">
                        <div class="cursor-pointer uppercase flex justify-between w-full py-2 
                            <?= $selectedTab === 'All' ? 'text-[#9C0101]' : 'hover:text-[#9C0101]' ?>">
                            <p>All</p>
                            <p class="ml-auto"><?= $totalOrders ?></p>
                        </div>
                    </a>
                </div>
                <?php foreach ($warehouseData as $data): ?>
                    <div class="w-full border border-[#9C0101] px-2 py-2">
                        <a href="?tab=<?= urlencode($data['name']) ?>" class="flex w-full">
                            <div class="cursor-pointer uppercase flex justify-between w-full py-2 
                                <?= $selectedTab === $data['name'] ? 'text-[#9C0101]' : 'hover:text-[#9C0101]' ?>">
                                <p><?= $data['name'] ?></p>
                                <p class="ml-auto"><?= count($data['orders']) ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="w-full border overflow-y-auto border-[#9C0101]">
            <?php if ($selectedTab === 'All'): ?>
                <?php foreach ($filteredWarehouses as $data): ?>
                    <div class="w-full p-4 mx-auto">
                        <div class="flex flex-row mx-auto justify-evenly w-[60%] border py-2 border-[#9C0101] mb-4">
                            <h2 class="font-bold text-[#9C0101]"><?= $data['name'] ?></h2>
                            <div>
                                <p class="font-bold text-[#9C0101]"><?= count($data['orders']) ?> orders</p>
                            </div>
                        </div>
                        <div>
                            <div class="grid grid-cols-5 font-bold mb-2">
                                <p class="mx-auto">Order ID</p>
                                <p class="mx-auto">Order Name</p>
                                <p class="mx-auto">Destination</p>
                                <p class="mx-auto">Due Date</p>
                                <p class="mx-auto">Status</p>
                            </div>
                            <?php foreach ($data['orders'] as $order): ?>
                                <div class="grid grid-cols-5">
                                    <p class="mx-auto"><?= $order['order_id'] ?></p>
                                    <p class="mx-auto"><?= $order['order_name'] ?></p>
                                    <p class="mx-auto"><?= $order['destination'] ?></p>
                                    <p class="mx-auto"><?= $order['duedate'] ?></p>
                                    <p class="mx-auto"><?= $order['status'] ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="w-full p-4 mx-auto">
                    <h2 class="flex flex-row mx-auto justify-evenly w-[60%] border py-2 border-[#9C0101] text-[#9C0101] font-bold mb-4">
                        <span><?= $selectedTab ?></span>
                        <span><?= count($filteredWarehouses[0]['orders']) ?> orders</span>
                    </h2>
                    <div>
                        <div class="grid grid-cols-5 font-bold mb-2">
                            <p class="mx-auto">Order ID</p>
                            <p class="mx-auto">Order Name</p>
                            <p class="mx-auto">Destination</p>
                            <p class="mx-auto">Due Date</p>
                            <p class="mx-auto">Status</p>
                        </div>
                        <?php foreach ($filteredWarehouses[0]['orders'] as $order): ?>
                            <div class="grid grid-cols-5">
                                <p class="mx-auto"><?= $order['order_id'] ?></p>
                                <p class="mx-auto"><?= $order['order_name'] ?></p>
                                <p class="mx-auto"><?= $order['destination'] ?></p>
                                <p class="mx-auto"><?= $order['duedate'] ?></p>
                                <p class="mx-auto"><?= $order['status'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>