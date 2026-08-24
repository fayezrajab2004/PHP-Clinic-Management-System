<?php

// الاتصال على الداتا بيز
$conn = new mysqli("localhost", "root", "", "hospital_rebuilt");

if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    exit("Database connection failed.");
}

if (!$conn->set_charset('utf8mb4')) {
    error_log("Unable to set database charset: " . $conn->error);
    exit("Database configuration error.");
}
?>
