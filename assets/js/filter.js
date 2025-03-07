function applyFilters() {
    let seatFilter = document.getElementById("seatFilter").value;
    let priceFilter = document.getElementById("priceFilter").value;
    let cars = document.querySelectorAll(".car-card");

    cars.forEach(car => {
        let seats = car.getAttribute("data-seats");
        let price = car.getAttribute("data-price");

        let showCar = true;

        if (seatFilter !== "all" && seats !== seatFilter) {
            showCar = false;
        }

        if (priceFilter && parseFloat(price) > parseFloat(priceFilter)) {
            showCar = false;
        }

        car.style.display = showCar ? "block" : "none";
    });
}
