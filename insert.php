
<?php
// Include database connection file
include 'crud_operation.php';

// Object creation
$insertdata = new crud_operation();

// Fetch role_status values from database
$roles = $insertdata->getRoles();

$defaultRoleId = 3;

if (isset($_POST['insertUser'])) {
    // Posted Values
    $uName = $_POST['userName'];
    $fullName = $_POST['fullName'];
    $email = $_POST['userEmail'];
    $role_id = $_POST['userRole'];
    $password = $_POST['userPassword'];
    $courseEnroll = $_POST['userCourse'];
    $mobileNumber = $_POST['contactInfo'];

    // Function Calling
    // $sql = $insertdata->user_Insert($uName, $fullName, $email, $password, $courseEnroll , $mobileNumber);
    $sql = $insertdata->register_user($uName, $fullName, $email, $password, $courseEnroll , $mobileNumber,$role_id);

    if ($sql) {
        // Message for successful insertion
        echo "<script>alert('Record inserted successfully');</script>";
        echo "<script>window.location.href='display.php'</script>";
    } else {
        // Message for unsuccessful insertion
        echo "<script>alert('Something went wrong. Please try again');</script>";
        echo "<script>window.location.href='index.php'</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Add User</title>
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1> Insert User </h1>
                <form action="insert.php" method="post" id="myForm">
                    <div class="userName-block mt-4">
                        <label for='uName' class="form-label"> User Name <span class=text-danger>*</span> </label>
                        <input type="text" class="form-control" id="uName" name="userName" required />
                    </div>
                    <div class="userName-block mt-2">
                        <label for='fName' class="form-label"> Name </label>
                        <input type="text" class="form-control" id="fName" name="fullName"/>
                    </div>
                    <div class="userName-block mt-2">
                        <label for='uEmail' class="form-label"> Email </label>
                        <input type="email" class="form-control" id="uEmail" name="userEmail"/>
                    </div>
                    <div class="userName-block mt-2">
                        <label for='uPass' class="form-label"> Password <span class=text-danger>*</span></label>
                        <input type="password" class="form-control" id="uPass" name="userPassword" onclick="validatePassword()" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                    </div>
                    <div class="user-role-block mt-3">
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
                <div class="course_enroll-block mt-3">
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
                   
                    <div class="userName-block mt-3">
                        <label for='uName' class="form-label"> Mobile Number </label>
                        <input type="tel" class="form-control" id="contactInfo" name="contactInfo" pattern="[789][0-9]{9}" title="Please enter a 10-digit mobile number starting with 7, 8, or 9" >
                    </div>
                    <div class="btn-block text-center">
                        <button type="submit" class="btn btn-primary mt-3" name="insertUser">Insert</button>
                        <button type="button" class="btn btn-danger mt-3 mx-2" onclick="resetFormData(event)">Reset</button>
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
</body>
</html>

