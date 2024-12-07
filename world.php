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

if ($country) {
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE ?");
    $searchTerm = '%' . $country . '%';
    $stmt->bind_param("s", $searchTerm);
} else {
    $stmt = $conn->prepare("SELECT * FROM countries");
}

// execute the query and get the result
$stmt->execute();
$result = $stmt->get_result();

// generate the HTML output
echo "<ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li>" . htmlspecialchars($row['name']) . " - " . htmlspecialchars($row['head_of_state']) . "</li>";
}
echo "</ul>";

// close connections
$stmt->close();
$conn->close();
?>
