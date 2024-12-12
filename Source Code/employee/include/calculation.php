<?php
require_once("./connection.php");
$query = 'SELECT * FROM box_type_table';
$stmt = $pdo->query($query);
$box = $stmt->fetchAll(PDO::FETCH_ASSOC);

function calculatePrice($deliveryMethod, $weight, $length, $width, $height) {
    // Delivery method pricing rules
    $deliveryPricing = [
        'Registered' => ['base_price' => 5, 'price_multiplier' => 1],
        'Standard'   => ['base_price' => 10, 'price_multiplier' => 2],
        'Express'    => ['base_price' => 20, 'price_multiplier' => 3]
    ];

    // Check if the delivery method is valid
    if (!array_key_exists($deliveryMethod, $deliveryPricing)) {
        throw new Exception('Invalid delivery method');
    }

    // Get delivery price for the selected delivery method
    $basePrice = $deliveryPricing[$deliveryMethod]['base_price'];
    $priceMultiplier = $deliveryPricing[$deliveryMethod]['price_multiplier'];

    // Calculate the delivery price
    $deliveryPrice = $basePrice + ($weight * $priceMultiplier);

    // Connect to the database (use your database credentials)
    // Query to retrieve all box type data
    global $box;

    $selectedBox = null;

    // Loop through each box type to find the first box that fits the item
    foreach ($box as $row) {
        $boxWeight = $row['Weight'];
        $boxWidth = $row['Width'];
        $boxLength = $row['Length'];
        $boxHeight = $row['Height'];

        // Check if the package fits in the box for any orientation
        $fits = 
            ($weight <= $boxWeight && $length <= $boxLength && $width <= $boxWidth && $height <= $boxHeight) ||
            ($weight <= $boxWeight && $length <= $boxLength && $height <= $boxWidth && $width <= $boxHeight) ||
            ($weight <= $boxWeight && $width <= $boxLength && $length <= $boxWidth && $height <= $boxHeight) ||
            ($weight <= $boxWeight && $width <= $boxLength && $height <= $boxWidth && $length <= $boxHeight) ||
            ($weight <= $boxWeight && $height <= $boxLength && $length <= $boxWidth && $width <= $boxHeight) ||
            ($weight <= $boxWeight && $height <= $boxLength && $width <= $boxWidth && $length <= $boxHeight);
        
        if ($fits) {
            $selectedBox = $row;
            break; // Use the first matching box
        }
    }


    if ($selectedBox === null) {
        throw new Exception('No suitable box found for the given dimensions and weight.');
    }

    // Get the delivery price of the selected box
    $boxDeliveryPrice = $selectedBox['DeliveryPrice'];

    // Calculate the total price
    $totalPrice = $boxDeliveryPrice + $deliveryPrice;

    return [
        'BoxType' => $selectedBox['BoxType'],
        'BoxSize' => $selectedBox['BoxSize'],
        'WeightLimit' => $selectedBox['Weight'],
        'Dimensions' => [
            'Width'  => $selectedBox['Width'],
            'Length' => $selectedBox['Length'],
            'Height' => $selectedBox['Height']
        ],
        'BoxDeliveryPrice' => $boxDeliveryPrice,
        'DeliveryPrice' => $deliveryPrice,
        'TotalPrice' => $totalPrice
    ];
}

// // Example usage
// $weight = 2;     // Example weight in kg
// $length = 30;    // Length of the parcel in cm
// $width = 20;     // Width of the parcel in cm
// $height = 15;    // Height of the parcel in cm
// $deliveryMethod = 'Express'; // Example delivery method

// $priceDetails = calculatePrice($weight, $length, $width, $height, $deliveryMethod);
// print_r($priceDetails);

function calculatePriceByBox($deliveryType, $weight, $boxType) {
    // Delivery method pricing rules
    $deliveryPricing = [
        'Registered' => ['base_price' => 5, 'price_multiplier' => 1],
        'Standard'   => ['base_price' => 10, 'price_multiplier' => 2],
        'Express'    => ['base_price' => 20, 'price_multiplier' => 3]
    ];

    // Check if the delivery type is valid
    if (!array_key_exists($deliveryType, $deliveryPricing)) {
        throw new Exception('Invalid delivery method');
    }

    // Get delivery price for the selected delivery method
    $basePrice = $deliveryPricing[$deliveryType]['base_price'];
    $priceMultiplier = $deliveryPricing[$deliveryType]['price_multiplier'];

    // Calculate the delivery price
    $deliveryPrice = $basePrice + ($weight * $priceMultiplier);

    // Connect to the database (use your database credentials)
    // Query to retrieve all box type data
    global $box;

    $selectedBox = null;

    // Loop through each box type to find the first box that matches the provided box type
    foreach ($box as $row) {
        if ($row['BoxType'] === $boxType) {
            $selectedBox = $row;
            break; // Use the first matching box
        }
    }

    if ($selectedBox === null) {
        throw new Exception('No suitable box found for the given box type.');
    }

    // Get the delivery price of the selected box
    $boxDeliveryPrice = $selectedBox['DeliveryPrice'];

    // Calculate the total price
    $totalPrice = $boxDeliveryPrice + $deliveryPrice;

    return [
        'BoxType' => $selectedBox['BoxType'],
        'BoxSize' => $selectedBox['BoxSize'],
        'WeightLimit' => $selectedBox['Weight'],
        'Dimensions' => [
            'Width'  => $selectedBox['Width'],
            'Length' => $selectedBox['Length'],
            'Height' => $selectedBox['Height']
        ],
        'BoxDeliveryPrice' => $boxDeliveryPrice,
        'DeliveryPrice' => $deliveryPrice,
        'TotalPrice' => $totalPrice
    ];
}
