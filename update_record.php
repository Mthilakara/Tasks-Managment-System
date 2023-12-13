<?php
include "DbCon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['newCategoryID']) && isset($_POST['newCategoryName'])) {
    $id = $_POST['id'];
    $newCategoryID = $_POST['newCategoryID'];
    $newCategoryName = $_POST['newCategoryName'];

   
    $update_query = "UPDATE Categories SET Id = ?, category_name = ? WHERE Id = ?";
    $stmt = $conn->prepare($update_query);

    if ($stmt) {
        $stmt->bind_param("ssi", $newCategoryID, $newCategoryName, $id); 
        if ($stmt->execute()) {
            echo "Record updated successfully.";
        } else {
            echo "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
