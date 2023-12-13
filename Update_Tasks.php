<?php
include "DbCon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['newTaskName']) && isset($_POST['newDescription']) && isset($_POST['newDueDate']) && isset($_POST['newStatus']) && isset($_POST['newCategoryID'])) {
    $id = $_POST['id'];
    $newTaskName = $_POST['newTaskName'];
    $newDescription = $_POST['newDescription'];
    $newDueDate = $_POST['newDueDate'];
    $newStatus = $_POST['newStatus'];
    $newCategoryID = $_POST['newCategoryID'];

    $update_query = "UPDATE tasks SET task_name = ?, description = ?, due_date = ?, status = ?, category_id = ? WHERE Id = ?";
    $stmt = $conn->prepare($update_query);

    if ($stmt) {
        $stmt->bind_param("ssssii", $newTaskName, $newDescription, $newDueDate, $newStatus, $newCategoryID, $id);
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

