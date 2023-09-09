<?php

function insert_tabel_demo($tabel = '', $data = array())
{
    include WWWROOT."/api/encrypt.php";
    include WWWROOT."/_configs/global.php";
    $pw = dekrip($pass);
    $mysqli = new mysqli($host, $user, $pw, $name);

    // Check connection status
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Prepare the INSERT statement using prepared statement
    $columns = implode(', ', array_keys($data));
    $values = implode(', ', array_fill(0, count($data), '?'));

    $sql = "INSERT INTO $tabel ($columns) VALUES ($values)";
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        echo "Error preparing the statement: " . $mysqli->error;
        $mysqli->close();
        return false;
    }

    // Bind parameters and execute the statement
    $types = str_repeat('s', count($data)); // Assuming all values are strings, adjust as needed
    $stmt->bind_param($types, ...array_values($data));
    $result = $stmt->execute();

    if (!$result) {
        echo "Error executing the statement: " . $stmt->error;
    } else {
    }

    // Close the statement and connection
    $stmt->close();
    $mysqli->close();

    return $result;
};
