<?php
session_start();

if (isset($_GET['logout']) && $_GET['logout'] == 'success'){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            You have successfully logged out.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}

if (isset($_SESSION['errorMessage'])){
    $errorMessage = $_SESSION['errorMessage'];
    unset($_SESSION['errorMessage']); // Clear the error message after using it
} else {
    $errorMessage = '';
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Login</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center"> Login As User Or Admin </h1>
                <?php if($errorMessage != ''): ?> 
                    <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-center  align-items-center" role="alert"> 
                        <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                        <div><?php echo $errorMessage; ?></div> 
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?> 

                <?php if ($message != '' && $alertType != ''): ?>
                    <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="authenticate.php" method="post" id="myForm">
                    <div class="userName-block mt-4">
                        <label for='uName' class="form-label"> User Name </label>
                        <input type="text" class="form-control" id="uName" name="userName" required/>
                    </div>
                    <div class="userPassword-block mt-3">
                        <label for="u_pass" class="form-label"> User Password </label>
                        <input type="password" class="form-control" id="u_pass" name="userPassword" required/>
                    </div>
                    <div class="btn-block text-center">
                        <button type="submit" class="btn btn-primary ">Login</button>
                        <button type="button" class="btn btn-danger my-5 mx-4" onclick="resetFormData(event)">Reset</button>
                        <a href="register.php"> <button type="button" class="btn btn-success" name="registerUser">Register</button> </a> 
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script> 
        function resetFormData(){
            event.preventDefault();
            const form = document.getElementById('myForm');
            form.reset();
        } 
    </script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
