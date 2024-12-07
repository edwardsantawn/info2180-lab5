<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

// connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// get country parameter from the GET request
$country = isset($_GET['country']) ? $_GET['country'] : '';
$lookup = isset($_GET['lookup']) ? $_GET['lookup'] : '';

// Handle Lookup for Cities
if ($lookup === 'cities') {
    $stmt = $conn->prepare("
        SELECT cities.name AS city_name, cities.district, cities.population
        FROM cities
        JOIN countries ON cities.country_code = countries.code
        WHERE countries.name LIKE ?
    ");
    $searchTerm = '%' . $country . '%';
    $stmt->bind_param("s", $searchTerm);
} else {
    // Default: Lookup for Country Information
    if ($country) {
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE ?");
        $searchTerm = '%' . $country . '%';
        $stmt->bind_param("s", $searchTerm);
    } else {
        $stmt = $conn->prepare("SELECT * FROM countries");
    }
}

// execute the query and get the result
$stmt->execute();
$result = $stmt->get_result();

// generate HTML Output
if ($lookup === 'cities') {
    // output Cities in an HTML Table
    echo "<table border='1'>";
    echo "<tr><th>Name</th><th>District</th><th>Population</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['city_name']) . "</td>
                <td>" . htmlspecialchars($row['district']) . "</td>
                <td>" . htmlspecialchars($row['population']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    // output Countries in an HTML List
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($row['name']) . " - " . htmlspecialchars($row['head_of_state']) . "</li>";
    }
    echo "</ul>";
}

// close connections
$stmt->close();
$conn->close();
?>
