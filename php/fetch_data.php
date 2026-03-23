<?php
$host = "localhost";  
$user = "u534123466_sensors";
$password = "dfsfdcsd5erefdf@cfdfT";
$database = "u534123466_sensors_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT data_time, distance FROM distance_data ORDER BY data_time ASC";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
