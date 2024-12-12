<!DOCTYPE html>
<meta charset="UTF-8">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cherry Express - Customer profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Faster+One&display=swap" rel="stylesheet">
    
    <!-- CSS directly in the HTML file -->
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Apply Browalia font except for the logo */
        body {
            font-family: 'Browalia', Arial, sans-serif;
            background-color: #f1a1a1;
            color: white;
        }

        /* Top Bar */
        .top-bar {
            background-color: #333;
            padding: 10px 0;
            text-align: right;
        }

        .top-bar .top-nav {
            list-style: none;
            display: inline-block;
            font-family: 'Browalia', Arial, sans-serif;
        }

        .top-bar .top-nav li {
            display: inline;
            margin-left: 20px;
        }

        .top-bar .top-nav li a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .top-bar .top-nav li a:hover {
            text-decoration: underline;
        }

        /* Logo and Navigation */
        .logo-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }

        .logo h1 {
            font-family: 'Faster One', cursive;
            font-size: 40px;
            color: white;
        }

        .main-nav ul {
            list-style: none;
            font-family: 'Browalia', Arial, sans-serif;
        }

        .main-nav ul li {
            display: inline-block;
            margin-left: 30px;
        }

        .main-nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .main-nav ul li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!--โลโก้ Cherry Express-->
    <div class="logo-nav">
        <div class="logo">
            <h1><a href="home.html">Cherry Express</a></h1>
        </div>
    </div>
    <!-- php -->
    <?
        $name = "Gun Gun";
        $tel = "0987654321";
        $address = "999 bangkok";
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name']))

        {
            if(isset($_POST['tel']) && isset($_POST['address']))
            {
                $name = htmlspecialchars($_POST['name']);
                $tel = htmlspecialchars($_POST['tel']);
                $address = htmlspecialchars($_POST['address']);
            }
        }
    ?>
    <?
        $isediting = isset($_POST['edit']);
    ?>
<? if ($isediting): ?>
    <!-- แสดงฟอร์มแก้ไขถ้าผู้ใช้กด "Edit profile" -->
    <form method="POST">
        <label for="name">Name : </label>
        <input type="text" id="name" name="name" value="<? echo $name; ?>"><br><br>

        <label for="phone">Phone No. : </label>
        <input type="text" id="tel" name="tel" value="<? echo $tel; ?>"><br><br>

        <label for="address">Address : </label>
        <input type="text" id="address" name="address" value="<? echo $address; ?>"><br><br>

        <button type="submit">Save</button>
    </form>
<? else: ?>
    <!-- แสดงชื่อ เบอร์โทร ที่อยู่ และปุ่ม "Edit profile" -->
    <p>Name : <? echo $name; ?></p>
    <p>Phone No. : <? echo $phone; ?></p>
    <p>Address : <? echo $address; ?></p>
    <form method="POST">
        <input type="hidden" name="name" value="<?php echo $name; ?>">
        <input type="hidden" name="tel" value="<?php echo $tel; ?>">
        <button type="submit" name="edit">แก้ไข</button>
    </form>
<? endif; ?>
</body>


</html>