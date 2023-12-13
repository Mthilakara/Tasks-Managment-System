<?php

include "DbCon.php";

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];

   
    $delete_query = "DELETE FROM Categories WHERE ID = ?";

   
    $stmt = $conn->prepare($delete_query);

 
    $stmt->bind_param("i", $id); 

   
    if ($stmt->execute()) {
        session_start();
        $_SESSION['success_message'] = "Record deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

   
    $stmt->close();

    header('Location: index.php');
    exit;
} else {
    echo "No ID specified for deletion.";
}
?>

