document.addEventListener("DOMContentLoaded", function() {
    const lookupCountryButton = document.getElementById("lookup-country");
    const lookupCitiesButton = document.getElementById("lookup-cities");
    const resultDiv = document.getElementById("result");
    const countryInput = document.getElementById("country");

    // Function to perform the AJAX request
    function fetchData(lookupType) {
        const country = countryInput.value.trim();
        const queryUrl = `world.php?country=${encodeURIComponent(country)}&lookup=${lookupType}`;

        fetch(queryUrl)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data; // Insert response data into the result div
            })
            .catch(error => {
                console.error("Error fetching data:", error);
                resultDiv.innerHTML = "<p>Error retrieving data. Please try again later.</p>";
            });
    }

    // Event listeners for both buttons
    lookupCountryButton.addEventListener("click", function() {
        fetchData(""); // Default lookup for countries
    });

    lookupCitiesButton.addEventListener("click", function() {
        fetchData("cities"); // Lookup for cities
    });
});
