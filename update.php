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

echo "<!DOCTYPE html>
<html>
<head>
    <title>Update Table Data</title>
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
        <h2>Select Table to Update Data</h2>
        <form method='post' action='update.php'>
            <label for='tableName'>Select Table:</label>
            <select name='tableName'>";
while ($row = $tablesResult->fetch_row()) {
    echo "<option value='".$row[0]."'>".$row[0]."</option>";
}
echo "</select><br>
            <input type='submit' value='Select Table'>
        </form>
    </div>
</body>
</html>";

if (isset($_POST['tableName'])) {
    $tableName = $_POST['tableName'];
    $query = "SELECT * FROM $tableName";
    $result = $conn->query($query);

    echo "<div class='container'>
        <h2>Update Data in Table: $tableName</h2>
        <form method='post' action='update-process.php'>
            <input type='hidden' name='tableName' value='$tableName'>";
    while ($row = $result->fetch_assoc()) {
        $recordID = $row['record_ID'];
        echo "<input type='hidden' name='record_ID[]' value='$recordID'>";
        foreach ($row as $column => $value) {
            echo "<label for='$column'>$column:</label>";
            echo "<input type='text' id='$column' name='$column"."[]' value='$value'><br>";
        }
    }
    echo "  <input type='submit' value='Update Data'>
        </form>
    </div>";
}

$conn->close();
?>
