document.addEventListener("DOMContentLoaded", function() {
    const lookupButton = document.getElementById("lookup");
    const resultDiv = document.getElementById("result");
    const countryInput = document.getElementById("country");

    lookupButton.addEventListener("click", function() {
        const country = countryInput.value.trim(); // get input value
        const queryUrl = `world.php?country=${encodeURIComponent(country)}`;

        // get data from world.php
        fetch(queryUrl)
            .then(response => response.text()) // parse response as text
            .then(data => {
                resultDiv.innerHTML = data; // insert result into div
            })
            .catch(error => {
                console.error("Error:", error);
                resultDiv.innerHTML = "<p>Error fetching data. Please try again later.</p>";
            });
    });
});
