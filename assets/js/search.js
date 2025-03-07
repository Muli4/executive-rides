function searchCar() {
    let query = document.getElementById("search").value;
    let searchResults = document.getElementById("search-results");

    if (query.length < 1) {
        searchResults.innerHTML = "";
        return;
    }

    fetch(`./pages/search.php?query=${query}`)
        .then(response => response.json())
        .then(data => {
            searchResults.innerHTML = ""; // Clear previous results
            data.forEach(car => {
                let div = document.createElement("div");
                div.classList.add("search-item");
                div.textContent = car.name;
                div.onclick = function() {
                    window.location.href = `view_car.php?id=${car.id}`;
                };
                searchResults.appendChild(div);
            });
        })
        .catch(error => console.error("Error:", error));
}
