<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Task Management System</title>
  <link rel="stylesheet" href="styles.css"> 
</head>
<body>

<script>
window.addEventListener('scroll', function() {
  var element = document.querySelector('.animate-scroll');
  var position = element.getBoundingClientRect().top;
  var windowHeight = window.innerHeight;

  if (position < windowHeight / 1.5) {
    element.style.opacity = '1';
  } else {
    element.style.opacity = '0';
  }
});
</script>

  <h1>Task Management System</h1>

  <!-- Category Details Form -->

  <form class="category-actions" action="handle_categories.php" method="POST">
  <div class="category-details">
    <h2>Category Details</h2>
    <label for="categoryName">Category Name:</label>
    <input type="text" id="categoryName" name="categoryName" required>

    <label for="categoryId">Category ID:</label>
    <input type="text" id="categoryId" name="categoryId" required>

    <label for="newCategoryName">New Category Name:</label>
    <input type="text" id="newCategoryName" name="newCategoryName" onchange="removeRequired()">
  </div>

  <div class="action-buttons">
  <input type="submit" name="addCategory" value="Add Category">
  <input type="submit" name="updateCategory" value="Update Category" onclick="removeRequired()">
    <input type="submit" name="deleteCategory" value="Delete Category">
  </div>
</form>

<script>
  function removeRequired() {
    document.getElementById("categoryName").removeAttribute("required");
  }
</script>

<div class="category-table">
  <h2>Category Table</h2>
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Category Name</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include 'DbCon.php';

        function displayCategoryTable($conn) {
          $sql = "SELECT id, category_name FROM Categories";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row["id"] . "</td>";
              echo "<td>" . $row["category_name"] . "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='2'>0 results</td></tr>";
          }
        }

        displayCategoryTable($conn);
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>
</div>

  <!-- Tasks Details Form -->
  <div class="animate-scroll">
<form class="Tasks-actions" action="Tasks_handle_categories.php" method="POST">
  <div class="Tasks-details">
    <h2>Tasks Details</h2>
    <label for="TasksName">Tasks Name:</label>
    <input type="text" id="TasksName" name="TasksName" required>

    <label for="description">description:</label>
    <textarea id="description" name="description"></textarea>

    <label for="dueDate">Due Date:</label>
    <input type="date" id="dueDate" name="dueDate" required>

    <label for="status">Status:</label>

    <select id="status" name="status">
      <option value="pending">Pending</option>
      <option value="completed">Completed</option>
    </select>

    <label for="categoryId">Category:</label>
    <select id="categoryId" name="categoryId" required>
<?php
 include 'DbCon.php';
  $query = "SELECT id FROM Categories"; 
  $result = mysqli_query($conn, $query);
   if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categoryId = $row['id']; 
        echo " <option value='$categoryId'>$categoryId</option>";
    }
}  else {
    echo "Error fetching categories: " . mysqli_error($conn);
}
mysqli_close($conn);
?>
</div>
  </div>

  <div class="action-buttons">
  <input type="submit" name="addTasks" value="Add Tasks">
  <input type="submit" name="updateTasks" value="Update Tasks">
     <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <label for="taskId">Task ID (for deletion):</label>
            <input type="text" id="taskId" name="taskId">
            <input type="submit" name="deleteTasks" value="Delete Tasks">
        </div>
  </div>
</form>



<div class="Tasks-table">
  <h2>Tasks Table</h2>
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>Task Id</th>
          <th>Task Name</th>
          <th>Description</th>
          <th>Due_date</th>
          <th>Status</th>
          <th>Category_Id</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include 'DbCon.php';

        function displayTasksTable($conn) {
          $sql = "SELECT id, task_name, description, due_date, status, category_id FROM Tasks";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row["id"] . "</td>";
              echo "<td>" . $row["task_name"] . "</td>";
              echo "<td>" . $row["description"] . "</td>";
              echo "<td>" . $row["due_date"] . "</td>";
              echo "<td>" . $row["status"] . "</td>";
              echo "<td>" . $row["category_id"] . "</td>";
             
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='2'>0 results</td></tr>";
          }
        }

        displaytasksTable($conn);
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>
</div>
 

  
  

</body>
</html>
