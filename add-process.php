<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

if (isset($_POST['tableName']) && isset($_POST['addData'])) {
    $tableName = $_POST['tableName'];
    $columns = [];
    $values = [];

    $query = "DESCRIBE $tableName";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $columnName = $row['Field'];
            if (isset($_POST[$columnName])) {
                $columns[] = $columnName;
                $values[] = $_POST[$columnName];
            }
        }

        if (!empty($columns) && !empty($values)) {
            $columnsStr = implode(', ', $columns);
            $valuesStr = "'" . implode("', '", $values) . "'";

            $insertQuery = "INSERT INTO $tableName ($columnsStr) VALUES ($valuesStr)";
            
            if ($conn->query($insertQuery) === TRUE) {
                echo "Data added successfully.";
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "No data to insert.";
        }
    }
}

$conn->close();
?>
