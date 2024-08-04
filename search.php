<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<style>
        .action{
            transform: translateX(-10%);
        }
        .btn{
            margin-left: -10px;
        }
</style>
    <title>Filter Table</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <button class="btn btn-primary mt-4 me-">
                <a href="display.php" class="text-white text-decoration-none">Display Page</a>
            </button>
        </div>
    </div>

    <div class="row">
        <table class="table border table-hover mt-3"> 

            <thead class="bg-secondary"> 
                <tr class="text-light fw-lighter">
                    <th class="fw-normal">Sr. No</th>
                    <th class="fw-normal">Name</th>
                    <th class="fw-normal">User Name</th>
                    <th class="fw-normal">Email</th>
                    <th class="fw-normal">Mobile No.</th>
                    <th class="fw-normal">Course Enrolled</th>
                    <th class="text-center action fw-normal">Action</th>
                </tr>
            </thead>
            <tbody> 
                <tr> 
                    <?php
                        require_once 'connection.php';

                        // Create a new instance of the Connection class
                        $connection = new Connection();
                        $conn = $connection->connect();

                        if (isset($_GET['search'])) {
                            $search = $_GET['search'];
                            
                            // Sanitize the input to prevent SQL injection
                            $search = mysqli_real_escape_string($conn, $search);

                            // Perform a search query
                            $sql_query = "SELECT * FROM user WHERE Name LIKE '%$search%' OR User_Name LIKE '%$search%' OR Email LIKE '%$search%' OR Course_Enrolled LIKE '%$search%'";
                            $result = mysqli_query($conn, $sql_query);

                            if ($result) {
                                $count = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr> 
                                        <td> '.$count.' </td>
                                        <td>' . $row["Name"] . '</td>
                                        <td>' . $row["User_Name"] . '</td>
                                        <td>' . $row["Email"] . '</td>
                                        <td>' . $row["Contact_Info"] . '</td>
                                        <td>' . $row["Course_Enrolled"] . '</td>
                                        <td>
                                            <a href="edit.php?updateId=' . $row['Id'] . '" class=" mx-3 text-decoration-none"><i class="bi bi-pencil fs-4"></i></a>
                                            <a href="delete.php?deleteId=' . $row['Id'] . '" class=" text-danger text-decoration-none delete-btn"><i class="bi bi-trash3 fs-4"></i></a>
                                        </td>
                                    </tr>
                                    <br/>';

                                    $count++;
                                }
                            } else {
                                echo "No results found.";
                            }
                        } else {
                            echo "Search term not set.";
                        }

                    ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>


</body>
</html>

