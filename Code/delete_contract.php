<?php
    /*
     * @author LI Qi
     * This php just implements the delete function
     */
    
    //including the database connection file
    include("config.php");
    
    //getting id of the data from the main page through the method Get
    $id = $_GET['id'];
    
    //delete the row by id
    $result = mysqli_query($mysqli, "DELETE FROM Contracts WHERE id=$id");
    
    //return to the main page
    header("Location:contract.php");
    ?>
