<?php
session_start();
// Include database connection file
include 'crud_operation.php';

// Object creation
$insertdata = new crud_operation();

// Fetch role_status values from database
$roles = $insertdata->getRoles();

$alertMessage = '';
$alertType = '';
$message = '';
$defaultRoleId = 3;

if (isset($_POST['registerUser'])) {
    // Posted Values
    $uName = $_POST['userName'];
    $fullName = $_POST['fullName'];
    $email = $_POST['userEmail'];
    $password = $_POST['userPassword'];
    $role_id = $_POST['userRole'];
    $courseEnroll = $_POST['userCourse'];
    $mobileNumber = $_POST['contactInfo'];

    if ($role_id == 'Select User Role') {
        $role_id = 2; // Set default role_id to 2 if not selected
    } else {
        $role_id = (int)$role_id; // Convert role_id to integer
    }

    // Check if userName already exists
    $existingUsers = $insertdata->getExistingUsers();
    if (in_array($uName, $existingUsers)) {
        $alertMessage = 'User already registered';
        $alertType = 'danger';
    } else {
        // Function Calling
        $sql = $insertdata->register_user($uName, $fullName, $email, $password, $courseEnroll, $mobileNumber, $role_id);
        if ($sql) {
             // Set session message for successful insertion
             $_SESSION['message'] = 'User Register Successfully';
             $_SESSION['alertType'] = 'success';
             header('Location: userLogin.php');
             exit();
        } else {
            // Message for unsuccessful insertion
            $alertMessage = 'Something went wrong. Please try again';
            $alertType = 'danger';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>SignUp User</title>
</head>
<body>
    <div class="container mt-4">
        <?php if ($alertMessage): ?>
            <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert">
                <?php echo $alertMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="register.php" method="post" id="myForm">
            <h1 class="text-center"> User Registration </h1>
            <div class="row justify-content-center mt-5">
                <div class="col-md-5">
                    <label for='uName' class="form-label"> User Name </label>
                    <input type="text" class="form-control" id="uName" name="userName" required/>
                </div>
                <div class="col-md-5">
                    <label for='fName' class="form-label"> Name </label>
                    <input type="text" class="form-control" id="fName" name="fullName" required/>
                </div>
            </div>

            <div class="row justify-content-center my-3">
                <div class="col-md-5">
                <label for='userRole' class="form-label"> Choose Role </label>
                <select class="form-select" id="userRole" name="userRole" aria-label="Default select example" required>
                    <option value="" disabled>Select User Role</option>
                    <?php foreach ($roles as $role) { ?>
                    <option value="<?php echo $role['role_id']; ?>" <?php echo $role['role_id'] == $defaultRoleId ? 'selected' : ''; ?>>
                    <?php echo $role['role_name']; ?>
                    </option>
                    <?php } ?>
                </select>
                </div>

                <div class="col-md-5">
                    <label for='uEmail' class="form-label"> Email </label>
                    <input type="email" class="form-control" id="uEmail" name="userEmail" required/>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-5">
                    <label for='uPass' class="form-label"> Password </label>
                    <input type="password" class="form-control" id="userPassword" name="userPassword" onclick="validatePassword()" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,12}" title="Must contain at least one number and one uppercase letter, and at least 8 to 12 characters" required>
                </div>
                <div class="col-md-5">
                    <label for='fName' class="form-label"> Course Enrolled </label>
                    <select class="form-select" aria-label="Default select example" name="userCourse" required>
                        <!-- <option selected></option> -->
                        <option value="Discrete Mathematics" selected>Discrete Mathematics</option>
                        <option value="Frontend Development">Frontend Development</option>
                        <option value="Backend Development">Backend Development</option>
                        <option value="Zoology">Zoology</option>
                        <option value="Data Structure">Data Structure</option>
                        <option value="Algorithm">Algorithm</option>
                        <option value="Numerology">Numerology</option>
                        <option value="Astrology">Astrology</option>
                        <option value="Bio Mechanics">Bio Mechanics</option>
                    </select>
                </div>
            </div>

            <div class="row justify-content-center my-3">
                <div class="col-md-5">
                    <label for='uName' class="form-label"> Mobile Number </label>
                    <input type="tel" class="form-control" id="contactInfo" name="contactInfo" pattern="[789][0-9]{9}" title="Please enter a 10-digit mobile number starting with 7, 8, or 9" required>
                </div>
                <div class="col-md-5"></div>
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-primary" name="registerUser">Register</button>  
                <button type="button" class="btn btn-danger my-3 mx-3" onclick="resetFormData(event)">Reset</button>
                <a href="userLogin.php"> <button type="button" class="btn btn-primary">Login</button> </a> 
            </div>
        </form>
    </div>

    <script> 
        function resetFormData(event){
            event.preventDefault();
            const form = document.getElementById('myForm');
            form.reset();
        } 
    
        document.addEventListener('DOMContentLoaded', function () {
            var alertList = document.querySelectorAll('.alert-dismissible');
            alertList.forEach(function (alert) {
                alert.querySelector('.btn-close').addEventListener('click', function () {
                    alert.classList.remove('show');
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuGaDkPWTyXX1ibVz5Urp/8lA8I26jwPGGim3x3t3mq4RxD1fG9UwFjq0KsF7i6F" crossorigin="anonymous"></script>
    
</body>
</html>
