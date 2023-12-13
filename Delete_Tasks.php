<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
Include "Dbcon.php";
if (isset($_GET['ID'])) {
    $id = $_GET['ID'];

    
    $delete_query = "DELETE FROM Tasks WHERE ID = ?";

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

