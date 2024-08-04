<?php
// Check if a session is not already started before starting one
session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== TRUE) {
    header("Location: userLogin.php");
    exit;
}

if (isset($_SESSION['message']) && isset($_SESSION['alertType'])) {
    $message = $_SESSION['message'];
    $alertType = $_SESSION['alertType'];
    // Unset the session variables after using them
    unset($_SESSION['message']);
    unset($_SESSION['alertType']);
} else {
    $message = '';
    $alertType = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        .action {
            transform: translateX(-10%);
        }
        .input-group .form-control:focus {
            outline: none !important;
            box-shadow: none;
        }
        .btn3 {
            margin-left: 13.5rem;
        }
    </style>
    <title>User Display Page</title>
</head>
<body>

    <div class="container mt-3">
    <?php if ($message != '' && $alertType != ''): ?>
            <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert" id="alert-box">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">

            <div class="col-md-3">
                <button class="btn btn-primary mt-4">
                    <a href="insert.php" class="text-white text-decoration-none">Add User</a>
                </button>
            </div>

            <div class="col-md-6 mt-3 custom-input">
                <form action="search.php" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control fs-4" placeholder="Search..." name="search" id="myInput">
                        <button type="submit" class="input-group-text">
                            <a href="./search.php"> <i class="bi bi-search fs-4"></i> </a>
                        </button>
                    </div>
                </form>
            </div>

            <div class="col-md-3">
                <button class="btn btn3 btn-primary mt-4">
                    <a href="userLogin.php?logout=success" class="text-white text-decoration-none">Log Out</a>
                </button>
            </div>

        </div>
    
    <table class="table border table-hover mt-3"> 
        <thead class="bg-secondary"> 
            <tr class="text-light fw-lighter">
                <th class="fw-normal">Sr. No</th>
                <th class="fw-normal">Name</th>
                <th class="fw-normal">Role Type</th>
                <th class="fw-normal">Email</th>
                <th class="fw-normal">Mobile No.</th>
                <th class="fw-normal">Course Enrolled</th>
                <th class="text-center action fw-normal">Action</th>
            </tr>
        </thead>
        <tbody class="table-group-divider"> 
            <tr> 
                <?php

                    require_once 'connection.php';

                    // Create a new instance of the Connection class
                    $connection = new Connection();
                    $conn = $connection->connect();

                    if(isset($_GET['page'])){
                        $current_page = $_GET['page'];
                    } else {
                        $current_page = 1;
                    }
                    $records_per_page = 10;
                    $start_from = ($current_page - 1) * $records_per_page;

                    // Check user role and status
                    $userRole =  $_SESSION['userRole'];
                    // $userStatus = $_SESSION['UserStatus'];
             

                    
                    if($userRole == 1){ // admin 
                        $sql_query = "SELECT * FROM user WHERE role_id IN(1,2,3)  LIMIT $start_from , $records_per_page";
                        $total_rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user WHERE role_id IN(1,2,3)"));
                    }
                    else if ($userRole == 2) { // student 
                       
                        $sql_query =  "SELECT * FROM user WHERE role_id = 2 LIMIT $start_from , $records_per_page ";
                        $total_rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user WHERE role_id = 2"));

                    }
                    else { // teacher
                        $sql_query = "SELECT * FROM user WHERE role_id = 2 OR role_id = 3  LIMIT $start_from , $records_per_page";
                        $total_rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user WHERE role_id = 2 OR role_id = 3"));
                    }
                       
                

                    $result = mysqli_query($conn, $sql_query);
                
                   
                    
                    
                    $roles = Array('None' ,'Admin' , 'Student' , 'Teacher');
                    $total_pages = ceil($total_rows / $records_per_page);
                    
                    if($current_page == 1){
                        $count = 1;
                    } else {
                        $count = ($current_page - 1) * $records_per_page + 1;
                    }

                    while($row = mysqli_fetch_assoc($result)){
                        echo '<tr> 
                            <td> '.$count.' </td>
                            <td> '.$row["Name"].' </td>
                            <td> '.$roles[$row["role_id"]].' </td>
                            <td> '.$row["Email"].' </td>
                            <td> '.$row["Contact_Info"].' </td>
                            <td> '.$row["Course_Enrolled"].' </td>
                            <td>
                                <a href="edit.php?updateId=' . $row['Id'] . '" class=" mx-3 text-decoration-none"><i class="bi bi-pencil fs-4"></i></a>
                                <a href="delete.php?deleteId=' . $row['Id'] . '" class=" text-danger text-decoration-none delete-btn" onclick="return confirmDelete()"><i class="bi bi-trash3 fs-4"></i></a>
                            </td>
                        </tr>';
                        $count++;
                    }
                ?>
            </tr>
        </tbody>
    </table>
 
     <!-- bootstrap pagination -->
      <nav arial-label="pagination in employee records"> 
        <ul class="pagination pagination-lg justify-content-center"> 
            <?php if($current_page > 1): ?>
                <li class="page-item"> 
                    <a class="page-link" href="display.php?page=<?= $current_page - 1; ?>"> Previous </a>
                </li>
            <?php endif; ?>
            <?php for($page = 1; $page <= $total_pages; $page++):?>
                <li class="page-item <?= ($current_page == $page) ? 'active' : ''; ?>"> 
                    <a class="page-link" href="display.php?page=<?= $page; ?>"> <?= $page; ?> </a>
                </li>
            <?php endfor; ?>
            <?php if($current_page < $total_pages): ?>
                <li class="page-item"> 
                    <a class="page-link" href="display.php?page=<?= $current_page + 1;?>"> Next</a>
                </li>
            <?php endif; ?>
        </ul>
      </nav>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script>
        function getInputFieldValue(){
            const input = document.getElementById("myInput");
            const inputValue = input.value;
            console.log('input field value = ', inputValue);
        }
         // Hide the alert box after 5 seconds
         setTimeout(function() {
            const alertBox = document.getElementById('alert-box');
            if (alertBox) {
                alertBox.style.display = 'none';
            }
        }, 4000);
        function confirmDelete() {
            return confirm('Are you sure you want to delete this record?');
        }
    </script>
</body>
</html>
