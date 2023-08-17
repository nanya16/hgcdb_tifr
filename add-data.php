<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'hgcdb_tifr';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['tableName'])) {
    $tableName = $_POST['tableName'];

    $query = "DESCRIBE $tableName";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Add Data - $tableName</title>
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
            input[type='text'] {
                width: 100%;
                padding: 12px;
                margin-bottom: 20px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }
            input[type='submit'] {
                background-color: #4CAF50;
                color: #fff;
                padding: 12px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                width: 100%;
            }
            input[type='submit']:hover {
                background-color: #45a049;
            }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>Add Data to Table: $tableName</h2>
                <form method='post' action='add-process.php'>";
                
        while ($row = $result->fetch_assoc()) {
            $columnName = $row['Field'];
            echo "<label for='$columnName'>$columnName:</label>";
            echo "<input type='text' id='$columnName' name='$columnName'><br>";
        }
        
        echo "      <input type='hidden' name='tableName' value='$tableName'>
                    <input type='submit' name='addData' value='Add Data'>
                </form>
            </div>
        </body>
        </html>";
    } else {
        echo "No columns found in the table.";
    }
}

$conn->close();
?>
