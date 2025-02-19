<?php
include 'db.php';
session_start();

// Fetch cars from the database
$sql = "SELECT * FROM cars ORDER BY seats ASC";
$result = $conn->query($sql);

// Group cars by seat sizes
$cars_by_seats = [];
while ($car = $result->fetch_assoc()) {
    $cars_by_seats[$car["seats"]][] = $car;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Executive Rides</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

<!-- 🌟 Navigation Bar -->
<header>
    <h1>Executive Rides</h1>
    <nav>
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
        <?php if(isset($_SESSION["user_id"])): ?>
            <a href="rentals.php">My Rentals</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="./pages/auth.php">Login</a>
        <?php endif; ?>
    </nav>
</header>

<div class="main-content">
    <!-- 🚘 Car Filtering Section -->
<section id="filters">
    <h2>Filter Cars</h2>
    <label for="seatFilter">Seats:</label>
    <select id="seatFilter">
        <option value="all">All</option>
        <option value="4">4-Seater</option>
        <option value="7">7-Seater</option>
        <option value="10">10-Seater</option>
    </select>

    <label for="priceFilter">Max Price ($/day):</label>
    <input type="number" id="priceFilter" placeholder="Enter price">
    <button onclick="applyFilters()">Apply Filters</button>
</section>

<!-- 🚗 Car Listings Section -->
<section id="cars">
    <?php foreach ($cars_by_seats as $seats => $cars): ?>
        <h2><?php echo $seats; ?>-Seater Cars</h2>
        <div class="car-container">
            <?php foreach ($cars as $car): ?>
                <div class="car-card" data-seats="<?php echo $car['seats']; ?>" data-price="<?php echo $car['price']; ?>">
                    <img src="images/<?php echo $car['image']; ?>" alt="<?php echo $car['name']; ?>">
                    <h3><?php echo $car["name"]; ?></h3>
                    <p><?php echo $car["description"]; ?></p>
                    <p><strong>Price: $<?php echo $car["price"]; ?>/day</strong></p>
                    <a href="view_car.php?id=<?php echo $car['id']; ?>" class="view-btn">View Details</a>
                    <a href="<?php echo isset($_SESSION["user_id"]) ? 'rent.php?id='.$car['id'] : 'auth.php'; ?>" class="rent-btn">Rent Now</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</section>

<!-- 📞 Contact Section -->
<section id="contact">
    <h2>Contact Us</h2>
    <p>Email: support@executiverides.com</p>
    <p>Phone: +123 456 7890</p>
    <p>Location: 123 Luxury Street, Car City</p>
</section>
</div>

<!-- 🔥 Footer -->
<footer>
    <p>&copy; 2025 Executive Rides. All Rights Reserved.</p>
    <p>Follow us on:
        <a href="#">Facebook</a> | <a href="#">Twitter</a> | <a href="#">Instagram</a>
    </p>
</footer>

<script src="./assets/js/main.js"></script>
</body>
</html>
