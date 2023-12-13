<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Task Manager</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel ="stylesheet" href ="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

  <style>
    .moving-text {
      display: inline-block;
      animation: moveLeftToRight 10s linear infinite;
    }

    @keyframes moveLeftToRight {
      0% { transform: translateX(-100%); }
      100% { transform: translateX(100vw); }
    }

    .heading {
      display: inline-block;
      animation-duration: 2s; /* Change duration as needed */
      animation-fill-mode: forwards; /* Keeps the last keyframe state */
    }

    .rotate {
      animation: rotateOnce 2s ease forwards;
    }

    @keyframes rotateOnce {
      from {
        transform: rotate(0deg);
      }
      to {
        transform: rotate(360deg);
      }
    }

    body {
  background-color: #f5f5f5; 
}

    .bg-light-gray {
  background-color: #f2f2f2; 
}
</style>


</head>

<script>

        <?php
        session_start();
        if (isset($_SESSION['success_message'])) {
            ?>
            window.onload = function() {
                alert("<?php echo $_SESSION['success_message']; ?>");
            }
            <?php
            
            unset($_SESSION['success_message']);
        }
        ?>

    </script>

<body>

<header style="background-color: #007bff; color: white; padding: 20px;">
<h1 class="moving-text animate__animated animate__fadeIn">Tasks Manager</h1>

  </header>
    <br>
    
    <div class="container border p-4 bg-info animate__animated animate__fadeIn">
        <div class="row">
        <h1 class="heading animate__animated animate__fadeInDown rotate">Categories</h1>

            <form method="POST" action="Add_Category.php">
                <div class="col-8">
                <input type="text" name="Category_ID" class="form-control" placeholder="Catergory ID">
                <input type="text" name="Category_Name" class="form-control" placeholder="Category Name">
                </div>
                <div >
                <button type="submit" class="btn btn-primary" name="add">Add</button>
                </div>
            </form>      
        </div>
    </div>
   

   

    <?php
    include "DbCon.php";
    $sql= "SELECT * from Categories";
    $result = $conn->query($sql);
    ?>

<div class="container border p-4 bg-light-gray animate__animated animate__fadeIn">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td>
                    <button class="btn btn-primary btn-sm updateBtn" data-id="<?php echo $row['id']; ?>">Update</button>
                        <a class="btn btn-warning btn-sm" href="Delete_Category.php?ID=<?php echo $row['id']; ?>" role="button" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.updateBtn').click(function() {
            var id = $(this).data('id');
            var newCategoryID = prompt("Enter new Category ID:");
            var newCategoryName = prompt("Enter new Category Name:");

            if (newCategoryID !== null && newCategoryName !== null) {
                $.ajax({
                    type: 'POST',
                    url: 'update_record.php',
                    data: { id: id, newCategoryID: newCategoryID, newCategoryName: newCategoryName },
                    success: function(response) {
                        alert(response); 
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
    
<br>
    
    <div class="container border p-4 bg-info mt-4 animate__animated animate__fadeIn">
        <div class="row">
        <h1 class="heading animate__animated animate__fadeInDown rotate" style="animation-delay: 1s">Tasks</h1>

            <form method="POST" action="Add_Task.php">
                <div class="col-8">
    
                <input type="text" name="Tasks_Name" class="form-control" placeholder="Task Name">
                <input type="text" name="Description" class="form-control" placeholder="Description">
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
                        </select>
                </div>
                <div >
                <button type="submit" class="btn btn-primary" name="add">Add</button>
                </div>
            </form>
                
        </div>


    </div>

    <?php
    include "DbCon.php";
    $sql= "SELECT * from Tasks";
    $result = $conn->query($sql);
    ?>

<div class="container border p-4 bg-light-gray mt-4 animate__animated animate__fadeIn">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tasks Name</th>
                <th>Description</th>
                <th>Due date</th>
                <th>Status</th>
                <th>Category Id</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['task_name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['due_date']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['category_id']; ?></td>
                    <td>
                    <button class="btn btn-primary btn-sm updateTaskBtn" data-id="<?php echo $row['id']; ?>">Update</button>
                        <a class="btn btn-warning btn-sm" href="Delete_Tasks.php?ID=<?php echo $row['id']; ?>" role="button" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.updateTaskBtn').click(function() {
            var id = $(this).data('id');
            var newTaskName = prompt("Enter new Task Name:");
            var newDescription = prompt("Enter new Description:");
            var newDueDate = prompt("Enter new Due Date:");
            var newStatus = prompt("Enter new Status:");
            var newCategoryID = prompt("Enter new Category ID:");

            if (newTaskName !== null && newDescription !== null && newDueDate !== null && newStatus !== null && newCategoryID !== null) {
                $.ajax({
                    type: 'POST',
                    url: 'update_tasks.php',
                    data: {
                        id: id,
                        newTaskName: newTaskName,
                        newDescription: newDescription,
                        newDueDate: newDueDate,
                        newStatus: newStatus,
                        newCategoryID: newCategoryID
                    },
                    success: function(response) {
                        alert(response); 
                        location.reload(); 
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>

</body>