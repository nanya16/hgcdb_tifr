<?php
$host = 'localhost';       // Hostname (usually 'localhost' for local development)
$user = 'root';            // MySQL username (default is 'root')
$password = '';            // MySQL password (default is blank or 'root')
$database = 'hgcdb_tifr';  // Name of the database you created

// Create a connection object
$conn = new mysqli($host, $user, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if (isset($_POST['action']) && $_POST['action'] === 'view_table') {
    // Get the selected table name
    $tableName = $_POST['tableName'];

    // Redirect to the view table page
    header("Location: table.php?name=$tableName");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Tables</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Tables</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="tableName">Select Table:</label>
            <select name="tableName">
                <?php
                // Perform a SHOW TABLES query to retrieve table names
                $query = "SHOW TABLES";
                $result = $conn->query($query);

                // Check if any tables were found
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_row()) {
                        echo "<option value='".$row[0]."'>".$row[0]."</option>";
                    }
                }
                ?>
            </select><br>
            <input type="hidden" name="action" value="view_table">
            <input type="submit" value="View Table Data">
        </form>
        <form method="post" action="main.php">
            <input type="submit" value="Go to Main Page">
        </form>
    </div>
</body>
</html>
