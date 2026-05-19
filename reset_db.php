<?php
$mysqli = new mysqli("127.0.0.1", "root", "");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($mysqli->query("CREATE DATABASE IF NOT EXISTS ai_crm_v2") === TRUE) {
    echo "Database ai_crm_v2 created successfully.\n";
} else {
    echo "Error creating database: " . $mysqli->error . "\n";
}

$mysqli->close();
?>
