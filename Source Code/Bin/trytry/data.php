<?php
session_start();

if (isset($_GET['type']) && isset($_GET['date'])) {
    $type = $_GET['type'];
    $date = $_GET['date'];
    $response = [];

    if ($type === 'daily') {
        $response = generateDailyData();
    } elseif ($type === 'monthly') {
        $response = generateMonthlyData($date);
    } elseif ($type === 'yearly') {
        $response = generateYearlyData();
    }

    echo json_encode($response);
    exit;
}

function generateDailyData() {
    return [
        'labels' => ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM', '5:00 PM'],
        'data' => array_map(fn() => rand(100, 500), range(1, 10))
    ];
}

function generateMonthlyData($date) {
    $daysInMonth = date('t', strtotime($date));
    return [
        'labels' => array_map(fn($day) => "Day $day", range(1, $daysInMonth)),
        'data' => array_map(fn() => rand(500, 1000), range(1, $daysInMonth))
    ];
}

function generateYearlyData() {
    return [
        'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        'data' => array_map(fn() => rand(10000, 20000), range(1, 12))
    ];
}
?>
