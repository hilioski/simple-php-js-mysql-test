<?php

if ($_POST) {
    $host     = "localhost";
    $username = "username";
    $password = "password";
    $dbName   = "db-name";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // PDO Prepared statement
        $stmt = $conn->prepare("INSERT INTO `raw_events_table` (`date`, `page_session`, `action`, `elementId`, `pageUrl`) VALUES (?, ?, ?, ?, ?)");

        // PDO Execute prepared statement
        $stmt->execute([
            date("Y-m-d H:i:s", $_POST['date']), // format depend on SQL column type (default Y-m-d H:i:s)
            $_POST['page_session'],
            $_POST['action'],
            $_POST['elementId'],
            $_POST['pageUrl'],
        ]);

        echo 'Log event was saved successfully.';
        // Close PDO connection
        $conn = null;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} else {
    echo 'Access denied.';
}