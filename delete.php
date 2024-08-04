<?php
// Include function file
require_once 'crud_operation.php';

// Deletion
if (isset($_GET['deleteId'])) {
    // Getting deletion row id
    $rid = $_GET['deleteId'];
    $deletedata = new crud_operation();
    $sql = $deletedata->user_Delete($rid);
    
    if ($sql) {
        // Message for successful deletion
        $_SESSION['message'] = 'Record deleted successfully';
        $_SESSION['alertType'] = 'success';
    } else {
        $_SESSION['message'] = 'Failed to delete record';
        $_SESSION['alertType'] = 'danger';
    }
    header("Location: display.php");
    exit();


}
?>