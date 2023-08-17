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

$query = "SHOW TABLES";
$tablesResult = $conn->query($query);

if ($tablesResult->num_rows > 0) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Add Data</title>
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
            <h2>Select Table to Add Data</h2>
            <form method='post' action='add-data.php'>
                <label for='tableName'>Select Table:</label>
                <select name='tableName'>";
                
    while ($row = $tablesResult->fetch_row()) {
        echo "<option value='".$row[0]."'>".$row[0]."</option>";
    }
    
    echo "</select><br>
                <input type='submit' value='Add Data'>
            </form>
        </div>
    </body>
    </html>";
} else {
    echo "No tables found in the database.";
}

$conn->close();
?>
