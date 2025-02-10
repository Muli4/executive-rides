function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("open");
}

document.addEventListener("DOMContentLoaded", function () {
    // Get the query parameter from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const carKey = urlParams.get("car");

    // Car data (this can be moved to a separate JSON file or fetched from an API)
    const carData = {
        "toyota-wish": {
            name: "Toyota Wish",
            description: "A high-end luxury sedan perfect for business trips and comfort.",
            price: "KES 4000",
            seats: "7",
            transmission: "Automatic",
            fuel: "Petrol",
            images: ["./cars/wish-side.jpeg", "./cars/wish-back.jpg", "./cars/wish-cabin.jpg", "./cars/wish-cabin1.webp"]
        },
        "toyota-noah": {
            name: "Toyota Noah",
            description: "A fast and stylish sports car for thrill-seekers.",
            price: "KES 5000",
            seats: "7",
            transmission: "Automatic",
            fuel: "Petrol",
            images: ["./cars/noah-front.jpg", "./cars/noah-cabin.jpg", "./cars/noah-cabin1.jpg", "./cars/noah-back.jpg"]
        },
        "toyota-ractis": {
            name: "Toyota Ractis",
            description: "A spacious car, perfect for family trips and travel.",
            price: "KES 300",
            seats: "7",
            transmission: "Automatic",
            fuel: "Diesel",
            images: ["./cars/ractis-front.jpeg", "./cars/ractis-cabin1.jpg", "./cars/ractis-cabin.jpeg","./cars/ractis-back.jpg"]
        }
    };

    // Ensure the selected car exists in data
    if (carKey in carData) {
        const car = carData[carKey];

        // Update HTML content
        document.getElementById("car-name").innerText = car.name;
        document.getElementById("car-description").innerText = car.description;
        document.getElementById("car-price").innerText = car.price;
        document.getElementById("car-seats").innerText = car.seats;
        document.getElementById("car-transmission").innerText = car.transmission;
        document.getElementById("car-fuel").innerText = car.fuel;

        // Load images into slider
        const mainImage = document.getElementById("main-image");
        const thumbnails = document.getElementById("thumbnails");
        mainImage.src = car.images[0]; // Set the first image as main

        // Clear existing thumbnails
        thumbnails.innerHTML = "";

        car.images.forEach((imgSrc, index) => {
            const img = document.createElement("img");
            img.src = imgSrc;
            img.alt = `Car Image ${index + 1}`;
            img.classList.add("thumbnail");

            // Change main image on thumbnail click
            img.addEventListener("click", () => {
                mainImage.src = imgSrc;
            });

            thumbnails.appendChild(img);
        });
    } else {
        // If no valid car is found, show an error or redirect
        document.getElementById("car-detail").innerHTML = "<h2>Car Not Found</h2>";
    }
});
