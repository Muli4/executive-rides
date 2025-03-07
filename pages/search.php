<?php
include '../config/db.php';

if (isset($_GET['query'])) {
    $search = $conn->real_escape_string($_GET['query']);
    
    $sql = "SELECT id, name FROM cars WHERE name LIKE '%$search%' LIMIT 10";
    $result = $conn->query($sql);

    $cars = [];
    while ($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }

    echo json_encode($cars);
}
?>
