<?php
var_dump($_POST);
include 'DbCon.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $taskName = $_POST['Tasks_Name']; 
    $description = $_POST['Description']; 
    $dueDate = $_POST['dueDate']; 
    $status = $_POST['status']; 
    $categoryId = $_POST['categoryId']; 

    
    $sql = "INSERT INTO tasks (task_name, description, due_date, status, category_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("sssss", $taskName, $description, $dueDate, $status, $categoryId);


    if ($stmt->execute()) {
        session_start();
        $_SESSION['success_message'] = "Task added successfully!";
        header("Location: index.php"); 
        exit();
    } else {
        echo "Error adding task: " . $stmt->error;
    }

    
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
