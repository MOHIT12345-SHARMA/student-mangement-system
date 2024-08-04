<?php 

include 'connection.php'; 

// Establish database connection
$dbs = new Connection();
$conn = $dbs->connect();

if($_SERVER["REQUEST_METHOD"] == 'POST'){
    // retrieve form input data
    $uName = $_POST['userName']; 
    $uPass = $_POST['userPassword']; 

    // validate login authentication
    $sql = "SELECT * FROM user WHERE User_Name = '$uName' AND Password = '$uPass' "; 

 

    // execute or run a query
    $result = $conn->query($sql); 
    // echo 'num_rows ' . $result->num_rows;

    if($result->num_rows >= 1) {  // our input userName and password match with database userName and password then allow user to login
        while($row = $result->fetch_assoc()) {
            $roleId = $row['role_id'];
            $Name = $row['Name']; // Capture the user's name
        }
       
        session_start();
        $_SESSION['loggedIn'] = TRUE;
        $_SESSION['userRole'] = $roleId;

        // Set welcome message
        $_SESSION['message'] = "Welcome :- " .$Name;
        $_SESSION['alertType'] = "info";

        // $_SESSION['UserStatus'] = $roleStatus;
        header("Location: http://localhost/assignments/assignment1/display.php");
    }
    else{ 
        // login failed
        $_SESSION['errorMessage'] = "Invalid username or password, please check it and try again.";
       
    } 
} 

if(isset($_SESSION['errorMessage'])){ 
    $errorMessage = $_SESSION['errorMessage']; 
} else { 
    $errorMessage = ''; 
} 
?>

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Authenticate</title> 
</head> 
<body> 
   
    <div class="container mt-5"> 
        <div class="row justify-content-center">
            <div class="col-md-6">
            <h1 class="text-center"> Login As User Or Admin</h1>
            <?php if($errorMessage != ''): ?> 
                <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-center  align-items-center" role="alert"> 
                    <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                    <div><?php echo $errorMessage; ?></div> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?> 
                <form action="authenticate.php" method="POST" id="myForm"> 
                    <div class="mb-3"> 
                        <label for="userName" class="form-label">Username</label> 
                        <input type="text" class="form-control" id="userName" name="userName" required> 
                    </div> 
                    <div class="mb-3"> 
                        <label for="userPassword" class="form-label">Password</label> 
                        <input type="password" class="form-control" id="userPassword" name="userPassword" required> 
                    </div> 
                    <div class="btn-block text-center">
                        <button type="submit" class="btn btn-primary mt-3">Login</button>
                        <button type="button" class="btn btn-danger mt-3 mx-2" onclick="resetFormData(event)">Reset</button>
                    </div> 
                </form> 
            </div>
        </div>    
        
    </div> 
    <script> 
        function resetFormData(event){
            event.preventDefault();
            const form = document.getElementById('myForm');
            form.reset();
        } 
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
</body> 
</html>

