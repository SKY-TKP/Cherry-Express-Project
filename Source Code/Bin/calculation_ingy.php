<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>

</head>

<body>
<h1>Shipping cost calculation</h1>

<form action="" method="post">
    <label for="type"> วิธีการจัดส่ง : </label>
    <select id="type" name="type" required>
        <option value="standard" selected> Standard </option>
        <option value="registered"> Registered </option>
        <option value="express"> Express </option>
    </select>
    <br><br>
    <label for="weight">น้ำหนักพัสดุ (กิโลกรัม) :</label>
    <input type="number" id="weight" name="weight" step=0.01 required>
    <br><br>

    <input type="submit" value="calculate">

</form>

<?
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $weight=$_POST["weight"];
        $type=$_POST["type"];
    

        if ($weight <= 0)
        {
        echo "<p style='color: red;'>กรุณากรอกน้ำหนักที่ถูกต้อง</p>";
        }
        else
        {
            switch ($type){
                case "standard":
                    $rate = 15;
                    $base = 5;
                    $type_text = "Standard";
                    break;
                case "registered":
                    $rate = 22;
                    $base = 18;
                    $type_text = "Registered";
                    break;
                case "express":
                    $rate = 29;
                    $base = 32;
                    $type_text = "Express";
                    break;
                default:
                    echo "<p style='color: red;'> กรุณาเลือกวิธีการจัดส่ง</p>";
                    exit;
            }

            if ($weight <= 1){
                $shipping_cost = $base;
            }
            else{
                $shipping_cost = $base + ($weight * $rate);
            }

            echo "<p>ค่าส่งพัสดุ " .number_format($shipping_cost, 2). "บาท .</p>";
        } 
    }
?>

</body>    

</html>