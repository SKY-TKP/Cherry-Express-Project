<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cherry Express Logistics Management</title>
    <style>
        /* Apply a blue background and center content */
        body {
            background-color: #e0f7fa;
            font-family: Arial, sans-serif;
            color: #333;
        }

        h1, h2 {
            color: #01579b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 10px;
            border: 1px solid #01579b;
            text-align: left;
        }

        th {
            background-color: #0288d1;
            color: #fff;
        }

        td button {
            padding: 5px 10px;
            background-color: #0288d1;
            color: white;
            border: none;
            cursor: pointer;
        }

        td button:hover {
            background-color: #0277bd;
        }

        /* Form and button styling */
        form {
            background-color: #b3e5fc;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            width: 100%;
            max-width: 500px;
        }

        button {
            background-color: #0288d1;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0277bd;
        }
    </style>
</head>
<body>

    <h1>Cherry Express Logistics and Delivery Management System</h1>

    <!-- Navigation Buttons -->
    <div>
        <button onclick="showSection('login')">Login</button>
        <button onclick="showSection('register')">Register</button>
        <button onclick="showSection('customers')">View Customers</button>
        <button onclick="showSection('employees')">View Employees</button>
        <button onclick="showSection('orders')">View Orders</button>
    </div>

    <!-- Login Section -->
    <section id="login" style="display:none;">
        <h2>Login</h2>
        <form action="/login" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit">Login</button>
        </form>
    </section>

    <!-- Registration Section -->
    <section id="register" style="display:none;">
        <h2>Register</h2>
        <form action="/register" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit">Register</button>
        </form>
    </section>

    <!-- Customers Section -->
    <section id="customers" style="display:none;">
        <h2>Customers</h2>
        <table>
            <tr>
                <th>CustomerID</th>
                <th>Name</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
            <tr>
                <td>CUST001</td>
                <td>John Doe</td>
                <td>+123456789</td>
                <td>johndoe@example.com</td>
                <td>123 Main St, City</td>
                <td><button onclick="viewDetails('customer', 'CUST001')">View Details</button></td>
            </tr>
        </table>
    </section>

    <!-- Employees Section -->
    <section id="employees" style="display:none;">
        <h2>Employees</h2>
        <table>
            <tr>
                <th>EmployeeID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>WarehouseID</th>
                <th>Actions</th>
            </tr>
            <tr>
                <td>EMP001</td>
                <td>Alice Smith</td>
                <td>Delivery</td>
                <td>+987654321</td>
                <td>alice@example.com</td>
                <td>WH001</td>
                <td><button onclick="viewDetails('employee', 'EMP001')">View Details</button></td>
            </tr>
        </table>
    </section>

    <!-- Orders Section -->
    <section id="orders" style="display:none;">
        <h2>Orders</h2>
        <table>
            <tr>
                <th>OrderID</th>
                <th>CustomerID</th>
                <th>Order Date</th>
                <th>Total Price</th>
                <th>Payment Status</th>
                <th>Actions</th>
            </tr>
            <tr>
                <td>ORD001</td>
                <td>CUST001</td>
                <td>2024-10-25</td>
                <td>500</td>
                <td>Paid</td>
                <td><button onclick="viewDetails('order', 'ORD001')">View Details</button></td>
            </tr>
        </table>
    </section>

    <!-- Detail View Section -->
    <section id="details" style="display:none;">
        <h2>Details</h2>
        <div id="details-content">
            <!-- Content will be dynamically loaded here -->
        </div>
        <button onclick="closeDetails()">Close</button>
    </section>

    <script>
        // JavaScript to handle section display
        function showSection(sectionId) {
            document.querySelectorAll("section").forEach(section => {
                section.style.display = "none";
            });
            document.getElementById(sectionId).style.display = "block";
        }

        function viewDetails(type, id) {
            let detailsContent = document.getElementById("details-content");
            detailsContent.innerHTML = `<p>Loading ${type} details for ID: ${id}...</p>`;
            // Simulate fetching detailed data
            setTimeout(() => {
                detailsContent.innerHTML = `
                    <h3>${type.charAt(0).toUpperCase() + type.slice(1)} Details</h3>
                    <p><strong>ID:</strong> ${id}</p>
                    <p><strong>Additional Info:</strong> More detailed information about this ${type}.</p>
                `;
            }, 1000);
            showSection("details");
        }

        function closeDetails() {
            document.getElementById("details").style.display = "none";
        }
    </script>

</body>
</html>