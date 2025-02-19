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
    let seatFilter = document.getElementById("seatFilter").value;
    let priceFilter = document.getElementById("priceFilter").value;
    let cars = document.querySelectorAll(".car-card");

    cars.forEach(car => {
        let seats = car.getAttribute("data-seats");
        let price = parseFloat(car.getAttribute("data-price"));

        let seatMatch = (seatFilter === "all" || seatFilter == seats);
        let priceMatch = (priceFilter === "" || price <= parseFloat(priceFilter));

        if (seatMatch && priceMatch) {
            car.style.display = "block";
        } else {
            car.style.display = "none";
        }
    });
}