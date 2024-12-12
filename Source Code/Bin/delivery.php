<?php
// Simulate delivery data
$deliveryData = [
    [
        'id' => 1,
        'name' => 'Stop 1',
        'location' => 'International House of Tiramisu Cake 1150 Southwest Upper Highland Portland, OR 97221',
        'distance' => '1.5',
        'time' => 15,
        'orders' => [
            ['id' => 1, 'name' => 'Order 1', 'unit' => 3],
            ['id' => 2, 'name' => 'Order 2', 'unit' => 5],
            ['id' => 3, 'name' => 'Order 3', 'unit' => 1],
        ],
        'customerContact' => [
            'name' => 'Mr. John Doe',
            'phone' => '09x-xxx-xxxx',
        ],
        'payment' => 'Promptpay',
    ],
    [
        'id' => 2,
        'name' => 'Stop 2',
        'location' => 'Chulalongkorn University',
        'distance' => '3.5',
        'time' => 30,
        'orders' => [
            ['id' => 1, 'name' => 'Order 1', 'unit' => 8],
            ['id' => 2, 'name' => 'Order 2', 'unit' => 2],
            ['id' => 3, 'name' => 'Order 3', 'unit' => 5],
        ],
        'customerContact' => [
            'name' => 'Mr. Thomas Doe',
            'phone' => '09x-xxx-xxxx',
        ],
        'payment' => 'Cash',
    ],
    [
        'id' => 3,
        'name' => 'Stop 3',
        'location' => 'Siam Paragon',
        'distance' => '1',
        'time' => 20,
        'orders' => [
            ['id' => 1, 'name' => 'Order 1', 'unit' => 50],
            ['id' => 2, 'name' => 'Order 2', 'unit' => 25],
            ['id' => 3, 'name' => 'Order 3', 'unit' => 12],
        ],
        'customerContact' => [
            'name' => 'Mr. Kungfu Panda',
            'phone' => '09x-xxx-xxxx',
        ],
        'payment' => 'Promptpay',
    ],
    [
        'id' => 4,
        'name' => 'Stop 4',
        'location' => 'Bangkok Hospital',
        'distance' => '4',
        'time' => 35,
        'orders' => [
            ['id' => 1, 'name' => 'Order 1', 'unit' => 10],
            ['id' => 2, 'name' => 'Order 2', 'unit' => 7],
            ['id' => 3, 'name' => 'Order 3', 'unit' => 2],
        ],
        'customerContact' => [
            'name' => 'Ms. Anna Smith',
            'phone' => '09x-xxx-xxxx',
        ],
        'payment' => 'Credit Card',
    ],
    [
        'id' => 5,
        'name' => 'Stop 5',
        'location' => 'Central World',
        'distance' => '2.2',
        'time' => 25,
        'orders' => [
            ['id' => 1, 'name' => 'Order 1', 'unit' => 12],
            ['id' => 2, 'name' => 'Order 2', 'unit' => 6],
            ['id' => 3, 'name' => 'Order 3', 'unit' => 4],
        ],
        'customerContact' => [
            'name' => 'Mr. James Bond',
            'phone' => '09x-xxx-xxxx',
        ],
        'payment' => 'Cash',
    ],
];

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

if ($id < 1 || $id > count($deliveryData)) {
    $id = 1;
}

$currentStop = $deliveryData[$id - 1];

$stopsToGo = count($deliveryData) - $id;
$remainingStops = array_slice($deliveryData, $id);
$totalTime = array_reduce($remainingStops, fn($total, $stop) => $total + $stop['time'], 0);
$totalDistance = array_reduce($remainingStops, fn($total, $stop) => $total + (float)$stop['distance'], 0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Stop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Browalia', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="w-1/4 border border-[#9C0101] bg-white p-6 shadow-lg rounded-md flex flex-col h-[90vh] overflow-y-scroll">
        <p class="text-lg font-bold mb-1 text-[#9C0101]">Stop #<?php echo $id; ?> of <?php echo count($deliveryData); ?></p>

        <div class="mb-1">
            <h3 class="font-semibold text-[#9C0101]">Location</h3>
            <div class="border border-black p-2 h-24 overflow-y-scroll">
                <p><?php echo $currentStop['location']; ?></p>
            </div>
        </div>

        <div class="mb-1">
            <h3 class="font-semibold text-[#9C0101]">Distance / Time (From current location)</h3>
            <div class="border border-black p-2">
                <p><?php echo $currentStop['distance']; ?> km. / <?php echo $currentStop['time']; ?> min.</p>
            </div>
        </div>

        <div class="mb-1">
            <h3 class="font-semibold text-[#9C0101]">Orders</h3>
            <div class="border border-black p-2 h-24 overflow-y-scroll">
                <?php foreach ($currentStop['orders'] as $order) : ?>
                    <div class="flex justify-between">
                        <p><?php echo $order['id']; ?>.</p>
                        <p><?php echo $order['name']; ?></p>
                        <p><?php echo $order['unit']; ?> units</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="mb-1">
            <h3 class="font-semibold text-[#9C0101]">Customer Contact</h3>
            <div class="border border-black p-2">
                <p><?php echo $currentStop['customerContact']['name']; ?></p>
                <p>Tel. <?php echo $currentStop['customerContact']['phone']; ?></p>
            </div>
        </div>

        <div class="mb-1">
            <h3 class="font-semibold text-[#9C0101]">Payment Method</h3>
            <div class="border border-black p-2">
                <p><?php echo $currentStop['payment']; ?></p>
            </div>
        </div>

        <div class="mt-1 flex justify-between">
            <a href="?id=<?php echo max(1, $id - 1); ?>" class="p-2 border border-black rounded-lg <?php echo $id === 1 ? 'opacity-50 cursor-not-allowed' : ''; ?>">Previous</a>
            <a href="?id=<?php echo min(count($deliveryData), $id + 1); ?>" class="p-2 border border-black rounded-lg <?php echo $id === count($deliveryData) ? 'opacity-50 cursor-not-allowed' : ''; ?>">Next</a>
        </div>

        <div class="mt-1 flex justify-between">
            <div>
                <h3><?php echo $stopsToGo; ?> Stops To Go</h3>
                <h4><?php echo $totalTime; ?> min. / <?php echo number_format($totalDistance, 1); ?> km.</h4>
            </div>
            <button class="p-2 border border-[#9C0101] rounded-full text-black">Start Route</button>
        </div>
    </div>
</body>
</html>
