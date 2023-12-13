<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


include "DbCon.php";




$categoryId = $_POST['Category_ID'];
$categoryName = $_POST['Category_Name'];



// Prepare an SQL statement with placeholders
$sql = "INSERT INTO Categories (id, category_name) VALUES (?, ?)";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind parameters and execute the statement
$stmt->bind_param("ss", $categoryId, $categoryName);

if ($stmt->execute()) {
    session_start();
    $_SESSION['success_message'] = "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close(); // Close the prepared statement

header('location: index.php');

?>