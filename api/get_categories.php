<?php

// Include database connection
include('../database/db.php');
include('../global.php');

// Fetch all categories from the 'categories' table
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

// Validate the result and echo the list of categories
if ($result->num_rows > 0) {
    $categories = array();
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    echo json_encode([
        'status' => 'success',
        'data' => $categories
    ]);
} else {
    echo "No categories found.";
}

// Close the database connection
$conn->close();
