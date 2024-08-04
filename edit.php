<?php
// Include function file
include_once("crud_Operation.php");

// Object creation
$updatedata = new crud_Operation();

if (isset($_POST['update'])) {
    // Get the userid
    $userid = intval($_GET['updateId']);

    // Posted Values
    $uName = $_POST['userName'];
    $fullName = $_POST['fullName'];
    $email = $_POST['userEmail'];
    $password = $_POST['userPassword'];
    $courseEnroll = $_POST['userCourse'];
    $mobileNumber = $_POST['contactInfo'];

    // Function Calling
    $sql = $updatedata->user_Update($uName, $fullName, $email, $password, $courseEnroll , $mobileNumber , $userid) ;

    // Message after updation
    echo "<script>alert('Record Updated successfully');</script>";

    // Code for redirection
    echo "<script>window.location.href='display.php'</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <!-- <h3>Update Record | PHP CRUD Operations using PHP OOP</h3> -->
                <h1 class="text-center text-secondary"> User Edit Form </h1>
            </div>
        </div>
        <?php
        // Get the userid
        $userid = intval($_GET['updateId']);
        $onerecord = new crud_Operation();
        $sql = $onerecord->user_FetchOneRecord($userid);
        $cnt = 1;
        while ($row = mysqli_fetch_array($sql)) {
            ?>
            <form name="insertrecord" method="post">
                <div class="container mt-3">
                   
                    <div class="row justify-content-center">
                        <div class="col-md-4"><b>User Name</b>
                            <input type="text" name="userName" value="<?php echo htmlentities($row['User_Name']); ?>" class="form-control" required>
                        </div>
                        <div class="col-md-4"><b>Full Name</b>
                            <input type="text" name="fullName" value="<?php echo htmlentities($row['Name']); ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="row justify-content-center my-3">
                        <div class="col-md-4"><b>Email id</b>
                            <input type="email" name="userEmail" value="<?php echo htmlentities($row['Email']); ?>" class="form-control" required>
                        </div>
                        <div class="col-md-4"><b>Password</b>
                        <input type="password" class="form-control" value="<?php echo htmlentities($row['Password']); ?>" id="userPassword" name="userPassword" onclick="validatePassword()" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                        <label for='fName' class="form-label"> Course Enrolled </label>
                    <select class="form-select" aria-label="Default select example" name="userCourse" required>
                        <option selected>Select Course</option>
                        <option value="Discrete Mathematics">Discrete Mathematics</option>
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
                        <div class="col-md-4"><b>Mobile Number</b>
                        <input type="tel" class="form-control" id="contactInfo" value="<?php echo htmlentities($row['Contact_Info']); ?>"  name="contactInfo" pattern="[789][0-9]{9}" title="Please enter a 10-digit mobile number starting with 7, 8, or 9" required>
                        </div>
                    </div>
                  
                    
                </div>
               
               
                <?php
            }
            ?>
           
                <div class="text-center">
                     <input type="submit" name="update" value="Update" class="mt-4 btn btn-primary">
                </div>
                   
               
          
        </form>
    </div>
</div>
</body>
</html>
