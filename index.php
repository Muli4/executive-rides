<?php

include './db.php';
session_start();

// select the available cars

$sql = "SELECT * FROM cars WHERE status = 'available'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
</head>
<body>
    <header>
        <nav>
            <?php if(isset($_SESSION['user_id'])):?>
                <a href="rentals.php">My rentals</a>
                <a href="logout.php">logout</a>
            <?php else: ?>
                <a href="./pages/auth.php"></a>
            <?php endif ; ?>
        </nav>
    </header>

    <section class="cars">
        <?php while($car = $result->fetch_assoc()): ?>
            <div class="car-card">
                <img src="images/<?php echo $car['image']; ?>" alt="<?php echo $car['name']; ?>">
                <h3><?php echo $car["name"] ;?></h3>
                <p><?php echo $car["description"]; ?></p>
                <p><strong>Price:$<?php echo $car["price"];?>/day</strong></p>
                <a href="<?php echo isset($_SESSION["user_id"]) ? 'rent.php?id='.$car['id'] : 'auth.php'; ?>" class="rent-btn">Rent Now</a>
            </div>
        <?php endwhile; ?>
    </section>
</body>
</html>