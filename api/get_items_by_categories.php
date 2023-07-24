<?php
// Include database connection
include('../database/db.php');
include('../global.php');

// Check if the category_id is provided through GET method
if (!isset($_GET['category_id'])) {
    echo "Error: category_id not provided.";
    exit;
}

// Validate and sanitize the category_id
$category_id = filter_var($_GET['category_id'], FILTER_VALIDATE_INT);
if ($category_id === false || $category_id <= 0) {
    $sql = "SELECT * FROM items";
} else {
    // Fetch items for the given category_id from the 'items' table
    $sql = "SELECT * FROM items WHERE category_id = $category_id";
}

$result = $conn->query($sql);

// Validate the result and echo the list of items for the given category_id
if ($result->num_rows > 0) {
    $items = array();
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    echo json_encode([
        'status' => 'success',
        'data' => $items
    ]);
} else {
    echo "No items found for the given category.";
}

// Close the database connection
$conn->close();