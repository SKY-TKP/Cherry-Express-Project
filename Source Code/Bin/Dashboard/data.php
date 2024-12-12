<?php
// Database connection
$host = "localhost";
$db_name = "d67g9";
$db_username = "d67g9";
$db_password = "d67g9";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "Database connection failed: " . $e->getMessage()]);
    exit;
}

// Validate request
if (isset($_GET['type']) && isset($_GET['date'])) {
    $type = $_GET['type'];
    $date = $_GET['date'];
    $response = [];

    try {
        if ($type === 'daily') {
            $stmt = $pdo->prepare("SELECT HOUR(delivery_time) AS hour, COUNT(*) AS count FROM deliveries WHERE DATE(delivery_time) = :date GROUP BY HOUR(delivery_time)");
            $stmt->execute(['date' => $date]);
            $labels = [];
            $data = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $labels[] = sprintf('%02d:00', $row['hour']);
                $data[] = $row['count'];
            }
            $response = ['labels' => $labels, 'data' => $data];
        } elseif ($type === 'monthly') {
            $stmt = $pdo->prepare("SELECT DAY(delivery_time) AS day, COUNT(*) AS count FROM deliveries WHERE MONTH(delivery_time) = MONTH(:date) AND YEAR(delivery_time) = YEAR(:date) GROUP BY DAY(delivery_time)");
            $stmt->execute(['date' => $date]);
            $labels = [];
            $data = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $labels[] = 'Day ' . $row['day'];
                $data[] = $row['count'];
            }
            $response = ['labels' => $labels, 'data' => $data];
        } elseif ($type === 'yearly') {
            $stmt = $pdo->prepare("SELECT MONTH(delivery_time) AS month, COUNT(*) AS count FROM deliveries WHERE YEAR(delivery_time) = YEAR(:date) GROUP BY MONTH(delivery_time)");
            $stmt->execute(['date' => $date]);
            $labels = [];
            $data = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $labels[] = date('F', mktime(0, 0, 0, $row['month'], 1));
                $data[] = $row['count'];
            }
            $response = ['labels' => $labels, 'data' => $data];
        }
    } catch (PDOException $e) {
        $response = ["error" => "Query failed: " . $e->getMessage()];
    }

    echo json_encode($response);
    exit;
} else {
    echo json_encode(["error" => "Invalid request."]);
    exit;
}
?>
