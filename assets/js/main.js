function toggleForm() {
    let loginForm = document.getElementById("login-form");
    let registerForm = document.getElementById("register-form");
    let title = document.getElementById("form-title");

    if (loginForm.style.display === "none") {
        loginForm.style.display = "block";
        registerForm.style.display = "none";
        title.innerText = "Login";
    } else {
        loginForm.style.display = "none";
        registerForm.style.display = "block";
        title.innerText = "Register";
    }
    loginForm.style.opacity = 0;
    registerForm.style.opacity = 0;
    setTimeout(()=>{
        loginForm.style.opacity = 1;
        registerForm.style.opacity = 1;
    }, 200);
}


function applyFilters() {
    let selectedSeats = document.getElementById("seatFilter").value;
    let maxPrice = document.getElementById("priceFilter").value;
    
    let cars = document.querySelectorAll(".car-card");
    cars.forEach(car => {
        let carSeats = car.getAttribute("data-seats");
        let carPrice = car.getAttribute("data-price");

        if ((selectedSeats === "all" || carSeats === selectedSeats) &&
            (maxPrice === "" || parseInt(carPrice) <= parseInt(maxPrice))) {
            car.style.display = "block";
        } else {
            car.style.display = "none";
        }
    });
}
