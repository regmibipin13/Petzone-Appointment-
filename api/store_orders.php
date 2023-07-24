<?php
// Include database connection
include('../database/db.php');
include('../global.php');

// Function to extract user_id from the token
function getUserIDFromToken($token)
{
    global $conn;

    $token = $conn->real_escape_string($token);

    $sql = "SELECT user_id FROM api_tokens WHERE token = '$token'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['user_id'];
    } else {
        return null; // Token not found or expired.
    }

    $conn->close();
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract data from the POST request
    $token = $_POST['token']; // Assuming the token is sent in the request.
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $payment_method = $_POST['payment_method'];

    // Validate and sanitize inputs
    $item_id = filter_var($item_id, FILTER_VALIDATE_INT);
    $quantity = filter_var($quantity, FILTER_VALIDATE_INT);
    $payment_method = filter_var($payment_method, FILTER_SANITIZE_STRING);

    if ($item_id === false || $item_id <= 0 || $quantity === false || $quantity <= 0 || empty($payment_method)) {
        echo "Error: Invalid input data.";
        exit;
    }

    // Extract user_id from the token
    $user_id = getUserIDFromToken($token);

    if ($user_id === null) {
        echo "Error: Invalid or expired token.";
        exit;
    }

    $item_id = $conn->real_escape_string($item_id);

    $sql = "SELECT price FROM items WHERE id = '$item_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $price = $row['price'];
        $total_price = $quantity * $price;
    } else {
        echo "Error: Item not found.";
        exit;
    }

    // Insert the order into the 'orders' table
    $sql = "INSERT INTO orders (user_id, item_id, quantity, price, total_price, payment_method, date)
            VALUES ('$user_id', '$item_id', '$quantity', '$price', '$total_price', '$payment_method', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Order stored successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "Error: Invalid request method.";
}
