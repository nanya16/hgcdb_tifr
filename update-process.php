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

if (isset($_POST['tableName'], $_POST['record_ID'])) {
    $tableName = $_POST['tableName'];
    $recordIDs = $_POST['record_ID'];

    foreach ($recordIDs as $index => $recordID) {
        $updateQuery = "UPDATE $tableName SET ";
        foreach ($_POST as $field => $values) {
            if ($field !== 'tableName' && $field !== 'record_ID') {
                $value = $conn->real_escape_string($values[$index]);
                $updateQuery .= "`$field` = '$value', ";
            }
        }
        $updateQuery = rtrim($updateQuery, ', ') . " WHERE `record_ID` = $recordID";

        $result = $conn->query($updateQuery);

        if (!$result) {
            echo "Error updating record with ID $recordID: " . $conn->error;
        } else {
            echo "Record with ID $recordID updated successfully.<br>";
        }
    }
}

$conn->close();
?>
