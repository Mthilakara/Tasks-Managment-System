<?php
include 'DbCon.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addCategory'])) {
        $categoryId = $_POST['categoryId'];
        $categoryName = $_POST['categoryName'];

        
        $sql = "INSERT INTO Categories (id, category_name) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ss", $categoryId, $categoryName);
        if ($stmt->execute()) {
            echo "Category added successfully!";
        } else {
            echo "Error adding category: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['updateCategory'])) {
        $categoryId = $_POST['categoryId'];
        $newCategoryName = $_POST['newCategoryName'];

       
        $sql = "UPDATE Categories SET category_name = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ss", $newCategoryName, $categoryId);
        if ($stmt->execute()) {
            echo "Category updated successfully!";
        } else {
            echo "Error updating category: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['deleteCategory'])) {
        $categoryId = $_POST['categoryId'];

       
        $sql = "DELETE FROM Categories WHERE id = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $categoryId);
        if ($stmt->execute()) {
            echo "Category deleted successfully!";
        } else {
            echo "Error deleting category: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "No action specified!";
    }
}

$conn->close();
?>
