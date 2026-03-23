<?php
require_once 'php/config.php';

// Reset old records where response_date is older than 2 mins
$reset_sql = "UPDATE phonenumbers 
              SET site = NULL, Status = NULL 
              WHERE response_date < NOW() - INTERVAL 2 MINUTE";

if ($conn->query($reset_sql)) {
    echo "Reset successful.";
} else {
    error_log("Reset query failed: " . $conn->error);
}

$conn->close();
?>
