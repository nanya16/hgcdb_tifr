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

// Check if the table name is provided in the URL
if (isset($_GET['name'])) {
    $tableName = $_GET['name'];

    // Perform a SELECT query to retrieve data from the specified table
    $query = "SELECT * FROM $tableName";
    $result = $conn->query($query);

    // Check if any records were found
    if ($result->num_rows > 0) {
        // Display the table contents
        echo "<h2>Table: $tableName</h2>";
        echo "<table style='border-collapse: collapse; width: 100%;'>";
        echo "<thead>";
        echo "<tr>";

        // Output column names as table headers
        while ($field = $result->fetch_field()) {
            echo "<th style='border: 1px solid #000; padding: 8px;'>".$field->name."</th>";
        }

        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";

            foreach ($row as $value) {
                echo "<td style='border: 1px solid #000; padding: 8px;'>".$value."</td>";
            }

            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        // No records found
        echo "No records found in the table.";
    }
}
?>
