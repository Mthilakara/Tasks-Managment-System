<?php
include 'DbCon.php';
var_dump($_POST);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addTasks'])) {
        $taskName = $_POST['TasksName'];
        $description = $_POST['description'];
        $dueDate = $_POST['dueDate'];
        $status = $_POST['status'];
        $categoryId = $_POST['categoryId'];

        

        $sql = "INSERT INTO tasks (task_name, description, due_date, status, category_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("sssss", $taskName, $description, $dueDate, $status, $categoryId);
        if ($stmt->execute()) {
            echo "Task added successfully!";
        } else {
            echo "Error adding task: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['updateTasks'])) {
        $taskId = $_POST['taskId'];
        $newTaskName = $_POST['newTasksName'];
        $newDescription = $_POST['newDescription'];
        $newDueDate = $_POST['newDueDate'];
        $newStatus = $_POST['newStatus'];
        $newCategoryId = $_POST['newCategoryId'];

        $sql = "UPDATE tasks SET task_name = ?, description = ?, due_date = ?, status = ?, category_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("sssssi", $newTaskName, $newDescription, $newDueDate, $newStatus, $newCategoryId, $taskId);
        if ($stmt->execute()) {
            echo "Task updated successfully!";
        } else {
            echo "Error updating task: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['deleteTasks'])) {
        $taskId = $_POST['taskId'];

        $sql = "DELETE FROM tasks WHERE id = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("i", $taskId);
        if ($stmt->execute()) {
            echo "Task deleted successfully!";
        } else {
            echo "Error deleting task: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "No action specified!";
    }
}

$conn->close();
?>
