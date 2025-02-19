<?php
require '../db.php'; // Ensure you have a database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $seats = $_POST['seats'];
    $price = $_POST['price'];
    $fuel_type = $_POST['fuel_type'];
    $transmission = $_POST['transmission'];
    $description = $_POST['description'];
    $status = "Available"; // Default status

    // Handling Image Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['tmp_name'];
        $imageData = file_get_contents($image); // Convert image to binary

        // Prepare SQL Query
        $sql = "INSERT INTO cars (name, brand, seats, price, image, fuel_type, transmission, description, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssidsbsss", $name, $brand, $seats, $price, $imageData, $fuel_type, $transmission, $description, $status);

        if ($stmt->execute()) {
            echo "✅ Car added successfully!";
        } else {
            echo "❌ Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "❌ Error uploading the image!";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car</title>
</head>
<body>
    <h2>Add a New Car</h2>
    <form action="add_car.php" method="POST" enctype="multipart/form-data">
        <label for="name">Car Name:</label>
        <input type="text" name="name" required><br>

        <label for="brand">Brand:</label>
        <input type="text" name="brand" required><br>

        <label for="seats">Seats:</label>
        <input type="number" name="seats" required><br>

        <label for="price">Price:</label>
        <input type="number" name="price" step="0.01" required><br>

        <label for="fuel_type">Fuel Type:</label>
        <select name="fuel_type" required>
            <option value="Petrol">Petrol</option>
            <option value="Diesel">Diesel</option>
            <option value="Electric">Electric</option>
            <option value="Hybrid">Hybrid</option>
        </select><br>

        <label for="transmission">Transmission:</label>
        <select name="transmission" required>
            <option value="Automatic">Automatic</option>
            <option value="Manual">Manual</option>
        </select><br>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea><br>

        <label for="image">Upload Car Image:</label>
        <input type="file" name="image" required><br>

        <button type="submit">Add Car</button>
    </form>
</body>
</html>
